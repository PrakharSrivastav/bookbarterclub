  $(document).ready(function() {
      $(".button-collapse").sideNav();
      $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 75, // Creates a dropdown of 15 years to control year
          format: "yyyy-mm-dd"
      });
      $("#owl-demo").owlCarousel({
          autoPlay: 3000, //Set AutoPlay to 3 seconds
          items: 4,
          itemsDesktop: [1199, 3],
          itemsDesktopSmall: [979, 2]
      });
      $("#owl-demo-sidebar").owlCarousel({
          autoPlay: 3000, //Set AutoPlay to 3 seconds
          items: 3,
          itemsDesktop: [1199, 3],
          itemsDesktopSmall: [979, 2]
      });
      $('select').material_select();
      var currentRequest = null;
      $('.search').keyup(function() {
          data = $(this).val();
          len = data.length;
          if (len > 2) {
              data = data.replace(/ /g, "+");
              currentRequest = jQuery.ajax({
                  url: base_url + "/" + data,
                  dataType: "json",
                  scriptCharset: "UTF-8",
                  beforeSend: function() {
                      if (currentRequest != null) {
                          currentRequest.abort();
                      }
                  },
                  success: function(a, b, c) {
                      result = $('.results');
                      result.empty();
                      books = a.search.results.work;
                      $.each(books, function(k, v) {
                          $template = "<a href='__href__' class='collection-item book-info avatar padding-none'>" + "<div class='div col s12'>" + "<img class='left img' src='__image__' alt=''>" + "<span class='span'>&nbsp;&nbsp;&nbsp;__title__<br/>&nbsp;&nbsp;&nbsp;Author - __author__<br/>&nbsp;&nbsp;&nbsp;Rating - __rating__</span><div style='float:clear'></div></div>" + "</a>";
                          if (v.best_book !== undefined) {
                              $template = $template.replace(/__title__/g, v.best_book.title.substring(0, 30) + "...");
                              $template = $template.replace(/__author__/g, v.best_book.author.name);
                              $template = $template.replace(/__href__/g, v.best_book.id);
                              $template = $template.replace(/__image__/g, v.best_book.small_image_url);
                              $template = $template.replace(/__rating__/g, v.average_rating);
                              result.append($template);
                          }
                      });
                  },
                  error: function(a, b, c) {
                      console.log(a);
                      console.log(b);
                      console.log(c);
                  }
              });
          }
      });
      $(document).click(function(e) {
          target = $(e.target);
          if (target.hasClass("book-info") || target.hasClass("div") || target.hasClass("img") || target.hasClass("span")) {
              href = "";
              if (target.hasClass("div")) {
                  href = target.parent().attr("href");
              } else if (target.hasClass('img') || target.hasClass("span")) {
                  href = target.parent().parent().attr("href");
              } else {
                  href = target.attr("href");
              }
              
              var currentRequestModal = null;
              if (href !== "" && href !== undefined) {
                  e.preventDefault();
                  currentRequestModal = jQuery.ajax({
                      url: book_url + "/" + href,
                      dataType: "json",
                      scriptCharset: "UTF-8",
                      beforeSend: function() {
                          $('body').data('referenced_object', undefined);
                          if (currentRequestModal != null) {
                              currentRequestModal.abort();
                          }
                      },
                      success: function(a, b, c) {
                          console.log(a);
                          // $('.results').empty();
                          template = "<div class='modal-footer yellow'><a class='have left modal-action black-text btn-flat'>&nbsp;&nbsp;[Have This]&nbsp;&nbsp;</a><a class='modal-action right btn-flat modal-close'><i class='material-icons'>&#xE5CD;</i></a><a class='modal-action btn-flat left black-text want'>&nbsp;&nbsp;[Want This]&nbsp;&nbsp;</a></div><div class='modal-content'><div class='row'><div class='col s12 m2'><img src='__image_url__' style='border:solid #000 1px;'></div><div class='col s12 m9 right padding-20'><h6>__title__</h6><hr ><div>Publisher : __publisher__</div><div>Ratings : __ratings__</div><div>Total reviews : __total_reviews__</div><div>authors : __authors__</div></div></div><div class='row'><div class='col s12'><p>Description : __description__</p><div>Reviews :__reviews__ </div></div></div></div>";
                          $('#modal1').empty();
                          if (a.image == "" || a.image == undefined) {
                              if (a.small_image == "" || a.small_image == undefined) {
                                  template = template.replace(/__image_url__/g, 'https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png');
                              } else {
                                  template = template.replace(/__image_url__/g, a.small_image);
                              }
                          } else {
                              template = template.replace(/__image_url__/g, a.image);
                          }
                          var author_names = "";
                          if (a.authors != undefined) {
                              $.each(a.authors, function(k, v) {
                                  if (k == 'name') {
                                      author_names += v + " ";
                                  }
                              });
                          }
                          template = template.replace(/__title__/g, a.title);
                          template = template.replace(/__publisher__/g, a.publisher);
                          template = template.replace(/__ratings__/g, a.average_rating);
                          template = template.replace(/__total_reviews__/g, a.text_reviews_count);
                          template = template.replace(/__authors__/g, author_names);
                          template = template.replace(/__description__/g, a.description);
                          template = template.replace(/__reviews__/g, a.reviews_widget);
                          template = template.replace(/565px/g, '100%');
                          template = template.replace(/565/g, '100%');
                          $('body').data('referenced_object', a);
                          $('#modal1').append(template);
                          $('#modal1').openModal();
                      },
                      error: function(a, b, c) {
                          console.log(a);
                          console.log(b);
                          console.log(c);
                          $('#modal1').closeModal();
                      }
                  });
              }
              return false;
          } else if (target.hasClass('want') || target.hasClass('have')) {
              post_data = $('body').data().referenced_object;
              if (target.hasClass('want')) 
                post_data.book_type_for_user = "wanted";
              else if (target.hasClass('have')) 
                post_data.book_type_for_user = "have";
              post_data._token = $("#this_token").val();
              $.ajax({
                  url: add_book,
                  type: "POST",
                  data: $('body').data().referenced_object,
                  success: function(a, b, c) {
                      if (a.status == 100 && a.message == "success") {
                          $('#modal1').closeModal();
                          Materialize.toast('Book added to the list', 4000);
                          setTimeout(function() {
                              location.reload()
                          }, 2000);
                      } else if (a.status == 98) {
                          $('#modal1').closeModal();
                          Materialize.toast(a.message, 4000);
                      } else if (a.status == 101) {
                          $result = $('.results');
                          $result.empty();
                          console.log(a.message.length);
                          if (a.message != undefined && a.message.length == 0) {
                              $result.append("<div class='padding-none margin-none yellow'><h7 class='left-align weight-300 padding-10'>No Results Found. Please add it here if you have a copy.</h7></div>");
                          } else {
                              $.each(a.message, function(k, v) {
                                  $template = "<a href='__user__' class='collection-item avatar user-info padding-none black-text weight-300'>" + "<div class='user-div padding-none col s12'>" + "<img class='left user-img padding-5' src='__image__' alt=''>" + "<span class='user-span'>&nbsp;&nbsp;&nbsp;__title__<br/>&nbsp;&nbsp;&nbsp;__author__<br/>&nbsp;&nbsp;&nbsp;__rating__</span><div style='float:clear'></div></div>" + "</a>";
                                  var img = v.img_path;
                                  if (img == "" || img == undefined || img == null) {
                                      img = base+'/img/logo_s.png';
                                  }
                                  console.log(v);
                                  $template = $template.replace(/__image__/g, img);
                                  $template = $template.replace(/__title__/g, v.firstname + " " + v.lastname);
                                  $template = $template.replace(/__author__/g, v.location_name);
                                  $template = $template.replace(/__rating__/g, "Distance - "+v.distance);
                                  $template = $template.replace(/__user__/g, v.id);
                                  $result.append($template);
                              });
                          }
                          $('#modal1').closeModal();
                      }
                      // return true;
                  },
                  dataType: "json",
                  error: function(a, b, c) {
                      console.log(a);
                      console.log(b);
                      console.log(c);
                      // $('#modal1').closeModal();
                  }
              });
              // return false;
          } 
          else if (target.hasClass("user-info") || target.hasClass("user-div") || target.hasClass("user-img") || target.hasClass("user-span")) {
            href = "";
              if (target.hasClass("user-div")) {
                  href = target.parent().attr("href");
              } else if (target.hasClass('user-img') || target.hasClass("user-span")) {
                  href = target.parent().parent().attr("href");
              } else {
                  href = target.attr("href");
              }
              // console.log(href);
              // console.log(show_user);
              new_url = show_user.replace(/__user__id__/g, href);
              new_url = new_url.replace(/__book__id__/g, $('body').data().referenced_object.id);
              // console.log(new_url);
              location.href = new_url;
              // console.log($('body').data().referenced_object.id);
              return false;
          }
          else {
              // $('.results').empty();
          }
          // return false;
      });
      $('.modal-trigger').leanModal();
  });
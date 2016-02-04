  $(document).ready(function() {
      $(window).load(function() {
          $('#preloader').fadeOut('slow', function() {
              $(this).remove();
          });
      });
      $(".button-collapse").sideNav();
      $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 75, // Creates a dropdown of 15 years to control year
          format: "yyyy-mm-dd"
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
              result = $('.results');
              // console.log(location_mine);
              if (location_mine == "" || location_mine == null || location_mine == undefined) {
                  Materialize.toast("Please save your location in the system before seaching for books.<br>Go to Profile > Edit Location to save your location preference.", 5000);
                  return false;
              }
              data = data.replace(/ /g, "+");
              currentRequest = jQuery.ajax({
                  url: base_url + "/" + data,
                  dataType: "json",
                  scriptCharset: "UTF-8",
                  beforeSend: function() {
                      if (currentRequest != null) {
                          currentRequest.abort();
                      }
                      preloader = "<div class='center-align padding-5'><div class='preloader-wrapper small active'><div class='spinner-layer spinner-yellow-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div></div>";
                      result.empty();
                      result.append(preloader);
                  },
                  success: function(a, b, c) {
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
                          count_fail = "<div class='red darken-2 padding-5 light center-align grey-text text-lighten-4'>Sorry !! No users around you have this book.<br/> Please 'Proceed' to see more options.</div>";
                          count_success = "<div class='green padding-5 light center-align  grey-text text-lighten-4'>Awesome !! __count__ match(es) found for this book.<br/> Please 'Proceed' to see more details.</div>";
                          template = "<div class='modal-footer row red darken-2' style='height:auto !important'>" + "<h5 class='red darken-2 modal-action col s11 left light grey-text text-lighten-4'>__title__: by __authors__</h5><a class='modal-action col s1 right btn-flat modal-close grey-text text-lighten-4'><i class='material-icons right'>&#xE5CD;</i></a>" + "<div class='red darken-2' style='clear:both'></div></div>" + "<div class='modal-content'>" + "<div class='row padding-5'>" + "<div class='col s4 m2'>" + "<img src='__image_url__' style='border:solid #000 1px;'>" + "</div>" + "<div class='col s7 right m10 padding-left-20'>" + "<div>__title__</div>" + "<div>Publisher : __publisher__</div>" + "<div>Ratings : __ratings__</div>" + "<div>Total reviews : __total_reviews__</div>" + "<div>authors : __authors__</div>" + "</div>" + "<div style='clear:both'></div><div>" + "<div class='row'>" + "<div class='col s12 m8 margin-top-5'>" + "__count__" + "</div>" + "<div class='col s12 m4 margin-top-5'>" + "<a class='btn btn-block btn-large green proceed'>Proceed</a>" + "</div>" + "</div>" + "<div class='row'>" + "<div class='col s12'>" + "<p class='weight-300'>Description : __description__</p>" + "<div class='weight-300'>Reviews :__reviews__ </div>" + "</div>" + "</div>" + "</div>";
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
                          if (a.title != "") template = template.replace(/__title__/g, a.title);
                          else template = template.replace(/__title__/g, "");
                          if (a.publisher != "") template = template.replace(/__publisher__/g, a.publisher);
                          else template = template.replace(/__publisher__/g, "");
                          if (a.average_rating != "") template = template.replace(/__ratings__/g, a.average_rating);
                          else template = template.replace(/__ratings__/g, "0");
                          if (a.text_reviews_count != "") template = template.replace(/__total_reviews__/g, a.text_reviews_count);
                          else template = template.replace(/__total_reviews__/g, "0");
                          if (author_names != "") template = template.replace(/__authors__/g, author_names);
                          else template = template.replace(/__authors__/g, "");
                          if (a.description != "") template = template.replace(/__description__/g, a.description.substring(0, 100) + "<a class='btn-flat red-text proceed'>&nbsp;&nbsp;read more </a>");
                          else template = template.replace(/__description__/g, "");
                          if (a.reviews_widget != "") template = template.replace(/__reviews__/g, a.reviews_widget);
                          else template = template.replace(/__reviews__/g, "");
                          if (a.count == 0) template = template.replace(/__count__/g, count_fail);
                          else {
                              count_success = count_success.replace(/__count__/g, a.count);
                              template = template.replace(/__count__/g, count_success);
                          }
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
          } else if (target.hasClass('proceed')) {
              location.href = show_user.replace(/__book__id__/g, $('body').data().referenced_object.id);
          } else {
              // $('.results').empty();
          }
          // return false;
      });
      $('.modal-trigger').leanModal();
      $.ajax({
          url: unreadCount,
          type: 'GET',
          dataType: 'json',
      }).done(function(a) {
          cnt = $(".message_count");
          if(a.length > 0){
            cnt.empty();
            cnt.text(a.length);
          }
          else{
            cnt.empty();
          }
      }).fail(function(a) {
          cnt.empty();
      });
  });
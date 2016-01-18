$(document).ready(function($) {
    // Section to handle the trending books
    $("#owl-demo").owlCarousel({
        autoPlay: 3000,
        items: 6,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 2]
    });
    $("#pac-input").val("");
    // handle fetching of results in your area
    var currentRequest = null;
    $('.search').keyup(function() {
        data = $(this).val();
        console.log(loc);
        len = data.length;
        if (len > 2) {
            if (loc == "" || loc == undefined) {
                Materialize.toast('Please setup your location before searching for books!', 500);
                return false;
            } else {
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
                        console.log(a);
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
            // new_url = book_url.replace(/__BOOK__ID__/g, href);
            new_loc = loc.replace("(", "").replace(")", "").replace(" ", "");
            new_loc = new_loc.split(",");
            latitude = new_loc[0];
            longitude = new_loc[1];
            var theNewAjaxRequest = null;
            if (href !== "" && href !== undefined) {
                e.preventDefault();
                theNewAjaxRequest = jQuery.ajax({
                    url: book_url,
                    method: "POST",
                    data: {
                        book: href,
                        latitude: latitude,
                        longitude: longitude,
                        _token: $("#csrf_t").val()
                    },
                    dataType: "json",
                    scriptCharset: "UTF-8",
                    beforeSend: function() {
                        $('body').data('referenced_object', undefined);
                        if (theNewAjaxRequest != null) {
                            theNewAjaxRequest.abort();
                        }
                    },
                    success: function(a, b, c) {
                        console.log(a);
                        if (a.code !== 100 && a.message !== "success") {
                            var $toastContent = $('<span>No one near you has this book. Please search another book</span>');
                            Materialize.toast($toastContent, 3000);
                        } else {
                            alert("book found");
                            nearest_user = nearest_user.replace(/__book_id__/g, href);
                            location.href = nearest_user;
                        }
                    },
                    error: function(a, b, c) {
                        console.log(a);
                        console.log(b);
                        console.log(c);
                    }
                });
            }
            return false;
        } else {}
    });
});
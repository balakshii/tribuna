jQuery(function ($) {
    var tribuna = {
        init: function () {
            var that = this;

            var slider = $('.slider.owl-carousel').owlCarousel({
                items: 1,
                loop: true,
                smartSpeed: 1000,
                nav: false,
                autoplayTimeout: 8000,
                autoplay: true,
                responsive:{
                    1280 :{
                        nav: true
                    }
                }
            });
            slider.on('changed.owl.carousel', function(event) {
                item = $(".slider__item")[event.item.index];
                itemId = $(item).attr("data-postid");
                $(".lastPosts__listItems").removeClass("active");
                $(".lastPosts__listItems[data-postid='"+itemId+"']").addClass("active");
            });

            $('#currencyCarusel').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                smartSpeed: 300,
                mouseDrag:  false
            });
            $('.quote .owl-carousel').owlCarousel({
                items: 1,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
            });
            $('.banners .owl-carousel').owlCarousel({
                items: 1,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 10000,
                responsive: {
                    1280: {
                        dots: true
                    }
                }
            });
            $('#sidebarBanner .owl-carousel').owlCarousel({
                items: 1,
                dots: false,
                loop: true,
                autoplay: true,
                autoplayTimeout: 10000,
                responsive: {
                    1280: {
                        dots: true
                    }
                }
            });
            //like click
            $(".postItemCommentItem__like").click(function () {
                that.addLike($(this));
                return false;
            });
            //like click

            //load more click
            $("[data-load-more]").click(function () {
                that.loadMore($(this));
                return false;
            });
            //load more click

            //search click
            $(".searchControl").click(function () {
                that.searchBox();
                return false;
            });
            //search click

            //navControl click
            $(".navControl").click(function () {
                that.mobileMenuBox($(this));
            })
            $(".header .btn-close").click(function () {
                $(".mobileMenuBox").css("display", "none");
                $("body").removeClass("overflow");
                $(".navControl").show();
                $(this).hide();
            });
            $(document).keyup(function(e) {
                if (e.key === "Escape") {
                    $(".fal.fa-chevron-left").click();
                }
            });
            //navControl click

            //newsTabs
            // $(".lastPosts__control button").click(function () {
            //     $(".lastPosts__control button").toggleClass("active");
            //     $(".lastPosts__listItems").toggleClass("active");
            // });

            $(".lastPosts__listItems").niceScroll();

            $(".lastPosts .lastPosts__prev").click(function () {
                $('.lastPosts__listItems.active').stop().animate(
                    {
                        scrollTop: $('.lastPosts__listItems.active').scrollTop() - 115
                    },
                    300);
                return false;
            });
            $(".lastPosts .lastPosts__next").click(function () {
                $('.lastPosts__listItems.active').stop().animate(
                    {
                        scrollTop: $('.lastPosts__listItems.active').scrollTop() + 115
                    },
                    300);
                return false;
            });
        },
        mobileMenuBox: function (item) {
            $(item).hide();
            $("body").toggleClass("overflow");
            if ($(".mobileMenuBox").css("display") == "block"){
                $(".mobileMenuBox").css("display", "none");
            }else{

                $(".mobileMenuBox").css("display", "block");
            }
            $(".header .btn-close").show();


        },
        searchBox: function () {
            $("body").prepend("<div class='searchBox'><button class=\"fal fa-chevron-left\"></button><form action='/' method='get'><input type='text' name='s' placeholder='Пошук' required/><button class='fal fa-search'></button></form></div>");
            $("body").addClass("overflow");
            $(".searchBox .fa-chevron-left").click(function () {
                $(".searchBox").remove();
                $("body").removeClass("overflow");
            });
            $("input[name=s]").focus();

        },
        loadMore: function (item) {
            $(item).addClass("load");
            var items = [];

            var data = {
                action: 'get_posts',
                rendered: []
            };
            if ($(item).attr("data-page-type")) {
                data["pageType"] = $(item).attr("data-page-type");
            }
            if ($(item).attr("data-author-id")) {
                data["authorId"] = $(item).attr("data-author-id");
            }
            if ($(item).attr("data-tag-id")) {
                data["tagId"] = $(item).attr("data-tag-id");
            }
            if ($(item).attr("data-catogory-id")) {
                data["categoryId"] = $(item).attr("data-catogory-id");
            }

            $('.excluded_area [data-postid]').each(function (i, e) {
                data.rendered.push($(e).attr('data-postid'));
            });
            if ($(item).attr('data-page-type') == 'search') {
                data["search_query"] = $(item).attr('data-search-query');
            }
            if ($(item).attr('data-page-type') == 'category' || $(item).attr('data-page-type') == 'search') {
                $.post(myajax.url, data, function (response) {

                    var html = "";
                    html += response;
                    items.push(html);
                    $("#posts-2").append(items);
                    $(item).removeClass("load");
                    $('html').animate(
                        {
                            scrollTop: $('html').scrollTop() + 1000
                        },
                        300);


                    if ($('[data-postid]').length >= parseInt($(item).attr("data-count-posts"))) {
                        $(item).remove();
                    }


                });
            } else {
                $.post(myajax.url, data, function (response) {

                    var html = "<div class='row'>";
                    html += response;
                    html += "</div>";
                    items.push(html);
                    $("#posts-2").append(items);
                    $(item).removeClass("load");

                    $('html').animate(
                        {
                            scrollTop: $('html').scrollTop() + $(".postCard").height()
                        },
                        300);
                    if ($('[data-postid]').length >= parseInt($(item).attr("data-count-posts"))) {
                        $(item).remove();
                    }


                });
            }

        },
        addLike : function (item) {
            var data = {
                action: 'add_like',
                comment_id: $(item).attr("data-comment-id")
            };
            $.post(myajax.url, data, function (response) {
                response = JSON.parse(response);
                if (response.liked){
                    $(item).addClass("active");
                }else{
                    $(item).removeClass("active");
                }

                $(item).parent().find("span").html(response.like_count);
            });
        }
    }
    tribuna.init();
});
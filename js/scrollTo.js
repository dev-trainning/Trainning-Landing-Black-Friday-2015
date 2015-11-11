$(window).load(function () {
    $(document).on("scroll", onScroll);

    //smoothscroll

    $('.sf-menu').find('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        /*$(this).addClass('active');*/

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 2
        }, 1000, 'swing', function () {
            window.location.hash = target;
        });
    });
    $('.footer-menu').find('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        /*$(this).addClass('active');*/

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 2
        }, 1000, 'swing', function () {
            window.location.hash = target;
        });
    });
    $('.rd-mobilemenu_ul').find('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        /*$(this).addClass('active');*/

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 2
        }, 1000, 'swing', function () {
            window.location.hash = target;
        });
        if ($('.rd-mobilemenu').hasClass('active')) {
            $('.rd-mobilemenu').removeClass('active');
            $('.rd-mobilepanel_toggle').removeClass('active');
        }
    });
});


function onScroll(event) {
    var scrollPos = $(document).scrollTop();

    if(((scrollPos + $(window).height()) > ($(document).height() - 100)) &&
        $($('.sf-menu > li:last-child > a').attr('href')).length > 0
    ){
        $('.sf-menu li').removeClass("active");
        $('.sf-menu li:last-child').addClass("active");
        return;
    }

    $('.sf-menu').find('a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));

        if (refElement.length > 0) {
            if ((refElement.position().top - 150) <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                currLink.parent().parent().find('li').removeClass("active");
                currLink.parent().addClass("active");
            }
        }
    });

    if(((scrollPos + $(window).height()) > ($(document).height() - 100)) &&
        $($('.rd-mobilemenu_ul > li:last-child > a').attr('href')).length > 0
    ){
        $('.sf-menu li').removeClass("active");
        $('.sf-menu li:last-child').addClass("active");
        return;
    }

    $('.rd-mobilemenu_ul').find('a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));

        if (refElement.length > 0) {
            if ((refElement.position().top - 150) <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                currLink.parent().parent().find('li').removeClass("active");
                currLink.parent().addClass("active");
            }
        }
    });
}

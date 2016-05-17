$(function () {
    var getUrl = window.location;
    baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + (getUrl.host === 'localhost' ? 'new-qcsasia' : '');

    $('.btn-show-hide-text-area').on('click', function () {
        if ($('.hidden-text-area').css('display') == 'none') {
            $('.btn-show-hide-text-area').find('.glyphicon').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
        } else {
            $('.btn-show-hide-text-area').find('.glyphicon').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
        }
        $('.hidden-text-area').slideToggle();
    });
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).show();
        $(this).addClass('focus');
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).hide();
        $(this).removeClass('focus');
    });
    $('.carousel-home').carousel();
    $('.carousel-category, .carousel-function, .carousel-logo-process').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]});
    $('.gallery-container').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery: {enabled: true}
    });
    $('.filter-group-title').on('click', function () {
        if ($(this).find('span').hasClass('glyphicon-chevron-right')) {
            $(this).find('span').removeClass('glyphicon-chevron-right');
            $(this).find('span').addClass('glyphicon-chevron-down');
        } else {
            $(this).find('span').removeClass('glyphicon-chevron-down');
            $(this).find('span').addClass('glyphicon-chevron-right');
        }
        $('.group-' + $(this).data('group-title')).slideToggle();
    });
    $(window).scroll(function () {
        if ($('.block-list-products').length && $(window).width() >= 667) {
            if (($(window).scrollTop() - $('.block-list-products').offset().top) > 0) {
                if (($('#footer').offset().top - $(window).scrollTop() - $('.block-filter').height()) < 0) {
                    $('.block-filter').removeClass('fixed');
                    $('.block-filter').addClass('block-filter-bottom');
                } else {
                    $('.block-filter').addClass('fixed');
                }
            } else {
                $('.block-filter').removeClass('fixed');
                    $('.block-filter').removeClass('block-filter-bottom');
            }
        } else {
            $('.block-filter').removeClass('fixed');
        }
    });
});

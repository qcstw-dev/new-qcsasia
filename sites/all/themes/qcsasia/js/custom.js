$(function () {
    var getUrl = window.location;
    baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + (getUrl.host === 'localhost' ? 'new-qcsasia' : '');

    $('.btn-show-hide-text-area').on('click', function () {
        if ($('.hidden-text-area').css('display') == 'none') {
            $(this).find('.glyphicon').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
        } else {
            $(this).find('.glyphicon').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
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
    $('.carousel-category').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4
    });
    $('.carousel-function').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4
    });
    $('.carousel-logo-process').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4
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
        if ($('.block-list-products').length) {
            if (($(window).scrollTop() - $('.block-list-products').offset().top) > 0) {
                $('.block-filter').addClass('fixed');
            } else {
                $('.block-filter').removeClass('fixed');
            }
        }
    });
});

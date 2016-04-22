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
});

$(function() {
    $('.btn-show-hide-text-area').on('click', function () {
        console.log('totot');
       if ($('.hidden-text-area').css('display') == 'none') {
           $(this).find('.glyphicon').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
       } else {
           $(this).find('.glyphicon').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
       }
       $('.hidden-text-area').slideToggle();
    });
    $('ul.nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).show();
        $(this).addClass('focus');
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).hide();
        $(this).removeClass('focus');
    });
});

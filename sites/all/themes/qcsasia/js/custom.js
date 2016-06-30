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
    $('.menu-item').hover(function () {
        if (!$('.sub-menu-'+$(this).data('menu-item')).is(":visible")) {
            $('.sub-menu-'+$(this).data('menu-item')).stop(true, true).slideDown();
        }
    }, function () {
        $('.sub-menu-'+$(this).data('menu-item')).stop(true, true).slideUp();
    });
    $('.sub-menu').hover(function () {
        $(this).stop(true, true).show();
    }, function () {
        $(this).stop(true, true).hide();
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
    $('.popup').on('click', function () {
        $.magnificPopup.open({
            items: [{
                src: $('<div class="white-popup">' +
                        '<div class="thumbnail border-none"><img src="' + $(this).attr('src') + '" /></div>' +
                        '</div>'),
                type: 'inline'
            }]
        });
    });
});
function formValidators(form) {
    $('.' + form + ' .email').on('focusout', function () {
        if ($(this).prop('type') == 'email') {
            if (isEmail($(this).val())) {
                $(this).removeClass('form-control-danger');
                $('.' + form + ' .error-message-email').slideUp();
            } else {
                $(this).addClass('form-control-danger');
                $('.' + form + ' .error-message-email').slideDown();
            }
        }
    });
    $('.' + form + ' .required').on('select', function () {
        $('.' + form + ' .error-message-empty-field').slideUp();
    });
    $('.' + form + ' .required').on('focusout', function () {
        if ($(this).val()) {
            $(this).removeClass('form-control-danger');
        }
        $('.' + form + ' .required').each(function () {
            if ($('.' + form + ' .form-control-danger').length == 0) {
                $('.' + form + ' .error-message-empty-field').slideUp();
            }
        });
    });
    if ($('.' + form + ' .password').length) {
        $('.' + form + ' .password').on('focusout', function () {
            if ($('.' + form + ' .password').val().length < 6) {
                $('.' + form + ' .error-message-password-length').slideDown();
            } else {
                $('.' + form + ' .error-message-password-length').slideUp();
            }
        });
        $('.' + form + ' .password_confirm').on('focusout', function () {
            if (($('.' + form + ' .password').val() && $('.' + form + ' .password_confirm').val()) 
                && ($('.' + form + ' .password').val() != $('.' + form + ' .password_confirm').val())) {
                $('.' + form + ' .error-message-password').slideDown();
            } else {
                $('.' + form + ' .error-message-password').slideUp();
            }
        });
    }
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
function formSubmitValidator(form) {
    var valid = true;
    $('.' + form + ' .error-message').slideUp();
    $('.' + form + ' .required').each(function () {
        if ($(this).hasClass('required') && !$(this).val()) {
            $(this).addClass('form-control-danger');
            $('.' + form + ' .error-message-empty-field').slideDown();
            valid = false;
        } else if ($(this).prop('type') == 'email' && !isEmail($(this).val())) {
            $(this).addClass('form-control-danger');
            $('.' + form + ' .error-message-email').slideDown();
            valid = false;
        } else {
            $(this).removeClass('form-control-danger');
        }
    });
    if ($('.' + form + ' .password').length) {
        if ($('.' + form + ' .password').val().length < 6) {
            $('.' + form + ' .error-message-password-length').slideDown();
            valid = false;
        }
        if (($('.' + form + ' .password').val() && $('.' + form + ' .password_confirm').val()) 
                && ($('.' + form + ' .password').val() != $('.' + form + ' .password_confirm').val())) {
            $('.' + form + ' .error-message-password').slideDown();
            valid = false;
        }
    }
    if (!valid) {
        $('.' + form + ' .error-message-general').slideDown();
        return false;
    } else {
        return true;
    }
}


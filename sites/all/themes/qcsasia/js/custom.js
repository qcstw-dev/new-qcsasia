$(function () {
    var getUrl = window.location;
    baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + (getUrl.host === 'localhost' ? 'new-qcsasia/' : '');
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    $('.btn-show-hide-text-area').on('click', function () {
        if ($('.hidden-text-area').css('display') == 'none') {
            $('.btn-show-hide-text-area').find('.glyphicon').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
        } else {
            $('.btn-show-hide-text-area').find('.glyphicon').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
        }
        $('.hidden-text-area').slideToggle();
    });
    $(".bookmark").click(function(e){
        e.preventDefault(); // this will prevent the anchor tag from going the user off to the link
        var bookmarkUrl = $(this).data('url');
        var bookmarkTitle = $(this).data('title');
        if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
             openPopupInstruction();
             return false;
        } else if (window.sidebar) { // For Mozilla Firefox Bookmark
//            window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
             openPopupInstruction();
        } else if( window.external || document.all) { // For IE Favorite
            window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
        } else if(window.opera) { // For Opera Browsers
            $(".bookmark").attr("href",bookmarkUrl);
            $(".bookmark").attr("title",bookmarkTitle);
            $(".bookmark").attr("rel","sidebar");
        } else { // for other browsers which does not support
             openPopupInstruction();
             return false;
        }
    });
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).show();
        $(this).addClass('focus');
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).hide();
        $(this).removeClass('focus');
    });
    $('.menu-item').hover(function () {
        if (!$('.sub-menu-'+$(this).data('id')).is(":visible")) {
            $('.sub-menu-'+$(this).data('id')).stop(true, true).show();
        }
    }, function () {
        $('.sub-menu-'+$(this).data('id')).stop(true, true).hide();
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
//    $(window).scroll(function () {
//        if ($('.block-list-products').length && $(window).width() >= 667) {
//            if (($(window).scrollTop() - $('.block-list-products').offset().top) > 0) {
//                if (($('#footer').offset().top - $(window).scrollTop() - $('.block-filter').height()) < 0) {
//                    $('.block-filter').removeClass('fixed');
//                    $('.block-filter').addClass('block-filter-bottom');
//                } else {
//                    $('.block-filter').addClass('fixed');
//                }
//            } else {
//                $('.block-filter').removeClass('fixed');
//                $('.block-filter').removeClass('block-filter-bottom');
//            }
//        } else {
//            $('.block-filter').removeClass('fixed');
//        }
//    });
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
function listenAddToWishlistEvent() {
    $('.add-to-wishlist').click(function (){
        $(this).toggleClass('color-light-grey glyphicon-floppy-disk').toggleClass('glyphicon-floppy-saved');
        if ($(this).hasClass('glyphicon-floppy-saved')) {
            $(this).attr('title', 'Delete from wishlist').tooltip('fixTitle').tooltip('show');
        } else {
            $(this).attr('title', 'Add to wishlist').tooltip('fixTitle').tooltip('show');
        }
        addToWishlist($(this).data('id'));
    });
}
function addToWishlist(id) {
    var url = baseUrl+'add_to_wishlist?id='+id;
    $.ajax(url, {
        dataType: 'json',
        success: function (data) {
            if (!$('.wishlist-link').length) {
                $('.menu-list').prepend('\
                    <li class="wishlist-link">\n\
                        <a href="'+baseUrl+'wishlist/'+data.wishlist.id+'" title="Wishlist">\n\
                            <span class="glyphicon glyphicon-floppy-disk"></span>\n\
                             Wishlist <span class="count badge">1</span></a></li>');
            } else {
                $('.menu-list .wishlist-link .count').text(Object.keys(data['wishlist']['product_ids']).length);
            }
        }
    });
}
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


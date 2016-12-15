/***************** LAYOUT MAKER ****************/
$(function() {
    $('.change-product').on('click', function () {
        //reset image exemple import
        if ($('.resize-image').data('is-first-image')) {
            $('.resize-image').attr('src', '');
            $('.resize-image').data('is-first-image', 0);
        }
        $('.btn-show-hide-text-area').trigger('click');
        $('.product-title').hide();
        $('.product-title-'+$(this).data('product-id')).show();
        $(".overlay-img").removeClass('hidden');
        $('.change-color-product-block').hide();
        $('.change-color-product-block.'+$(this).data('product-id')).show();
        $('.overlay-img').attr('src', $(this).data('image-large'));
        $('.overlay').data('ref', $(this).data('ref'));
        $('.overlay').data('item-size', $(this).data('item-size'));
        $('.overlay').data('logo-size', $(this).data('logo-size'));
        $('.overlay').data('product-id', $(this).data('product-id'));
    });

    $('.change-color-product').on('click', function () {
        if ($('.resize-image').data('is-first-image')) {
            $('.resize-image').attr('src', '');
            $('.resize-image').data('is-first-image', 0);
        }
        $('.overlay-img').attr('src', $(this).data('image-large')); 
        $('.overlay').data('item-size', $(this).data('item-size'));
        $('.overlay').data('logo-size', $(this).data('logo-size'));
        $('.overlay').data('product-id', $(this).data('product-id'));
    });
    
    var drop = document.getElementById("component");
    drop.addEventListener("dragover", dashing_component, false);
    drop.addEventListener("dragleave", undashing_component,false);
    drop.addEventListener("drop", undashing_component,false);

    function dashing_component() {
      drop.style.border = '3px dashed #38B15D';
    };
    function undashing_component() {
      drop.style.border = '3px solid #e9e9e9';
    };
});

$('.block-color-product').hover(function (){
    $(this).find('.block-layout-maker-info').stop(true, true).slideDown();
}, function () {
    $(this).find('.block-layout-maker-info').stop(true, true).slideUp();
});
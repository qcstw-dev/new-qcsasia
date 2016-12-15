if (window.location.protocol == 'file:') {
    alert('To test this demo properly please use a local server such as XAMPP or WAMP. See README.md for more details.');
}

var resizeableImage = function (image_target, customizable) {
    if (customizable !== false) {
        customizable = true;
    }

    // Some variable and settings
    var $container,
    orig_src = new Image(),
    new_image_resized = new Image(),
    image_target = $(image_target).get(0),
    image_overlay = $('.overlay-img').get(0),
    event_state = {},
//            constrain = false,
    min_width = 20, // Change as required
    min_height = 20,
    max_width = 800, // Change as required
    max_height = 900,
    resize_canvas = document.createElement('canvas');
    rotate_value = 0;
    
    init = function () {

        var initialized = false;

        $('.resize-image').show();
        $('.rotate').show();
        $('.resize-container').find('span').remove();
        $('.resize-container').removeClass('custom');
        $('.resize-container').removeAttr('style');

        if ($('.resize-container').length) {
            $(image_target).unwrap('.resize-container');
        }
        
        // When resizing, we will always use this copy of the original as the base
        orig_src.src = image_target.src;
        
        resize_canvas.width = image_target.height;
        resize_canvas.height = image_target.width;

        if (!initialized) {
            $(image_target).wrap('<div id="resize-container" class="resize-container"></div>');
            if (customizable) {
                // Wrap the image with the container and add resize handles
                $('.resize-container').addClass('custom');
                $(image_target)
                        .before('<span class="border-dashed-top"></span>')
                        .before('<span class="border-dashed-right"></span>')
                        .before('<span class="border-dashed-left"></span>')
                        .before('<span class="border-dashed-bottom"></span>')
                        .before('<span class="resize-handle resize-handle-nw"></span>')
                        .before('<span class="resize-handle resize-handle-ne"></span>')
                        .after('<span class="resize-handle resize-handle-se"></span>')
                        .after('<span class="resize-handle resize-handle-sw"></span>');
            }
        }

        // Assign the container to a variable
        $container_overlay = $(image_overlay);
        $container = $(image_target).parent('.resize-container');

        if (customizable) {
            // Add events
            $container.on('mousedown touchstart', '.resize-handle', startResize);
            $container.on('mousedown touchstart', 'img', startMoving);
        }

        initialized = true;
    };

    startResize = function (e) {
        e.preventDefault();
        e.stopPropagation();
        saveEventState(e);
        $(document).on('mousemove touchmove', resizing);
        $(document).on('mouseup touchend', endResize);
    };

    endResize = function (e) {
        e.preventDefault();
        $(document).off('mouseup touchend', endResize);
        $(document).off('mousemove touchmove', resizing);
    };

    rotate = function (e, value, width, height) {
        rotate_value = value;
        context = resize_canvas.getContext('2d');
        context.save();
        resize_canvas.width = height;
        resize_canvas.height = width;
        canvas_width = resize_canvas.width;
        canvas_height = resize_canvas.height;

        new_image_resized = orig_src;

        resize_canvas.getContext('2d').clearRect(0, 0, width, height);
        var TO_RADIANS = Math.PI / 180;
        
        context.translate(canvas_width / 2, canvas_height / 2);
        context.rotate(TO_RADIANS * rotate_value);
        if ($.inArray(rotate_value, [0, 180, 360]) !== -1) {
            context.drawImage(new_image_resized, -(canvas_width / 2), -(canvas_height / 2), canvas_width, canvas_height);
        } else {
            context.drawImage(new_image_resized, -(canvas_height / 2), -(canvas_width / 2), canvas_height, canvas_width);
        }
        $(image_target).attr('src', resize_canvas.toDataURL("image/png"));
        context.restore();
    };

    saveEventState = function (e) {
        // Save the initial event details and container state
        event_state.container_width = $container.width();
        event_state.container_height = $container.height();
        event_state.container_left = $container.offset().left;
        event_state.container_top = $container.offset().top;
        event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
        event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();

        // This is a fix for mobile safari
        // For some reason it does not allow a direct copy of the touches property
        if (typeof e.originalEvent.touches !== 'undefined') {
            event_state.touches = [];
            $.each(e.originalEvent.touches, function (i, ob) {
                event_state.touches[i] = {};
                event_state.touches[i].clientX = 0 + ob.clientX;
                event_state.touches[i].clientY = 0 + ob.clientY;
            });
        }
        event_state.evnt = e;
    };

    resizing = function (e) {
        var mouse = {}, width, height, left, top, offset = $container.offset();
        mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
        mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
        
        // Position image differently depending on the corner dragged and constraints
        if ($(event_state.evnt.target).hasClass('resize-handle-se')) {
            width = mouse.x - event_state.container_left;
            height = mouse.y - event_state.container_top;
            left = event_state.container_left;
            top = event_state.container_top;
        } else if ($(event_state.evnt.target).hasClass('resize-handle-sw')) {
            width = event_state.container_width - (mouse.x - event_state.container_left);
            height = mouse.y - event_state.container_top;
            left = mouse.x;
            top = event_state.container_top;
        } else if ($(event_state.evnt.target).hasClass('resize-handle-nw')) {
            width = event_state.container_width - (mouse.x - event_state.container_left);
            height = event_state.container_height - (mouse.y - event_state.container_top);
            left = mouse.x;
//            top = mouse.y;
//            if (constrain || e.shiftKey) {
            top = mouse.y - ((width / resize_canvas.width * resize_canvas.height) - height);
//            }
        } else if ($(event_state.evnt.target).hasClass('resize-handle-ne')) {
            width = mouse.x - event_state.container_left;
            height = event_state.container_height - (mouse.y - event_state.container_top);
            left = event_state.container_left;
//            top = mouse.y;
//            if (constrain || e.shiftKey) {
            top = mouse.y - ((width / resize_canvas.width * resize_canvas.height) - height);
//            }
        }

        // Optionally maintain aspect ratio
//        if (constrain || e.shiftKey) {
        height = width / resize_canvas.width * resize_canvas.height;
//        }

        if (width > min_width && height > min_height && width < max_width && height < max_height) {
            // To improve performance you might limit how often resizeImage() is 
            resizeImage(width, height);
            // Without this Firefox will not re-calculate the the image dimensions until drag end
            $container.offset({'left': left, 'top': top});
        }
    };

    resizeImage = function (width, height) {
        resize_canvas.width = width;
        resize_canvas.height = height;

        new_image_resized = orig_src;

        if (rotate_value) {
            resize_canvas.getContext('2d').clearRect(0, 0, width, height);
            var TO_RADIANS = Math.PI / 180;

            resize_canvas.getContext('2d').translate(width / 2, height / 2);
            resize_canvas.getContext('2d').rotate(TO_RADIANS * rotate_value);
        }
        
        if ($.inArray(rotate_value, [90, 270]) !== -1) {
            resize_canvas.getContext('2d').drawImage(new_image_resized, -(height / 2), -(width / 2), height, width);
        } else if ($.inArray(rotate_value, [180, 360]) !== -1) {
            resize_canvas.getContext('2d').drawImage(new_image_resized, -width/2, -height/2, width , height);
        } else {
            resize_canvas.getContext('2d').drawImage(new_image_resized, 0, 0, width , height);
        }
        $(image_target).attr('src', resize_canvas.toDataURL("image/png"));
    };

    startMoving = function (e) {
        e.preventDefault();
        e.stopPropagation();
        saveEventState(e);
        $(document).on('mousemove touchmove', moving);
        $(document).on('mouseup touchend', endMoving);
    };

    endMoving = function (e) {
        e.preventDefault();
        $(document).off('mouseup touchend', endMoving);
        $(document).off('mousemove touchmove', moving);
    };

    moving = function (e) {
        var mouse = {}, touches;
        e.preventDefault();
        e.stopPropagation();

        touches = e.originalEvent.touches;

        mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft();
        mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();
        $container.offset({
            'left': mouse.x - (event_state.mouse_x - event_state.container_left),
            'top': mouse.y - (event_state.mouse_y - event_state.container_top)
        });
        // Watch for pinch zoom gesture while moving
        if (event_state.touches && event_state.touches.length > 1 && touches.length > 1) {
            var width = event_state.container_width, height = event_state.container_height;
            var a = event_state.touches[0].clientX - event_state.touches[1].clientX;
            a = a * a;
            var b = event_state.touches[0].clientY - event_state.touches[1].clientY;
            b = b * b;
            var dist1 = Math.sqrt(a + b);

            a = e.originalEvent.touches[0].clientX - touches[1].clientX;
            a = a * a;
            b = e.originalEvent.touches[0].clientY - touches[1].clientY;
            b = b * b;
            var dist2 = Math.sqrt(a + b);

            var ratio = dist2 / dist1;

            width = width * ratio;
            height = height * ratio;
            // To improve performance you might limit how often resizeImage() is called
            resizeImage(width, height);
        }
    };

    capture = function (element) {
        //Find the part of the image that is inside the crop box
        var crop_canvas,
                left = element.offset().left - $container.offset().left,
                top = element.offset().top - $container.offset().top;

        left_overlay = element.offset().left - $container_overlay.offset().left,
                top_overlay = element.offset().top - $container_overlay.offset().top;

        width = element.width(),
                height = element.height();

        crop_canvas = document.createElement('canvas');
        crop_canvas.width = width;
        crop_canvas.height = height;

        var ctx = crop_canvas.getContext("2d");
        ctx.drawImage(image_target, left, top, width, height, 0, 0, width, height);
        ctx.drawImage(image_overlay, left_overlay, top_overlay, width, height);

        return crop_canvas;
    };
    crop = function () {
        var crop_canvas;
        crop_canvas = capture($('.overlay'));
        
        if ($('.overlay').data('write-info') === true) {
            var ctx = crop_canvas.getContext("2d");
            ctx.font = "12px Arial";
            ctx.fillText('Product: '+$('.overlay').data('ref'),10,30);
            ctx.fillText('Item size: '+$('.overlay').data('item-size'),10,50);
            ctx.fillText('Logo size: '+$('.overlay').data('logo-size'),10,70);
        }
        
        $.magnificPopup.open({
            items: [{
                src: $('<div class="popup">'+
                        '<div class="text-center"><img id="layout" src="'+crop_canvas.toDataURL("image/png")+'" /></div>'+
                        '<div class="send-image btn btn-primary">Send layout to get a quick quote <span class="glyphicon glyphicon-envelope"></span></div>'+
                        '<div class="export-image btn btn-primary">Download layout <span class="glyphicon glyphicon-download-alt"></span></div>'+
                     '</div>'),
                type:'inline'
            }]
        });
        $('.export-image').on('click', function () {
            var fileName;
            if ($('.overlay').data('write-info') === true) {
                fileName = "qcsasia-layout-maker-"+$('.overlay').data('ref').replace('#', '')+".png";
            } else {
                fileName = $('.overlay').data('ref').replace('#', '')+" - "+$('.resize-image').data('picture_name')+".png";
            }
           var a = $("<a>")
                .attr("href", crop_canvas.toDataURL("image/png"))
                .attr("download", fileName)
                .appendTo("body");
            a[0].click();
            a.remove();
        });
        $('.send-image').on('click', function () {
            // upload image
            var newWindow = window.open(baseUrl+'send-layout/', '_blank');
            $.ajax(baseUrl+'upload', {
                beforeSend: function () {
                    $.magnificPopup.open({
                        items: [{
                                src: $('<div class="white-popup text-left"><img src="'+baseUrl+'/sites/all/themes/qcsasia/images/template/loader.gif" /></div>'),
                                type: 'inline'
                            }]
                    });
                },
                method: 'post',
                data: { 
                    layout_url :  crop_canvas.toDataURL("image/png"),
                    layout_name : "qcsasia-layout-maker-"+$('.overlay').data('ref').replace('#', '')
                    },
                dataType: 'html',
                success: function (data) {
//                    window.open(baseUrl+'send-layout/?layout_file='+data, '_blank');
                    newWindow.location = baseUrl+'send-layout/?layout_file='+data;
                    $.magnificPopup.close();
                },
                async: false
            });
        });
    };
    cropAll = function () {
        var crop_canvas_all;
        $('.change-color-product.'+$('.overlay').data('product-id')).each(function () {
            if ($('.overlay-img').attr('src', $(this).data('image-large'))) {
                var crop_canvas,
                crop_canvas = capture($('.overlay'));
                $('.canvas-multi-product').append('<img src="'+crop_canvas.toDataURL("image/png")+'" />');
            }
        });
        crop_canvas_all = capture($('.canvas-multi-product'));
        
        $.magnificPopup.open({
            items: [{
                src: $('<div class="popup">'+
                        '<div><img src="'+crop_canvas_all.toDataURL("image/png")+'" /></div>'+
                        '<div class="margin-top-10 text-right"><span class="export-image btn btn-primary">Download layout <span class="glyphicon glyphicon-download-alt"></span></span></div>'+
                     '</div>'),
                type:'inline'
            }]
        });
    }
    init();
};
$('.rotate').live('click', function () {
    if ($.inArray(rotate_value, [0, 90, 180, 270]) !== -1) {
        rotate(null, rotate_value + 90, $('.resize-container').width(), $('.resize-container').height());
    } else if (rotate_value === 360) {
        rotate(null, 90, $('.resize-container').width(), $('.resize-container').height());
    } else {
        rotate(null, 90, $('.resize-container').height(), $('.resize-container').width());
    }
});
$('.js-crop').live('click', function () {
    crop(true);
}); 
//$('.js-crop-all').live('click', cropAll);
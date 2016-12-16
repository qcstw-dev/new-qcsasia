$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|eps|raw)$/i,
        previewMaxWidth: 800,
        previewMaxHeight: 400,
        previewThumbnail: false,
        previewCrop: false,
        imageCrop: false
    }).on('fileuploadadd', function (e, data) {

        data.context = $('#files');

    }).on('fileuploadprocessalways', function (e, data) {
        $('.resize-image').data('picture_name', data.files[0].name.replace('.jpg', '').replace('.jpeg', '').replace('.png', ''));
        $('.file-error').remove();
        var index = data.index,
                file = data.files[index],
                node = $(data.context);
        if (file.preview && !file.error) {
            var dataURL = file.preview.toDataURL();

            $(".resize-image").attr("src", dataURL).removeClass('hidden');
            $('.resize-image').data('is-first-image', 0);
            
            var newWidth = $('.overlay').width();
            var img = $('.resize-image')[0]; // Get my img elem
            var pic_real_width, pic_real_height;

            $("<img/>") // Make in memory copy of image to avoid css issues
                    .attr("src", $(img).attr("src"))
                    .load(function () {
                        pic_real_width = this.width;   // Note: $(this).width() will not
                        pic_real_height = this.height;   // Note: $(this).width() will not
                        var ratio = newWidth / parseInt(pic_real_width);
                        var newHeight = parseInt(pic_real_height) * ratio;
                        resizeImage(newWidth, newHeight);
                    });
            
            // Kick everything off with the target image
            resizeableImage($('.resize-image'));
            
            if ($('.file-error')) {
                $('.file-error').remove();
            }
        }
        if (file.error) {
            node.append($('<p class="file-error text-danger margin-top-20"/>').text(file.error));
        }
    });
});

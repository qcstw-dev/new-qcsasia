<?php

/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 *
 * If a preview is enabled, these keys will be available on the preview page:
 * - $form['preview_message']: The preview message renderable.
 * - $form['preview']: A renderable representing the entire submission preview.
 */
?>
<h2>Contact us</h2>
<div class="error-message">Please inform fields marked in red</div>
<div class="error-message-email">Please enter a valid email address</div>
<div class="col-xs-12 col-md-offset-3 col-md-6 margin-top-10"><?php
    // Print out the progress bar at the top of the page
    print drupal_render($form['progressbar']);
    // Print out the preview message if on the preview page.
    if (isset($form['preview_message'])) {
        print '<div class="messages warning">';
        print drupal_render($form['preview_message']);
        print '</div>';
    }
    foreach ($form['submitted'] as $key => $field) {
        if (strpos($key, "#") === false) {
            if (in_array($field['#type'], ['textfield', 'webform_email'])) { ?>
                <div class="input-group">
                    <span class="input-group-addon"><?php print $field['#webform_component']['name'].($field['#required'] ? ' *' : '') ?></span>
                    <input type="<?php print ($field['#type'] === 'webform_email' ? 'email' : 'text') ?>" class="form-control <?php echo ($field['#required'] ? 'required' : '') ?> <?php print ($field['#type'] === 'webform_email' ? 'email' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                </div><?php
            } else if ($field['#type'] === 'textarea') { ?>
                <div class="input-group">
                    <span class="input-group-addon"><?php print $field['#webform_component']['name'].($field['#required'] ? ' *' : '') ?></span>
                    <textarea class="form-control height-150 <?php echo ($field['#required'] ? 'required' : '') ?>" name="<?php print $field['#name'] ?>"></textarea>
                </div><?php
            }
        }
    } ?>
    
    <input type="hidden" name="form_build_id" value="<?= $form['form_build_id']['#value'] ?>">
    <input type="hidden" name="form_token" value="<?= $form['form_token']['#value'] ?>">
    <input type="hidden" name="form_id" value="<?= $form['form_id']['#value'] ?>"><?php
    
    if (isset($form['captcha']) && strpos($form['captcha']['#captcha_type'], 'recaptcha') !== false) {
        print $form['captcha']['captcha_widgets']['recaptcha_widget']['#markup'];
    } ?>
    <input type="button" class="btn btn-primary margin-top-10 btn-submit" value="Send"/>
</div>
<script>
    $('.webform-client-form .btn-submit').on('click', function () {
        var valid = true;
        $('.webform-client-form .required').each(function() {
            if ($(this).hasClass('required') && !$(this).val()) {
              $(this).addClass("form-control-danger");
              valid = false;
            } else if($(this).prop('type') == 'email' && !isEmail($(this).val())) {
              $(this).addClass("form-control-danger");
              $('.error-message-email').slideDown();
              valid = false;
            } else {
              $(this).removeClass('form-control-danger');  
            }
        });
        if (!valid) {
            $('.error-message').slideDown();
        } else {
            $('.webform-client-form').submit();
        }
    });
    $('.email').on ('focusout', function () {
        if ($(this).prop('type') == 'email') {
            if (isEmail($(this).val())) {
                $(this).removeClass('form-control-danger');
                $('.error-message-email').slideUp();
            } else {
                $(this).addClass('form-control-danger');
                $('.error-message-email').slideDown();
            }
        }
    });
    $('.required').on ('keyup', function () {
        if ($(this).val()) {
            $(this).removeClass('form-control-danger');
        }
        $('.webform-client-form .required').each(function() {
            if ($('.webform-client-form .form-control-danger').length == 0 && $('.error-message').css('display') == 'block') {
                $('.error-message').slideUp();
            }
        });
    });
    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
</script>
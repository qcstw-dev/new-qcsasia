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
<div class="col-md-6">
    <h2>Contact us</h2>
    <div class="col-xs-12 margin-top-10 contact-form">
        <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
        <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div><?php
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
                            <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                            <input type="<?php print ($field['#type'] === 'webform_email' ? 'email' : 'text') ?>" class="form-control <?php echo ($field['#required'] ? 'required' : '') ?> <?php print ($field['#type'] === 'webform_email' ? 'email' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                        </div><?php 
                } 
                else if ($field['#type'] === 'textarea') { ?>
                        <div class="input-group">
                            <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
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
</div>
<div class="col-md-6">
    <div class="col-xs-12 padding-left-0">
        <h3>Taiwan head office:</h3>

        <p>QCS ASIA CO. ,LTD 台灣妍品有限公司<br />
            5F-8, 63 HEPING E. RD , SEC3 TAIPEI TAIWAN<br />
            台北市和平東路3段63號5樓之8 (嘉樂大樓)<br />
            <br />
            TEL : (886-2) 27385787 FAX : (886-2)27385816</p>

        <div class="col-xs-12 margin-top-20 padding-0"><iframe frameborder="0" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d903.8183351866223!2d121.54866132923432!3d25.024796214206898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442aa321d20e10d%3A0xf43ccf1621215ddf!2sNo.+63%2C+Section+3%2C+Heping+E+Rd%2C+Da%E2%80%99an+District%2C+Taipei+City%2C+106!5e0!3m2!1sen!2stw!4v1452219366587" style="border:0" width="100%"></iframe></div>
    </div>

    <div class="col-xs-12 padding-right-0">
        <h3>China Factory:</h3>

        <p>QCS Gift Factory 高要市廣星禮品有限公司<br />
            D2 DISTRICT, JINDU, GAOYAO CITY, GUANGDONG, CHINA<br />
            中國廣東省肇慶高要市金渡鎮D2小區 ZIP: 526108<br />
            <br />
            TEL :(86.758) 8512115 FAX : (86.758) 8512145</p>

        <div class="col-xs-12 margin-top-20 padding-0"><iframe frameborder="0" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.455377450762!2d112.52200431537644!3d23.043760921317396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDAyJzM3LjUiTiAxMTLCsDMxJzI3LjEiRQ!5e0!3m2!1sfr!2stw!4v1448518944612" style="border:0" width="100%"></iframe></div>
    </div>
</div>

<script>
    formValidators('contact-form');
    $('.contact-form .btn-submit').on('click', function () {
        if (formSubmitValidator('contact-form')) {
            $('.webform-client-form').submit();
        }
    });
</script>
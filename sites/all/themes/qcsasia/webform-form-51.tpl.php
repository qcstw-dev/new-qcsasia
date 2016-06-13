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
//$form = drupal_get_form('webform_client_form_48',$node,array()); 
//var_dump($form); ?>
<h2>Toolkit</h2>
<div class="col-md-10 margin-auto margin-bottom-20 padding-0">
    <div class="col-xs-12 border padding-0">
        <div class="col-sm-9 padding-0 border-right">
            <div class="col-xs-12 padding-0">
                <div class="thumbnail border-none margin-bottom-0 padding-0">
                    <img src="<?= file_create_url(path_to_theme() . "/images/toolkit/qcs-toolkit.jpg"); ?>" />
                </div>
            </div>
            <div class="col-xs-12 padding-0 border-top">
                <h3 class="margin-0">QCS NEW PRODUCT TOOLKIT</h3>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-sm-3 padding-20">
            <p class="font-size-18">Require your QCS new product toolkit!</p>
            <p>This toolkit features 12 new products dispalyed on 2 cardboards and an exterior brochure.</p>
            <p>The toolkit is currently composed of:</p> 
            <p>PCH01103, PTOP, PWH, QAT3, PABH2, PSPH, PSBA105, PSS205, LYB206, PSKC104, PKP102, PST103</p>
        </div>
    </div>
<div class="clearfix"></div>
</div>
<div class="col-md-10 margin-auto margin-bottom-20 padding-0">
    <div class="col-xs-12 border padding-0">
        <div class="col-sm-9 padding-0 border-right">
            <div class="col-xs-12 padding-0">
                <div class="thumbnail border-none margin-bottom-0 padding-0">
                    <img src="<?= file_create_url(path_to_theme() . "/images/toolkit/doming-toolkit.jpg"); ?>" />
                </div>
            </div>
            <div class="col-xs-12 padding-0 border-top">
                <h3 class="margin-0">DOMING TOOLKIT</h3>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-sm-3 padding-20">
            <p class="font-size-18">Require your QCS doming toolkit!</p>
            <p>This toolkit features 46 domes dispalyed on 2 cardboards and an exterior brochure.</p>
            <p>Several industries' designs are displayed:</p>
            <p>Promotional, gift & souvenir (ODM); Signage, labelling & branding (OEM); Transparent clear domes (DIY); UIDs, QR code & running numbers</p>
        </div>
    </div>
<div class="clearfix"></div>
</div>
<div class="col-xs-12">
    <div class="well padding font-size-18 text-center">
        <p class="font-size-20 text-uppercase">I want it!</p>
        <p>To receive a toolkit, please fill the following form:</p>
    </div>
</div>
<div class="toolkit-form col-xs-12 padding-0">
    <div class="col-xs-12 padding-0"><?php
        $bAlertSet = false;
        $iCountFields = 0;
        $iCount = 1;
        foreach ($form['submitted'] as $key => $field) {
            if (strpos($key, "#") === false && in_array($field['#type'], ['textfield', 'webform_email', 'select'])) {
                $iCountFields++;
            }
        }
        foreach ($form['submitted'] as $key => $field) {
            if (strpos($key, "#") === false) {
                if (in_array($field['#type'], ['textfield', 'webform_email', 'select', 'checkboxes']) && $field['#webform_component']['form_key'] != 'product') {
                    if (!$bAlertSet) {
                        ?>
                        <div class="clearfix"></div>
                        <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                        <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div>
                        <div class="col-md-6"><?php
                            $bAlertSet = true;
                        }
                        if ($field['#type'] == 'select') {
                            displaySelect($field['#options'], $field['#title'], $field['#name'], $field['#attributes']['required']);
                        } else if ($field['#type'] == 'checkboxes') { 
                            foreach ($field['#options'] as $key => $value) { ?>
                                <div class="input-group">
                                    <label class="cursor-pointer"><input type="checkbox" name="<?= $field['#name'] ?>[]" value="<?= $key ?>" <?= ($key == 'accept_promo' ? 'checked' : '') ?> /><?= $value ?></label>
                                </div><?php
                            }
                        } else if (in_array($field['#type'], ['textfield', 'webform_email'])) {
                            ?>
                            <div class="input-group">
                                <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                                <input type="<?php print ($field['#type'] === 'webform_email' ? 'email' : 'text') ?>" class="form-control <?= ($field['#type'] === 'webform_email' ? 'email' : 'text') ?> <?php echo ($field['#required'] ? 'required' : '') ?> <?php print ($field['#type'] === 'webform_email' ? 'email' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                            </div><?php
                        }
                        $iCount++;
                        if ($iCount == 7) {
                            ?>
                        </div>
                        <div class="col-md-6"><?php
                        }
                    }
                }
            }
            ?>
        </div>
        <input type="hidden" name="form_build_id" value="<?= $form['form_build_id']['#value'] ?>">
        <input type="hidden" name="form_token" value="<?= $form['form_token']['#value'] ?>">
        <input type="hidden" name="form_id" value="<?= $form['form_id']['#value'] ?>">
        <div class="col-xs-12">
            <input class="btn btn-primary btn-submit" type="button" value="Send" />
        </div>
    </div>
    <script>
        formValidators('toolkit-form');
        $('.toolkit-form .btn-submit').on('click', function () {
            if (formSubmitValidator('toolkit-form')) {
                $('.webform-client-form').submit();
            }
        });
    </script>
</div>


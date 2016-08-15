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
//$form = drupal_get_form('webform_client_form_46',$node,array()); ?>

<div class="catalog-form">
    <h2>Catalog 2016 !</h2>
    <div class="col-xs-12 padding-0">
        <div data-configid="0/30751501" style="width:100%; height:855px;" class="issuuembed visible-lg margin-auto"></div>
        <div data-configid="0/30751501" style="width:100%; height:680px;" class="issuuembed visible-sm margin-auto"></div>
        <div data-configid="0/30751501" style="width:100%; height:307px;" class="issuuembed visible-xs margin-auto"></div>
        <script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>
    </div>
    <div class="col-xs-12 padding-0 margin-top-20"><?php
        $bIsConnected = isset($_SESSION['user']) && $_SESSION['user']; ?>
        <a <?= (!$bIsConnected ? 'class="disabled_link"' : '') ?> href="<?= (!$bIsConnected ? url('member-area') : url(path_to_theme() . "/images/catalog/QCS ASIA promotional product, gift & souvenir catalog 2016.pdf")) ?>" target="_blank" title="Download Catalog 2016">
            <div class="col-xs-offset-2 col-sm-offset-3 col-xs-4 col-sm-3">
                <div class="thumbnail thumbnail-hover <?= (!$bIsConnected ? 'disabled_link' : '') ?>">
                    <img src="<?= url(path_to_theme() . "/images/catalog/catalog-2016.jpg") ?>" />
                    <div class="subtitle-pic">
                        Download .pdf<br /> version
                        <div class="color-red font-size-15">member only*</div>
                    </div>
                </div>
            </div>
        </a>
        <a <?= (!$bIsConnected ? 'class="disabled_link"' : '') ?> href="<?= (!$bIsConnected ? url('member-area') : url(path_to_theme() . "/images/catalog/QCS Asia catalog 2016 - unbranded low def.pdf")) ?>" target="_blank" title="Download Catalog 2016">
            <div class="col-sm-offset-1 col-xs-4 col-sm-3">
                <div class="thumbnail thumbnail-hover <?= (!$bIsConnected ? 'disabled_link' : '') ?> margin-bottom-0">
                    <img src="<?= url(path_to_theme() . "/images/catalog/catalog-2016-unbranded.jpg") ?>" />
                    <div class="subtitle-pic">
                        Download .pdf unbranded version
                        <div class="color-red font-size-15">member only*</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xs-12">
        <div class="well padding font-size-18 text-center">
            <p class="font-size-20 text-uppercase">Send me a hardcopy!</p>
            <p>To receive a hardcopy, please fill in the following form:</p>
        </div>
    </div>
    <div class="col-xs-12 padding-0"><?php
        $bAlertSet = false;
        $iCountFields = 0;
        $iCount = 1;
        foreach ($form['submitted'] as $key => $field) {
            if (strpos($key, "#") === false && in_array($field['#type'], ['textfield', 'webform_email', 'select', 'checkboxes'])) { 
                $iCountFields++;
            }
        }
        $iCountFields = $iCountFields +4;
        foreach ($form['submitted'] as $key => $field) {
            if (strpos($key, "#") === false) {
                if (in_array($field['#type'], ['textfield', 'webform_email', 'select', 'checkboxes']) && $field['#webform_component']['form_key'] != 'product') {
                    if (!$bAlertSet) { ?>
                        <div class="clearfix"></div>
                        <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                        <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div>
                        <div class="col-md-6"><?php
                        $bAlertSet = true;
                    } 

                    if ($field['#type'] == 'select' && $field['#webform_component']['form_key'] == 'country') {
                        displaySelect($field['#options'], $field['#title'], $field['#name'], $field['#attributes']['required']);
                    } else if ($field['#type'] === 'checkboxes') { 
                        foreach ($field['#options'] as $key => $value) { ?>
                            <div class="input-group">
                                <label class="cursor-pointer"><input type="checkbox" name="<?= $field['#name'] ?>[]" value="<?= $key ?>" <?= ($key == 'accept_promo' ? 'checked' : '') ?> /><?= $value ?></label>
                            </div><?php
                        } 
                    } else { ?>
                        <div class="input-group">
                            <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                            <input type="<?php print ($field['#type'] === 'webform_email' ? 'email' : 'text') ?>" class="form-control <?= ($field['#type'] === 'webform_email' ? 'email' : 'text') ?> <?php echo ($field['#required'] ? 'required' : '') ?> <?php print ($field['#type'] === 'webform_email' ? 'email' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                        </div><?php
                    }
                    $iCount++; 
                    if ($iCount == round($iCountFields / 2)) { ?>
                        </div>
                        <div class="col-md-6"><?php
                    }
                }
            }
        } 
        if (isset($form['captcha']) && strpos($form['captcha']['#captcha_type'], 'recaptcha') !== false) {
            print $form['captcha']['captcha_widgets']['recaptcha_widget']['#markup'];
        } ?>
        </div>
        <input type="hidden" name="form_build_id" value="<?= $form['form_build_id']['#value'] ?>">
        <input type="hidden" name="form_token" value="<?= $form['form_token']['#value'] ?>">
        <input type="hidden" name="form_id" value="<?= $form['form_id']['#value'] ?>">
        <div class="col-xs-12 text-right">
            <input class="btn btn-primary btn-submit" type="button" value="Send" />
        </div>
    </div>
    <script>
        formValidators('catalog-form');
        $('.catalog-form .btn-submit').on('click', function () {
            if (formSubmitValidator('catalog-form')) {
                $('.webform-client-form').submit();
            }
        });
    </script>
</div>
    
    
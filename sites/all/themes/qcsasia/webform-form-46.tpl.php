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

<div class="sample-form">
<h2>Samples & prototypes</h2>
<div class="well font-size-18 text-center">
    <p>We can send free samples and/or prototypes at your company name.</p>
    <p>Please, tick items you would like to receive within following list</p>
</div>
<div class="col-xs-12 padding-0"><?php
    $bAlertSet = false;
    $iCountFields = 0;
    $iCount = 1;
    $aPreselectedProducts = (isset(drupal_get_query_parameters()['product']) ? (is_array(drupal_get_query_parameters()['product']) ? drupal_get_query_parameters()['product'] : [drupal_get_query_parameters()['product']]) : []);
    foreach ($form['submitted'] as $key => $field) {
        if (strpos($key, "#") === false && in_array($field['#type'], ['textfield', 'webform_email', 'select', 'checkboxes'])) { 
            $iCountFields++;
        }
    }
    foreach ($form['submitted'] as $key => $field) {
        if (strpos($key, "#") === false) {
            if  ($field['#webform_component']['form_key'] == 'product') {
                $aProductValues = [];
                foreach ($field['#options'] as $sKey => $sValue) {
                    $aProductValues[substr($sKey, 0, -1)][$sKey] = $sValue;
                } ?>
                <div class="col-xs-12 padding-0"><?php
                    displayProductCheckbox($aProductValues); ?>
                </div>
                <div class="col-xs-12 background-grey well ">
                    <div class="col-xs-12 font-size-18 text-center">
                        Complete following form to receive your samples:
                    </div>
                    <div class="col-xs-12 sample-list <?= (!$aPreselectedProducts ? 'hidden' : '') ?>">
                        <div class="bold">Selected samples:</div><?php
                         foreach ($aPreselectedProducts as $aPreselectedProduct) {
                            $oProduct = taxonomy_term_load($aPreselectedProduct); 
                            $sProductTitle = $oProduct->field_product_name['und'][0]['value']." ".$oProduct->field_product_ref['und'][0]['value']; ?>
                            <li class="id-<?= $aPreselectedProduct ?> L"><?= $sProductTitle ?> - Logotyped</li>
                            <li class="id-<?= $aPreselectedProduct ?> B"><?= $sProductTitle ?> - No logo</li><?php
                         } ?>
                    </div>
                </div><?php
            } 
            if (in_array($field['#type'], ['textfield', 'webform_email', 'select', 'checkboxes']) && $field['#webform_component']['form_key'] != 'product') {
                if (!$bAlertSet) { ?>
                    <div class="clearfix"></div>
                    <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                    <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div>
                    <div class="col-md-6"><?php
                    $bAlertSet = true;
                } 
                if ($field['#type'] == 'select' && $field['#webform_component']['form_key'] == 'country') {
//                      preg_match_all('~([A-Z]*)\|([a-zA-Z]*)~', $aComponent['extra']['items'], $match);
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
    formValidators('sample-form');
    $('.sample-form .btn-submit').on('click', function () {
        if (formSubmitValidator('sample-form')) {
            $('.webform-client-form').submit();
        }
    });<?php
    if (isset(drupal_get_query_parameters()['product']) && drupal_get_query_parameters()['product']) {
        if (is_array(drupal_get_query_parameters()['product'])) {
            $sIdToGo = drupal_get_query_parameters()['product'][0];
        } else {
            $sIdToGo = drupal_get_query_parameters()['product'];
        } ?>
        $( document ).ready( function () {
            $('html, body').animate({
                scrollTop: $("#<?= $sIdToGo ?>").offset().top
            }, 500);
        });<?php
    } ?>
    $('.checkbox-sample').click(function () {
        $('.sample-list').removeClass('hidden');
        var sItemClassId = 'id-'+$(this).data('id');
        var sItemClassType = $(this).data('type');
        if ($(this).is(':checked')) {
            var dataType = ($(this).data('type') === 'L' ? ' - Logotyped' : '- Blank no logo');
            $('.sample-list').append('<li class="'+sItemClassId+' '+sItemClassType+'">'+$(this).data('product-title')+dataType+'</li>');
        } else {
            $('.'+sItemClassId+'.'+sItemClassType).hide();
        }
    });
</script>
    
    
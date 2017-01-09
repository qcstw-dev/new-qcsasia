<h2>Send layout to get a quick quote</h2><?php
$sLayoutUrl = (isset($_GET['layout_file']) ? $_GET['layout_file'] : ''); 
if ($sLayoutUrl) { 
    global $base_url; ?>
    <div class="col-md-12">
        <div class="col-md-6 thumbnail">
            <img src="<?= $base_url.'/sites/default/files/products/layout-maker/uploads/'.$sLayoutUrl ?>" alt="Custom product" title="custom product" />
        </div>
        <div class="send-layout-form col-md-6">
                <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div><?php
            foreach ($form['submitted'] as $key => $field) {
                if (strpos($key, "#") === false) {
                    if (in_array($field['#type'], ['textfield', 'webform_email']) && $field['#webform_component']['form_key'] != 'layout') { ?>
                            <div class="input-group">
                                <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                                <input type="<?php print ($field['#type'] === 'webform_email' ? 'email' : 'text') ?>" class="form-control <?php echo ($field['#required'] ? 'required' : '') ?> <?php print ($field['#type'] === 'webform_email' ? 'email' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                            </div><?php 
                    } else if ($field['#webform_component']['form_key'] === 'layout') { ?>
                        <input type="hidden" name="<?= $field['#name'] ?>" value="<?= $sLayoutUrl ?>" /><?php
                    } else if ($field['#type'] === 'textarea') { ?>
                            <div class="input-group">
                                <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                                <textarea class="textarea form-control height-150 <?php echo ($field['#required'] ? 'required' : '') ?>" name="<?php print $field['#name'] ?>"></textarea>
                            </div><?php
                    } else if ($field['#type'] == 'select') {
    //                      preg_match_all('~([A-Z]*)\|([a-zA-Z]*)~', $aComponent['extra']['items'], $match);
                        displaySelect($field['#options'], $field['#title'], $field['#name'], $field['#attributes']['required']);
                    } else if ($field['#type'] === 'checkboxes') { 
                        foreach ($field['#options'] as $key => $value) { ?>
                            <div class="input-group">
                                <label class="cursor-pointer"><input type="checkbox" name="<?= $field['#name'] ?>[]" value="<?= $key ?>" <?= ($key == 'accept_promo' ? 'checked' : '') ?> /><?= $value ?></label>
                            </div><?php
                        } 
                    } else if ($field['#type'] === 'webform_number') { ?>
                        <div class="input-group">
                            <span class="input-group-addon"><?php print $field['#webform_component']['name'] . ($field['#required'] ? ' *' : '') ?></span>
                            <input type="number" class="form-control <?php echo ($field['#required'] ? 'required' : '') ?>" name="<?php print $field['#name'] ?>" <?php echo ($field['#required'] ? '' : '') ?> />
                        </div><?php
                    }
                }
            } 
            if (isset($form['captcha']) && strpos($form['captcha']['#captcha_type'], 'recaptcha') !== false) {
                print $form['captcha']['captcha_widgets']['recaptcha_widget']['#markup'];
            } ?>
            <input type="hidden" name="form_build_id" value="<?= $form['form_build_id']['#value'] ?>">
            <input type="hidden" name="form_token" value="<?= $form['form_token']['#value'] ?>">
            <input type="hidden" name="form_id" value="<?= $form['form_id']['#value'] ?>">
            <input type="button" class="btn btn-primary margin-top-10 btn-submit pull-right" value="Send"/>
        </div>
            </form>
    </div>    
    <script>
        formValidators('send-layout-form');
        $('.send-layout-form .btn-submit').on('click', function () {
            if (formSubmitValidator('send-layout-form')) {
                $('.webform-client-form').submit();
            }
        });
    </script><?php
} else { ?>
    <div class="alert alert-warning text-center">
        <span class="glyphicon glyphicon-warning-sign font-size-20"></span><strong> Error, no picture</strong>
    </div><?php
} ?>

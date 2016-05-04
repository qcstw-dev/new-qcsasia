<div class="block-line text-left"><?php
    foreach (getProducts(drupal_get_query_parameters()) as $oProduct) {
        $oLineProduct = taxonomy_term_load($oProduct->tid); ?>
        <div class="col-xs-12 block-line-product padding-0 padding-bottom-10 padding-top-10 border-bottom">
            <a href="<?= url('taxonomy/term/' . $oProduct->tid) ?>" title="<?= $oLineProduct->field_product_name['und'][0]['value'] ?>">
                <div class="col-xs-4 col-md-3 thumbnail margin-top-xs-20"><?php
                    $sPictureUri = '';
                    if ($oLineProduct->field_logo_process) {
                        foreach ($oLineProduct->field_logo_process['und'] as $key => $aLogoProcess) {
                            $oLogoProcess = taxonomy_term_load($aLogoProcess['tid']);
                            if ($oLogoProcess->field_reference['und'][0]['value'] == "doming") {
                                $sPictureUri = $oLineProduct->field_image_logo_process['und'][$key]['uri'];
                            } else {
                                $sPictureUri = $oLineProduct->field_image_logo_process['und'][0]['uri'];
                            }
                        }
                    } ?>
                    <img src="<?= file_create_url(($sPictureUri ?: $oLineProduct->field_main_photo['und'][0]['uri'])) ?>" alt="" title="" />
                </div>
                <div class="col-xs-8 col-xs-9">
                    <div class="title-product-ref"><?= ($oLineProduct->field_product_ref['und'][0]['value'] ?: $oLineProduct->field_product_name['und'][0]['value']) ?></div>
                    <div class="title-product"> <?= (!$oLineProduct->field_product_ref['und'][0]['value'] ? '' :$oLineProduct->field_product_name['und'][0]['value']) ?></div>
                    <div class="margin-top-10"><?php
                        if (!$oLineProduct->field_item_size['und'][0]['value'] && !$oLineProduct->field_logo_size['und'][0]['value'] && !$oLineProduct->field_packaging['und'][0]['value']) { ?>
                            <div><strong>Description:</strong> <?= substr(strip_tags($oLineProduct->field_description['und'][0]['value']), 0, 150).' [...]' ?></div><?php
                        } else { ?>
                            <div><strong>Item size:</strong> <?= $oLineProduct->field_item_size['und'][0]['value'] ?></div>
                            <div><strong>Logo size:</strong> <?= $oLineProduct->field_logo_size['und'][0]['value'] ?></div>
                            <div><strong>Packaging:</strong> <?= $oLineProduct->field_packaging['und'][0]['value'] ?></div><?php                        
                        } ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="clearfix"></div><?php 
    }?>
</div>
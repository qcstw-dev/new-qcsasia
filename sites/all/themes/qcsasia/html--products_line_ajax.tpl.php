<div class="block-line text-left"><?php
    foreach (getProducts(drupal_get_query_parameters()) as $oProduct) {
        $oProductLine = taxonomy_term_load($oProduct->tid); ?>
        <div class="col-xs-12 block-line-product padding-0 padding-bottom-10 padding-top-10 border-bottom">
            <a href="<?= url('taxonomy/term/' . $oProduct->tid) ?>" title="<?= $oProductLine->field_product_name['und'][0]['value'] ?>">
                <div class="col-xs-4 col-md-3 thumbnail margin-top-xs-20">
                    <img src="<?= file_create_url($oProductLine->field_main_photo['und'][0]['uri']) ?>" alt="" title="" />
                </div>
                <div class="col-xs-8 col-xs-9">
                    <div class="title-product-ref"><?= ($oProductLine->field_product_ref['und'][0]['value'] ?: $oProductLine->field_product_name['und'][0]['value']) ?></div>
                    <div class="title-product"> <?= (!$oProductLine->field_product_ref['und'][0]['value'] ? '' :$oProductLine->field_product_name['und'][0]['value']) ?></div>
                    <div class="margin-top-10"><?php
                        if (!$oProductLine->field_item_size['und'][0]['value'] && !$oProductLine->field_logo_size['und'][0]['value'] && !$oProductLine->field_packaging['und'][0]['value']) { ?>
                            <div><strong>Description:</strong> <?= substr(strip_tags($oProductLine->field_description['und'][0]['value']), 0, 150).' [...]' ?></div><?php
                        } else { ?>
                            <div><strong>Item size:</strong> <?= $oProductLine->field_item_size['und'][0]['value'] ?></div>
                            <div><strong>Logo size:</strong> <?= $oProductLine->field_logo_size['und'][0]['value'] ?></div>
                            <div><strong>Packaging:</strong> <?= $oProductLine->field_packaging['und'][0]['value'] ?></div><?php                        
                        } ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="clearfix"></div><?php 
    }?>
</div>
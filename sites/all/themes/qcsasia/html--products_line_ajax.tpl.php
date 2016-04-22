<div class="block-line text-left"><?php
    foreach (getProducts(drupal_get_query_parameters()) as $oProduct) {
        $oProductLine = taxonomy_term_load($oProduct->tid); ?>
        <div class="col-md-12 block-line-product padding-0 padding-bottom-10 padding-top-10 border-bottom">
            <a href="<?= url('taxonomy/term/' . $oProduct->tid) ?>" title="<?= $oProductLine->field_product_name['und'][0]['value'] ?>">
                <div class="col-md-3 thumbnail margin-0">
                    <img src="<?= file_create_url($oProductLine->field_main_photo['und'][0]['uri']) ?>" alt="" title="" />
                </div>
                <div class="col-md-9">
                    <div class="title-product-ref"><?= $oProductLine->field_product_ref['und'][0]['value'] ?></div>
                    <div class="title-product"> <?= $oProductLine->field_product_name['und'][0]['value'] ?></div>
                    <div>Item size: <?= $oProductLine->field_item_size['und'][0]['value'] ?></div>
                    <div>Logo size: <?= $oProductLine->field_logo_size['und'][0]['value'] ?></div>
                    <div>Packaging: <?= $oProductLine->field_packaging['und'][0]['value'] ?></div>
                </div>
            </a>
        </div>
        <div class="clearfix"></div><?php 
    }?>
</div>
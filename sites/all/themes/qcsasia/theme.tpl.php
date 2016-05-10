<div class="theme-page">
    <h2><?= $term->field_theme_title['und'][0]['value'] ?></h2><?php
    // retrieve gift
    foreach ($term->field_theme_gift['und'] as $aFieldThemeGift) {
        $oFieldThemeGift = entity_load('field_collection_item', [$aFieldThemeGift['value']])[$aFieldThemeGift['value']];
        $oGift = $oFieldThemeGift->field_gift['und'][0]['taxonomy_term']; ?>
        <div class="col-md-12">
            <h3><?= $oGift->field_product_name['und'][0]['value'].' '.$oGift->field_product_ref['und'][0]['value'] ?></h3><?php
            if ($oFieldThemeGift->field_gift_theme_image) { ?>
                <div class="gallery gallery-container"><?php 
                foreach ($oFieldThemeGift->field_gift_theme_image['und'] as $aPicture) { ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <a href="<?= file_create_url($aPicture['uri']) ?>">
                                <img src="<?= file_create_url($aPicture['uri']) ?>" title="<?= ($aPicture['title'] ? : $oGift->field_product_name['und'][0]['value'] ) ?>" alt="<?= ($aPicture['alt'] ? : $oGift->field_product_name['und'][0]['value'] ) ?>" />
                            </a>
                        </div>
                    </div><?php 
                } ?>
                </div><?php 
            } ?>
        </div><?php
    }?>
</div>
<div class="theme-page">
    <h2><?= $term->field_theme_title['und'][0]['value'] ?></h2><?php
    // retrieve gift
    foreach ($term->field_theme_gift['und'] as $aFieldThemeGift) {
        $oFieldThemeGift = entity_load('field_collection_item', [$aFieldThemeGift['value']])[$aFieldThemeGift['value']];
        $oGift = $oFieldThemeGift->field_gift['und'][0]['taxonomy_term']; ?>
        <div class="col-sm-12">
            <h3><?= $oGift->field_product_name['und'][0]['value'].' '.$oGift->field_product_ref['und'][0]['value'] ?></h3><?php
            if ($oFieldThemeGift->field_gift_theme_image) { ?>
                <div class="gallery gallery-container"><?php 
                foreach ($oFieldThemeGift->field_gift_theme_image['und'] as $aPicture) { ?>
                    <div class="col-sm-4">
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
    <div class="col-sm-12">
        <h2>Display options available</h2><?php
        // retrieve display
        $aDisplayToRetrive = ['#CCD', '#ACD', '#CRCD','#MRCD', '#MRTD'];
        $aDisplays = [];
        foreach ($aDisplayToRetrive as $sRef) {
            $aDisplays[] = retrieveDisplayByRef($sRef);
        }
        $count = 1;
        foreach ($aDisplays as $key => $oDisplay) { ?>
            <div class="col-md-6 gallery gallery-container margin-bottom-10">
                <div class="col-sm-12 border padding-0">
                    <div class="col-sm-4 thumbnail border-none margin-bottom-0 padding-top-10">
                        <a href="<?= file_create_url($oDisplay->field_thumbnail['und'][0]['uri']) ?>" title="<?= $oDisplay->field_display_title['und'][0]['value'] ?>">
                            <img src="<?= file_create_url($oDisplay->field_thumbnail['und'][0]['uri']) ?>" title="<?= $oDisplay->field_display_title['und'][0]['value'] ?>" alt="<?= $oDisplay->field_display_title['und'][0]['value'] ?>" />
                        </a>
                    </div>
                    <div class="col-sm-8 padding-0">
                        <div class="padding padding-left-0">
                            <h3 class="font-size-18"><?= $oDisplay->field_display_title['und'][0]['value'].' '.$oDisplay->field_display_ref['und'][0]['value'] ?></h3>
                        </div>
                        <?= $oDisplay->field_description['und'][0]['value'] ?>
                    </div>
                </div>
            </div><?php
            if ($count % 2 == 0) { ?>
                <div class="clearfix"></div><?php
            }
            $count++;
        } ?>
    </div>
    <div class="col-sm-12">
        <h2>Add-on</h2><?php
        $aAddons = getAddons();
            foreach ($aAddons as $oAddon) {?>
                <div class="col-xs-4 col-md-3 gallery gallery-container">
                    <a class="thumbnail" href="<?= file_create_url($oAddon->field_thumbnail['und'][0]['uri']) ?>" title="<?= $oAddon->field_add_on_title['und'][0]['value'] ?>">
                        <img  src="<?= file_create_url($oAddon->field_thumbnail['und'][0]['uri']) ?>" title="<?= $oAddon->field_add_on_title['und'][0]['value'] ?>" alt="<?= $oAddon->field_add_on_title['und'][0]['value'] ?>" />
                        <div class="subtitle-pic"><?= $oAddon->field_add_on_title['und'][0]['value'].' '.$oAddon->field_add_on_ref['und'][0]['value'] ?></div>
                    </a>
                </div><?php
            } ?>
    </div>
</div>
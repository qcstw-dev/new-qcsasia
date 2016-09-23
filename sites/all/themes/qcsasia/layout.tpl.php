<div class="visible-lg visible-md"><?php
    global $base_url;
    $aInfoProduct = [];
    foreach ($aProducts as $sCategory => $aGroupProducts) {
        $aInfoProduct['group_products'][$sCategory]['title_group'] = array_shift(array_values(getTermByRef($sCategory, 'category')))->name;
        foreach ($aGroupProducts as $oProduct) {
            $aInfoProduct['group_products'][$sCategory]['products'][$oProduct->tid] =  $oProduct;
            $aImages = [];
            foreach ($oProduct->field_layout_maker_block['und'] as $aFieldlayoutBlock) {
                $aObjectFieldLayoutBlocks = entity_load('field_collection_item', [$aFieldlayoutBlock['value']]);
                foreach ($aObjectFieldLayoutBlocks as $sKey => $oFieldLayoutBlock) {
                    $sColor = ($oFieldLayoutBlock->field_layout_maker_color ? taxonomy_term_load($oFieldLayoutBlock->field_layout_maker_color['und'][0]['tid'])->name : '');
                    $aImages[] = [
                        'uri'       => $oFieldLayoutBlock->field_layout_maker_picture['und'][0]['uri'], 
                        'color'     => $sColor,
                        'item_size' => ($oFieldLayoutBlock->field_item_size ? $oFieldLayoutBlock->field_item_size['und'][0]['value'] : '' ),
                        'logo_size'  => ($oFieldLayoutBlock->field_logo_size ? $oFieldLayoutBlock->field_logo_size['und'][0]['value'] : '' )
                    ];
                }
            }
            $aInfoProduct['group_products'][$sCategory]['products'][$oProduct->tid]->layout_maker_images = $aImages;
        }
    }  
    $bIsUniqueProduct = count($aProducts) == 1; 
        if (!$bIsUniqueProduct) { ?>
            <div class="col-xs-12 padding-0 position-absolute z-index-150 background-white">
                <div class="col-xs-12 hidden-text-area block-choose-product padding-10 border"><?php
                    $sCurrentCategory = array_keys($aInfoProduct['group_products'])[0];
                    foreach ($aInfoProduct['group_products'] as $sCategoryRef => $aGroupProducts) {
                        if ($aGroupProducts['products']) {
                            if ($aGroupProducts['title_group']) { ?>
                                <h3 class="col-xs-12"><?= $aGroupProducts['title_group'] ?></h3><?php
                            }
                            foreach ($aGroupProducts['products'] as $sKey => $oProduct) { ?>
                                <div class="change-product col-md-2" 
                                     data-image-large="<?= file_create_url($oProduct->layout_maker_images[0]['uri']) ?>" 
                                     data-product-id="<?= $oProduct->tid ?>" 
                                     data-ref="<?= $oProduct->field_product_ref['und'][0]['value'] ?>"
                                     data-item-size="<?= ($oProduct->layout_maker_images[0]['item_size'] ?: $oProduct->field_item_size['und'][0]['value'])  ?>"
                                     data-logo-size="<?= ($oProduct->layout_maker_images[0]['logo_size']?: $oProduct->field_logo_size['und'][0]['value']) ?>"
                                     data-product-id="<?= $oProduct->tid ?>">
                                    <div class="thumbnail thumbnail-hover">
                                        <img src="<?= image_style_url('medium', $oProduct->layout_maker_images[0]['uri']) ?>" alt="<?= $oProduct->field_product_ref['und'][0]['value'] ?>"/>
                                        <div class="subtitle-pic"><?= $oProduct->field_product_ref['und'][0]['value'] ?></div>
                                    </div>
                                </div><?php
                            }
                        }
                    } ?>
                </div>
                <div class="clearfix"></div>
                <div class="btn-show-hide-text-area background-primary title-orange"><span class="glyphicon glyphicon-menu-down"></span> Products available in layout maker <span class="glyphicon glyphicon-menu-down"></span></div>
            </div>
            <div class="clearfix"></div>
            <div class="margin-top-50"><?php
                foreach ($aInfoProduct['group_products'] as $aGroupProducts) {
                    foreach ($aGroupProducts['products'] as $oProduct) { ?>
                        <h2 class="display-none product-title product-title-<?= $oProduct->tid ?>"><?= $oProduct->field_product_name['und'][0]['value']." ".$oProduct->field_product_ref['und'][0]['value'] ?></h2><?php
                    }
                } ?>
            </div><?php
        } 
        $oPreselectProduct = (isset(drupal_get_query_parameters()['preselect_prod']) && drupal_get_query_parameters()['preselect_prod'] ? taxonomy_term_load(drupal_get_query_parameters()['preselect_prod']) : ''); 
        if ($bIsUniqueProduct) {
            $oPreselectProduct = array_values(array_values($aInfoProduct['group_products'])[0]['products'])[0];
        }?>
        <div class="col-xs-12 <?= (!$bIsUniqueProduct ? 'margin-top-30' : '') ?>">
            <div id="component" class="component <?= ($bIsUniqueProduct ? 'border-none' : '') ?>">
                <span class="btn btn-primary fileinput-button col-xs-2">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add your logo...</span>
                    <input id="fileupload" type="file" name="files[]" >
                </span>
                <div id="files" class="files"></div>
                <div class="overlay-top"></div>
                <div class="overlay-bottom"></div>
                <div class="overlay-left"></div>
                <div class="overlay-right"></div>
                <div class="overlay" <?php
                    if ($oPreselectProduct) {
                        echo 'data-ref="'.$oPreselectProduct->field_product_ref['und'][0]['value'].'"'
                        .'data-item-size="'.($oPreselectProduct->layout_maker_images[0]['item_size']?: $oPreselectProduct->field_item_size['und'][0]['value']).'"'
                        .'data-logo-size="'.($oPreselectProduct->layout_maker_images[0]['logo_size']?: $oPreselectProduct->field_logo_size['und'][0]['value']).'"';
                    } ?>
                     data-write-info="<?= (!(isset(drupal_get_query_parameters()['write-info']) && drupal_get_query_parameters()['write-info'] == 0) ? 'true' : 'false') ?>">
                    <div class="overlay-inner">
                        <img class="overlay-img <?= !$oPreselectProduct ? 'hidden' : '' ?>" src="<?= ($oPreselectProduct ? file_create_url($oPreselectProduct->layout_maker_images[0]['uri']) : $base_url.'/'.path_to_theme().'/images/layout_maker/drag-and-drop.png') ?>">
                    </div>
                </div>
                <img id="image" class="resize-image" data-is-first-image="1" src="<?php (!$bIsUniqueProduct && !$oPreselectProduct ? print $base_url.'/'.path_to_theme().'/images/layout_maker/drag-and-drop.png' : '') ?>">
                <div id="slider-vertical">
                    <img class="icon-rotate" src="<?php print $base_url.'/'.path_to_theme().'/images/layout_maker/reload.svg' ?>" alt="rotate">
                </div><?php
                    foreach ($aInfoProduct['group_products'] as $aGroupProducts) {
                        foreach ($aGroupProducts['products'] as $oProduct) { ?>
                            <div class="change-color-product-block <?= $oProduct->tid ?> text-left col-xs-3 background-white position-absolute" <?= ($oPreselectProduct && $oProduct->tid == $oPreselectProduct->tid ? 'style="display: block"' : '') ?>><?php
                                if ($oProduct->field_item_size && $oProduct->field_product_ref['und'][0]['value'] != '#ODD') { ?>
                                    <div class="col-xs-12 padding-0 text-center border margin-bottom-10 background-dark-grey">
                                        <div class="col-xs-6">
                                            Item size:
                                        </div>
                                        <div class="col-xs-6 background-white">
                                            <?= $oProduct->field_item_size['und'][0]['value'] ?>
                                        </div>
                                    </div><?php
                                } 
                                if ($oProduct->field_logo_size && $oProduct->field_product_ref['und'][0]['value'] != '#ODD') { ?>
                                    <div class="col-xs-12 padding-0 text-center border margin-bottom-10 background-dark-grey">
                                        <div class="col-xs-6">
                                            Logo size:
                                        </div>
                                        <div class="col-xs-6 background-white">
                                            <?= $oProduct->field_logo_size['und'][0]['value'] ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div><?php
                                } 
                                if (count($oProduct->layout_maker_images) > 1) { ?>
                                    <div class="preview-color <?= $oProduct->tid ?>">
                                        <div class="col-xs-12 padding-0 border margin-bottom-10" <?= (count($oProduct->layout_maker_images) > 10 ? 'style="overflow: auto"': '') ?>>
                                            <div class="subtitle-pic margin-top-0 margin-bottom-10">Colors available:</div><?php
                                                foreach ($oProduct->layout_maker_images as $aImage) { ?>
                                                    <div class="col-xs-6 block-color-product">
                                                        <div class="thumbnail thumbnail-hover">
                                                            <img class="change-color-product <?= $oProduct->tid ?>" 
                                                                 src="<?= file_create_url($aImage['uri']) ?>" 
                                                                 data-image-large="<?= file_create_url($aImage['uri']) ?>" 
                                                                 data-item-size="<?= ($aImage['item_size'] ?: $oProduct->field_item_size['und'][0]['value']) ?>" 
                                                                 data-logo-size="<?= ($aImage['logo_size'] ?: $oProduct->field_logo_size['und'][0]['value']) ?>" 
                                                                 data-product-id="<?= $oProduct->tid ?>" 
                                                                 alt="preview product" />
                                                        </div><?php
                                                        if ($aImage['color'] || $aImage['item_size'] || $aImage['logo_size']) { ?>
                                                            <div class="block-layout-maker-info">
                                                                <?php if ($aImage['color']) { ?>
                                                                    <b>Color:</b><br /> <?= $aImage['color'] ?><?php
                                                                }
                                                                if ($aImage['item_size']) { ?>
                                                                    <b>Item size:</b><br /> <?= $aImage['item_size'] ?><br /><?php
                                                                }
                                                                if ($aImage['logo_size']) { ?>
                                                                    <b>Logo size:</b><br /> <?= $aImage['logo_size'] ?>
                                                                <?php } ?>
                                                            </div><?php
                                                        } ?>
                                                    </div><?php
                                                } ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div><?php
                                } ?>
                            </div><?php
                        }
                    } ?>
                <div class="clear"></div>
                <button class="btn btn-primary btn-crop js-crop">Preview / Download / Send <img class="icon-crop" src="<?php print $base_url.'/'.path_to_theme().'/images/layout_maker/crop.svg' ?>"  alt="crop"></button>
            </div>
        </div>
    <!--<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix col-md-12"<?php print $attributes; ?>>
        <h3>Under construction - coming soon</h3>
        <div class="col-md-6 thumbnail margin-bottom-0 gallery-container">
            <a href="<?= url(($bIsUniqueProduct ? '../' : '').path_to_theme() . "/images/template/layout-maker-large.png") ?>" title="Layout maker">
                <img src="<?= url(($bIsUniqueProduct ? '../' : '').path_to_theme() . "/images/template/layout-maker-large.png") ?>" alt="" title="" />
            </a>
        </div>
        <div class="col-md-6">
            <div class="col-lg-5 margin-auto thumbnail border-none">
                <img src="<?= url(($bIsUniqueProduct ? '../' : '').path_to_theme() . "/images/template/work-in-progress.png") ?>" title="work in progress" alt="" />
            </div>
        </div>
    </div>-->
</div>
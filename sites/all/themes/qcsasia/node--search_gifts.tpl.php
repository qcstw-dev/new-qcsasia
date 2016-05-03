<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="btn-show-hide-text-area margin-bottom-10"><span class="glyphicon glyphicon-menu-down"></span> Filter <span class="glyphicon glyphicon-menu-down"></span></div>
    <div class="block-filter col-md-3 thumbnail padding hidden-text-area">
        <div class="filter-group-title" data-group-title="display"><span class="glyphicon glyphicon-chevron-down"></span> Display</div>
        <div class="block-filter-group group-display"><?php foreach (retrieveFilters('display') as $oTerm) { ?>
            <div>
                <label>
                    <a class="" href="<?= 'search-gifts?display=' . $oTerm->field_reference['und'][0]['value'] ?>"><?= $oTerm->name ?> </a>
                </label>
            </div><?php 
        } ?>
        </div>
        <div class="filter-group-title" data-group-title="theme"><span class="glyphicon glyphicon-chevron-down"></span> Theme</div>
        <div class="block-filter-group group-theme"><?php foreach (retrieveFilters('theme') as $oTerm) { ?>
            <div>
                <label>
                    <a class="" href="<?= 'search-gifts?theme=' . $oTerm->field_reference['und'][0]['value'] ?>"><?= $oTerm->name ?> </a>
                </label>
            </div><?php 
        } ?>
        </div>
        <div class="btn-show-hide-text-area margin-bottom-10"><span class="glyphicon glyphicon-menu-down"></span> Filter <span class="glyphicon glyphicon-menu-down"></span></div>
    </div>
    <div class="col-md-9 padding-0 block-list-products">
        <div class="col-md-12 products_list"><?php 
            if ($aGifts) { 
                $i = 4;
                foreach ($aGifts as $oGift) {
                    if ($i % 4 == 0) { ?>
                        <div class = "col-md-12 padding-0"><?php
                    }
                    displayGiftBlock($oGift);
                    $i++;
                    if ($i % 4 == 0) {
                        ?>
                    </div><?php
                    }
                }
                parse_str($_SERVER['QUERY_STRING'], $aQuery);
                unset($aQuery['category']);
                $sQueryNoCategory = http_build_query($aQuery);
            } else {
                ?>
                <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no gifts matching with your criteria</div><?php }
            ?>
        </div>
    </div>
</div><?php
function displayGiftBlock($oGift) {
    $sName = $oGift->field_product_name['und'][0]['value'];
    $sRef = (isset($oGift->field_product_ref['und'][0]['value']) ? $oGift->field_product_ref['und'][0]['value'] : ''); ?>
    <div class = "block-product col-xs-6 col-md-3">
        <div class = "thumbnail thumbnail-hover">
            <a href = "<?= url('taxonomy/term/' . $oGift->tid) ?>" title = ""><?php 
                $sGiftImageUri = (isset($oGift->field_main_photo['und'][0]['uri']) ? $oGift->field_main_photo['und'][0]['uri'] : loadThemeFirstImageUri($oGift->field_gift_theme['und'][0]['value'])); ?>
                <img src = "<?= file_create_url($sGiftImageUri) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                <div class = "title-product"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}
function loadThemeFirstImageUri ($sId) {
    $field_collection = field_collection_item_load($sId);
    return $field_collection->field_theme_image['und'][0]['uri'];
}

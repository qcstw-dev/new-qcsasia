<?php
if ($aProducts) { 
    $aLineProducts = [];
    $aUsedCategories = []; ?>
    <div class="col-md-12 margin-bottom-10"><strong>Products: <?= count($aProducts) ?></strong></div><?php
    $i = 4;
    foreach ($aProducts as $oProduct) {
        if ($i % 4 == 0) { ?>
            <div class = "col-md-12 padding-0"><?php 
        }
        if (taxonomy_get_parents($oProduct->field_category['und'][0]['tid'])) {
            $oCategory = taxonomy_term_load($oProduct->field_category['und'][0]['tid']);
            if (!in_array($oCategory->field_reference['und'][0]['value'], $aUsedCategories)) {
                displayLineBlock($oCategory, $aLineProducts);
                $aUsedCategories[] = $oCategory->field_reference['und'][0]['value'];
                $i++;
            }
        } else {
            displayProductBlock($oProduct);
            $i++;
        }
        if ($i % 4 == 0) { ?>
            </div><?php
        }
    }
} else { ?>
    <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no products matching with your criteria</div><?php
}

function displayLineBlock($oCategory, $aLineProducts) {
    $sName = $oCategory->field_category_title['und'][0]['value'];
    $sRef = $oCategory->field_category_reference['und'][0]['value'];
    $aLineProducts[$oCategory->field_reference['und'][0]['value']] = []; ?>
    <div class = "block-product block-category col-md-3">
        <div class = "thumbnail">
            <a href = "<?= url('taxonomy/term/' . $oCategory->tid) ?>" title = "">
                <div class="col-md-12 padding-0 products-thumbnails"><?php
                 foreach ($oCategory->field_category_thumbnail['und'] as $aThumbnail) { ?>
                    <img class="col-md-6 padding-0" src = "<?= file_create_url($aThumbnail['uri']) ?>" alt = "" title = "" /><?php
                 } ?>
                </div>
                <div class = "ref-product"><?= ($sRef ? $sRef.' Line' : 'Product line') ?></div>
                <div class = "title-product"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}
function displayProductBlock($oProduct) {
    $sName = $oProduct->field_product_name['und'][0]['value'];
    $sRef = $oProduct->field_product_ref['und'][0]['value']; ?>
    <div class = "block-product col-md-3">
        <div class = "thumbnail">
            <a href = "<?= url('taxonomy/term/' . $oProduct->tid) ?>" title = "">
                <img src = "<?= file_create_url($oProduct->field_thumbnail['und'][0]['uri']) ?>" alt = "" title = "" />
                <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                <div class = "title-product"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}

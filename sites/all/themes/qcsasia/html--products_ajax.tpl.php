<?php
if ($aProducts) {
    $aLineProducts = [];
    $aUsedCategories = []; ?>
    <div class="col-md-12 margin-bottom-10 number-products" data-num-prod="<?= count($aProducts) ?>"><strong><?= count($aProducts) ?> Products</strong></div><?php
    $i = 4;
    foreach ($aProducts as $oProduct) {
       /* if ($i % 4 == 0) {
            ?>
            <div class = "col-md-12 padding-0"><?php
            } */
            if (isset($oProduct->field_category['und'][0]['tid']) && taxonomy_get_parents($oProduct->field_category['und'][0]['tid'])) {
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
            /* if ($i % 4 == 0) {
                ?>
            </div><?php
        } */
    }
    parse_str($_SERVER['QUERY_STRING'], $aQuery);
    unset($aQuery['category']);
    $sQueryNoCategory = http_build_query($aQuery);
    ?>
    <script>
        $('.block-category').on('click', function () {
            var url = baseUrl + '/products_line_ajax/';
            var query = '<?= ($sQueryNoCategory ? '?'.$sQueryNoCategory.'&' : '?') ?>' + 'category=' + $(this).data('reference');
            console.log(url + query);
            displayLineProduct(url + query);
        });<?php 
        
        if (array_key_exists('line', drupal_get_query_parameters())) { ?>
            displayLineProduct('<?= $base_url.'products_line_ajax/?category='.drupal_get_query_parameters()['line'] ?>');<?php
        } ?>
        function displayLineProduct (url) {
            console.log(url);
            $.ajax(url, {
                dataType: 'html',
                success: function (data) {
                    $.magnificPopup.open({
                        items: [{
                                src: $('<div class="white-popup">' + data + '</div>'),
                                type: 'inline'
                            }]
                    });
                }
            });
        }
    </script><?php
} else {
    ?>
    <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no products matching with your criteria</div><?php
}

function displayLineBlock($oCategory, $aLineProducts) {
    $sName = $oCategory->field_category_title['und'][0]['value'];
    $sRef = (isset($oCategory->field_category_reference['und'][0]['value']) ? $oCategory->field_category_reference['und'][0]['value'] : '');
    $aLineProducts[$oCategory->field_reference['und'][0]['value']] = [];
    ?>
    <div class = "block-product block-category col-xs-6 col-md-3" data-reference="<?= $oCategory->field_reference['und'][0]['value'] ?>">
        <div class = "thumbnail thumbnail-hover">
            <div class="col-md-12 padding-0 products-thumbnails"><?php 
                foreach ($oCategory->field_category_thumbnail['und'] as $aThumbnail) { ?>
                <div class="col-xs-6 padding-0 thumbnail margin-0 border-none">
                    <img class="" src = "<?= file_create_url($aThumbnail['uri']) ?>" alt = "" title = "" />
                </div><?php
                }?>
            </div>
            <div class="clearfix"></div>
            <div class = "ref-product"><?= ($sRef ? $sRef . ' Line' : 'Product line') ?></div>
            <div class = "title-product"><?= $sName ?></div>
        </div>
    </div><?php
}

function displayProductBlock($oProduct) {
    $sName = $oProduct->field_product_name['und'][0]['value'];
    $sRef = (isset($oProduct->field_product_ref['und'][0]['value']) ? $oProduct->field_product_ref['und'][0]['value'] : ''); ?>
    <div class = "block-product col-xs-6 col-md-3">
        <div class = "thumbnail">
            <a href = "<?= url('taxonomy/term/' . $oProduct->tid) ?>" title = ""><?php
                $sLogoProcessUri = (isset($oProduct->field_image_logo_process['und'][0]['uri']) ? $oProduct->field_image_logo_process['und'][0]['uri'] : ''); ?>
                <img src = "<?= file_create_url(( $sLogoProcessUri ? : $oProduct->field_main_photo['und'][0]['uri'])) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                <div class = "title-product"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}

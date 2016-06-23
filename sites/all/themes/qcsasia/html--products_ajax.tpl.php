<?php
$bIsDocCenter = isset($_GET['document_center']);
if ($aProducts) {
    $aUsedCategories = []; ?>
    <div class="col-md-12 margin-bottom-10 number-products" data-num-prod="<?= count($aProducts) ?>"><strong><?= count($aProducts) ?> Products</strong></div><?php
    $i = 4;
    $aSelectedCategories = [];
    if (isset(drupal_get_query_parameters()['category'])) {
        $aSelectedCategories = array_keys(getTermByRef(drupal_get_query_parameters()['category'], 'category'));
    }
    foreach ($aProducts as $oProduct) {
        $aParentCategory = [];
        foreach ($oProduct->field_category['und'] as $aCategory) {
            $aParentCategoryKeys = array_keys(taxonomy_get_parents($aCategory['tid']));
            $aParentCategory[$aCategory['tid']] = array_shift($aParentCategoryKeys);
        }
        if (($aParentCategory && array_intersect($aParentCategory, $aSelectedCategories)) || ($aParentCategory && !$aSelectedCategories)) {
            $oCategory = taxonomy_term_load(array_shift(array_keys(array_intersect($aParentCategory, $aSelectedCategories))));
            if (!in_array($oCategory->field_reference['und'][0]['value'], $aUsedCategories)) {
                displayLineBlock($oCategory);
                $aUsedCategories[] = $oCategory->field_reference['und'][0]['value'];
                $i++;
            }
        }
        else {
            displayProductBlock($oProduct, $bIsDocCenter);
            $i++;
        }
    }
    parse_str($_SERVER['QUERY_STRING'], $aQuery);
    unset($aQuery['category']);
    $sQueryNoCategory = http_build_query($aQuery); ?>
    <script>
        $('.block-category').on('click', function () {
            var url = baseUrl + 'products_line_ajax/';
            var query = '<?= ($sQueryNoCategory ? '?'.$sQueryNoCategory.'&' : '?') ?>' + 'category=' + $(this).data('reference');
            console.log(url + query);
            displayLineProduct(url + query);
        });<?php 
        
        if (array_key_exists('line', drupal_get_query_parameters())) { ?>
            displayLineProduct('<?= url('products_line_ajax', ['query' => ['category' => drupal_get_query_parameters()['line'], ($bIsDocCenter ? ['document_center' => null] : [])]]) ?>');<?php
        } ?>
        function displayLineProduct (url) {
            console.log(url);
            $.ajax(url, {
                beforeSend: function () {
                    $.magnificPopup.open({
                        items: [{
                                src: $('<div class="white-popup text-center"><img src="<?= url(path_to_theme() . "/images/template/loader.gif") ?>" /></div>'),
                                type: 'inline'
                            }]
                    });
                },
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

function displayLineBlock($oCategory) {
    $sName = $oCategory->field_category_title['und'][0]['value'];
    $sRef = (isset($oCategory->field_category_reference['und'][0]['value']) ? $oCategory->field_category_reference['und'][0]['value'] : ''); ?>
    <div class = "block-product block-category col-xs-6 col-md-3" data-reference="<?= $oCategory->field_reference['und'][0]['value'] ?>">
        <div class = "thumbnail thumbnail-hover">
            <div class="col-md-12 padding-0 products-thumbnails"><?php 
            if ($oCategory->field_category_thumbnail) {
                foreach ($oCategory->field_category_thumbnail['und'] as $aThumbnail) { ?>
                    <div class="col-xs-6 padding-0 thumbnail margin-0 border-none">
                        <img class="" src = "<?= image_style_url('thumbnail', $aThumbnail['uri']) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                    </div><?php
                }
            } ?>
            </div>
            <div class="clearfix"></div>
            <div class = "ref-product"><?php /*($sRef ? $sRef . ' Line' : (strpos(strtolower($sName), 'metal') !== false ? 'Metal Product line' : 'Product Line'))*/ ?></div>
            <div class = "title-product color-dark-green bold"><?= $sName ?></div>
        </div>
    </div><?php
}

function displayProductBlock($oProduct, $bIsDocCenter) {
    $sName = $oProduct->field_product_name['und'][0]['value'];
    $sRef = (isset($oProduct->field_product_ref['und'][0]['value']) ? $oProduct->field_product_ref['und'][0]['value'] : ''); ?>
    <div class = "block-product col-xs-6 col-md-3">
        <div class = "thumbnail thumbnail-hover">
            <a href = "<?= url('taxonomy/term/' . $oProduct->tid).($bIsDocCenter ? '?document_center' : '') ?>" title = ""><?php
                $aLogoProcesses = getLogoProcesses($oProduct);
                $sLogoProcessUri = (!$aLogoProcesses 
                        ? $oProduct->field_main_photo['und'][0]['uri']
                        : (isset($aLogoProcesses['doming']) && $aLogoProcesses['doming']['thumbnail']
                            ? $aLogoProcesses['doming']['thumbnail'] 
                            : (isset(array_values($aLogoProcesses)[0]['thumbnail']) && array_values($aLogoProcesses)[0]['thumbnail']
                                ? array_values($aLogoProcesses)[0]['thumbnail'] 
                                : $oProduct->field_main_photo['und'][0]['uri']))); ?>
                <img src = "<?= file_create_url($sLogoProcessUri) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                <div class = "title-product"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}

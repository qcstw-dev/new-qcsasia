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
    $aGifts = retrieveByTermName('gift');
    $aWishlist = [];
    if (isset($_SESSION['wishlist']) && $_SESSION['wishlist']) {
        $oWishlist = taxonomy_term_load($_SESSION['wishlist']['id']);
        foreach ($oWishlist->field_product['und'] as $aWishlistProduct) {
            $aWishlist[] = $aWishlistProduct['tid'];
        }
    }
    foreach ($aProducts as $oProduct) {
        $aParentCategory = [];
        foreach ($oProduct->field_category['und'] as $aCategory) {
            $aParentCategoryKeys = array_keys(taxonomy_get_parents($aCategory['tid']));
            $aParentCategory[$aCategory['tid']] = array_shift($aParentCategoryKeys);
        }
        $aParentCategoryValues = array_values($aParentCategory);
        if (($aParentCategory && $aSelectedCategories && array_intersect($aParentCategory, $aSelectedCategories)) || (array_shift($aParentCategoryValues) && !$aSelectedCategories)) {
            if ($aSelectedCategories) {
                $aIntersecKeys = array_keys(array_intersect($aParentCategory, $aSelectedCategories));
                $oCategory = taxonomy_term_load(array_shift($aIntersecKeys));
            } else {
                $aParentCategoriesKeys = array_keys($aParentCategory);
                $oCategory = taxonomy_term_load(array_shift($aParentCategoriesKeys));
            }
            if (!in_array($oCategory->field_reference['und'][0]['value'], $aUsedCategories)) {
                displayLineBlock($oCategory, $oProduct);
                $aUsedCategories[] = $oCategory->field_reference['und'][0]['value'];
                $i++;
            }
        }
        else {
            displayProductBlock($oProduct, $bIsDocCenter, $aGifts, $aWishlist);
            $i++;
        }
    }
    parse_str($_SERVER['QUERY_STRING'], $aQuery);
    unset($aQuery['category']);
    $sQueryNoCategory = http_build_query($aQuery); 
} else { ?>
    <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no products matching with your criteria</div><?php
} ?>
<script>
    $('.block-product .thumbnail').hover(function (){
        $(this).find('.block-toolbox').stop(true, true).show("slide", { direction: "left" }, 100);
    }, function () {
        $(this).find('.block-toolbox').stop(true, true).hide("slide", { direction: "left" }, 100);
    });
    $('.block-category').on('click', function () {
        var url = baseUrl + 'products_line_ajax';
        var currentUrl = baseUrl + (window.location.host !== 'localhost' ? window.location.pathname.split('/')['1'] : window.location.pathname.split('/')['2']);
        var newUrl = currentUrl + '?line=' + $(this).data('reference');
        var query = '<?= ($sQueryNoCategory ? '?'.$sQueryNoCategory.'&' : '?') ?>' + 'category=' + $(this).data('reference');
        console.log(url + query);
        displayLineProduct(url + query, newUrl);
    });
    listenAddToWishlistEvent();
</script>
<?php

function displayLineBlock($oCategory, $oProduct) {
    $sName = $oCategory->field_category_title['und'][0]['value'];
//    $sRef = (isset($oCategory->field_category_reference['und'][0]['value']) ? $oCategory->field_category_reference['und'][0]['value'] : ''); 
    $sRef = preg_replace('/[0-9]+/', '',(isset($oProduct->field_product_ref['und'][0]['value']) ? $oProduct->field_product_ref['und'][0]['value'] : '')); ?>
    <div class = "block-product block-category col-xs-6 col-md-3" data-reference="<?= $oCategory->field_reference['und'][0]['value'] ?>">
        <div class = "thumbnail thumbnail-hover">
            <div class="col-md-12 padding-0 products-thumbnails"><?php 
            if ($oCategory->field_category_thumbnail) {
                foreach ($oCategory->field_category_thumbnail['und'] as $aThumbnail) { ?>
                    <div class="col-xs-6 padding-0 thumbnail margin-0 border-none">
                        <img class="" src = "<?= file_create_url($aThumbnail['uri']) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                    </div><?php
                }
            } ?>
            </div>
            <div class="clearfix"></div>
            <div class="subtitle-pic">
                <div class = "ref-product"><?= $sRef ?></div>
                <div><?= $sName ?></div>
            </div>
        </div>
    </div><?php
}

function displayProductBlock($oProduct, $bIsDocCenter, $aGifts, $aWishlist) {
    $sName = $oProduct->field_product_name['und'][0]['value'];
    $sRef = (isset($oProduct->field_product_ref['und'][0]['value']) ? $oProduct->field_product_ref['und'][0]['value'] : ''); 
    $bIsInWishlist = in_array($oProduct->tid, $aWishlist); ?>
    <div class = "block-product col-xs-6 col-md-3">
        <div class="search-wishlist-btn">
            <span class="add-to-wishlist glyphicon color-grey-hover <?= ($bIsInWishlist ? 'glyphicon-floppy-saved' : 'color-light-grey glyphicon-floppy-disk') ?>" 
                  data-toggle="tooltip" data-placement="top" 
                  title="<?= ($bIsInWishlist ? 'Delete from wishlist' : 'Add to wishlist') ?>" 
                  data-id="<?= $oProduct->tid ?>"></span>
        </div>
        <div class = "thumbnail thumbnail-hover">
            <div class="block-toolbox">
                <div class="block-toolbox-inner"><?php
                    if ($oProduct->field_newsletter_url) { ?>
                        <div>
                            <a data-toggle="tooltip" data-placement="right" href="<?= $oProduct->field_newsletter_url['und'][0]['value'] ?>" title="Related newsletter">
                                <span class="toolbox-icon glyphicon glyphicon-list-alt color-soft-orange"></span>
                            </a>
                        </div><?php
                    } 
                    if (isset($oProduct->field_complicated) && $oProduct->field_complicated['und'][0]['value']) { ?>
                        <div>
                            <a data-toggle="tooltip" data-placement="right" href="<?= url('node/46', ['query' => ['product' => $oProduct->tid]]) ?>" title="Request samples">
                                <span class="toolbox-icon glyphicon glyphicon-transfer color-soft-blue"></span>
                            </a>
                        </div><?php
                    } ?>
                    <div>
                        <a data-toggle="tooltip" data-placement="right" href="<?= url('node/17', ['query' => ['subject' => $sName.' '.$sRef]]) ?>" title="Quick quote" >
                            <span class="toolbox-icon glyphicon glyphicon-envelope color-soft-green"></span>
                        </a>
                    </div><?php
                    foreach ($aGifts as $oGift) {
                        if (isset($oGift->field_product['und'][0]['tid']) && $oGift->field_product['und'][0]['tid'] == $oProduct->tid) { ?>
                            <div>
                                <a data-toggle="tooltip" data-placement="right" href="<?= url('node/33', ['query' => ['gift' => $oGift->tid]]) ?>#themes_list" title="Item in gift line" >
                                    <span class="toolbox-icon glyphicon glyphicon-gift color-red"></span>
                                </a>
                            </div><?php
                        }
                    } ?>
                </div>
            </div>
            <a href = "<?= url('taxonomy/term/' . $oProduct->tid).($bIsDocCenter ? '?document_center' : '') ?>" title = ""><?php
                $aLogoProcesses = getLogoProcesses($oProduct);
                $sLogoProcessUri = (!$aLogoProcesses 
                        ? $oProduct->field_main_photo['und'][0]['uri']
                        : (isset($aLogoProcesses['doming'][0]['thumbnail']) && $aLogoProcesses['doming'][0]['thumbnail']
                            ? $aLogoProcesses['doming'][0]['thumbnail'] 
                            : (isset(array_values($aLogoProcesses)[0][0]['thumbnail']) && array_values($aLogoProcesses)[0][0]['thumbnail']
                                ? array_values($aLogoProcesses)[0][0]['thumbnail'] 
                                : $oProduct->field_main_photo['und'][0]['uri']))); ?>
                <img src = "<?= file_create_url($sLogoProcessUri) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                <div class = "subtitle-pic">
                    <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                    <div><?= $sName ?></div>
                </div>
            </a>
        </div>
    </div><?php
}

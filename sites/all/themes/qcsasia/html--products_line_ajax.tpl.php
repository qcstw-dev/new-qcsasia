<div class="block-line text-left"><?php
    $bIsDocCenter = isset($_GET['document_center']);
    $aProductsLine = getProducts(drupal_get_query_parameters());
    $iNumberProducts = count($aProductsLine);
    $count = 1;
    $aGifts = retrieveByTermName('gift');
    $aWishlist = (isset($_SESSION['wishlist']) && $_SESSION['wishlist'] ? $_SESSION['wishlist']['product_ids'] : [] );
    foreach ($aProductsLine as $key => $oProduct) {
        $oLineProduct = taxonomy_term_load($oProduct->tid); 
        $sRef = ($oLineProduct->field_product_ref['und'][0]['value'] ?: $oLineProduct->field_product_name['und'][0]['value']);
        $sName = (!$oLineProduct->field_product_ref['und'][0]['value'] ? '' :$oLineProduct->field_product_name['und'][0]['value']);
        $bIsInWishlist = in_array($oProduct->tid, $aWishlist);
        if ($count == 1) { ?>
            <div class="col-sm-12"><?php
        } ?>
            <div class="col-sm-4 block-line-product">
                <div class="search-wishlist-btn">
                    <span class="add-to-wishlist glyphicon <?= ($bIsInWishlist ? 'glyphicon-heart' : 'glyphicon-heart-empty') ?>" 
                          data-toggle="tooltip" data-placement="top" 
                          title="<?= ($bIsInWishlist ? 'Delete from wishlist' : 'Add to wishlist') ?>" 
                          data-id="<?= $oProduct->tid ?>"></span>
                </div>
                <div class="thumbnail thumbnail-hover">
                    <a href="<?= url('taxonomy/term/' . $oProduct->tid).($bIsDocCenter ? '?document_center' : '') ?>" title="<?= $oLineProduct->field_product_name['und'][0]['value'] ?>"><?php
                        $sPictureUri = '';
                        if ($oLineProduct->field_logo_process_block) {
                            $aLogoProcesses = getLogoProcesses($oLineProduct);
                            if (isset($aLogoProcesses['doming']) && $aLogoProcesses['doming']['thumbnail']) {
                                $sPictureUri = $aLogoProcesses['doming']['thumbnail'];
                            } else {
                                $sPictureUri = array_values($aLogoProcesses)[0]['thumbnail'];
                            }
                        } ?>
                        <img class="thumbnail border-none" src="<?= file_create_url(($sPictureUri ?: $oLineProduct->field_main_photo['und'][0]['uri'])) ?>" alt="" title="" />
                        <div class="subtitle-pic font-size-13">
                            <div class="title-product-ref"><?= $sRef ?></div>
                            <div class="title-product"> <?= $sName ?></div>
                        </div>
                        <div class="col-xs-12 padding-top-10"><?php
                            if (!$oLineProduct->field_item_size['und'][0]['value'] && !$oLineProduct->field_logo_size['und'][0]['value'] && !$oLineProduct->field_packaging['und'][0]['value']) { ?>
                                <div><strong>Description:</strong> <?= substr(strip_tags($oLineProduct->field_description['und'][0]['value']), 0, 150).' [...]' ?></div><?php
                            } else { ?>
                                <div><strong>Item size:</strong> <?= $oLineProduct->field_item_size['und'][0]['value'] ?></div>
                                <div><strong>Logo size:</strong> <?= $oLineProduct->field_logo_size['und'][0]['value'] ?></div>
                                <div><strong>Packaging:</strong> <?= $oLineProduct->field_packaging['und'][0]['value'] ?></div><?php                        
                            } ?>
                        </div>
                        <div class="col-xs-12 padding-top-10"><?php
                            if ($oLineProduct->field_newsletter_url) { ?>
                                <div>
                                    <span class="toolbox-icon glyphicon glyphicon-list-alt color-soft-orange"></span>
                                    <a class="text-underline-hover" href="<?= $oLineProduct->field_newsletter_url['und'][0]['value'] ?>" title="Related newsletter">
                                        Related newsletter
                                    </a>
                                </div><?php
                            } 
                            if (isset($oLineProduct->field_complicated) && $oLineProduct->field_complicated['und'][0]['value']) { ?>
                                <div>
                                    <span class="toolbox-icon glyphicon glyphicon-transfer color-soft-blue"></span>
                                    <a class="text-underline-hover" href="<?= url('node/46', ['query' => ['product' => $oLineProduct->tid]]) ?>" title="Request samples">
                                        Request samples
                                    </a>
                                </div><?php
                            } ?>
                            <div>
                                <span class="toolbox-icon glyphicon glyphicon-envelope color-soft-green"></span> 
                                <a class="text-underline-hover" href="<?= url('node/17', ['query' => ['subject' => $sName.' '.$sRef]]) ?>" title="Quick quote" >
                                    Quick quote
                                </a>
                            </div><?php
                            foreach ($aGifts as $oGift) {
                                if (isset($oGift->field_product['und'][0]['tid']) && $oGift->field_product['und'][0]['tid'] == $oLineProduct->tid) { ?>
                                    <div>
                                        <span class="toolbox-icon glyphicon glyphicon-gift color-red"></span>
                                        <a class="text-underline-hover" href="<?= url('node/33', ['query' => ['gift' => $oGift->tid]]) ?>#themes_list" title="Item in gift line" >
                                            Item in gift line
                                        </a>
                                    </div><?php
                                }
                            } ?>
                        </div>
                    </a>
                    <div class="clearfix"></div>
                </div>
        </div><?php 
        if ($count % 3 == 0) { ?>
            </div>
            <div class="col-sm-12"><?php
        } 
        if ($count == count($aProductsLine)) { ?>
            </div><?php
        }
        $count++;
    }?>
</div>
<div class="clearfix"></div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    $('.add-to-wishlist').click(function (){
        $(this).toggleClass('glyphicon-heart-empty').toggleClass('glyphicon-heart');
        if ($(this).hasClass('glyphicon-heart')) {
            $(this).attr('title', 'Delete from wishlist').tooltip('fixTitle').tooltip('show');
        } else {
            $(this).attr('title', 'Add to wishlist').tooltip('fixTitle').tooltip('show');
        }
        addToWishlist($(this).data('id'));
    });
    $('.wishlist-remove-prod').click(function () {
       $('.block-wishlist-prod-'+$(this).data('id')).fadeOut();
    });
</script>
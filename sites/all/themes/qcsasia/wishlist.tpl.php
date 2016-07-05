<h2>Wishlist <?= $term->tid ?> 
    <a class="pull-right font-size-18" href="mailto:info@qcsasia.com?subject=Wishlist - QCS Asia&body=<?= url('taxonomy/term/'.$term->tid, ['absolute' => true]) ?>">
        <span class="glyphicon glyphicon-share-alt"></span> Share this wishlist
    </a>    
</h2><?php
// retrieve products
$aProducts = [];
foreach ($term->field_product['und'] as $aWishlistProduct) {
    $aProducts[] = taxonomy_term_load($aWishlistProduct['tid']);
}

// display products
foreach ($aProducts as $oProduct) { 
    $sProductTitle = $oProduct->field_product_name['und'][0]['value']." ".$oProduct->field_product_ref['und'][0]['value']; 
    $aLogoProcesses = getLogoProcesses($oProduct);
    $sLogoProcessUri = (!$aLogoProcesses 
            ? $oProduct->field_main_photo['und'][0]['uri']
            : (isset($aLogoProcesses['doming']) && $aLogoProcesses['doming']['thumbnail']
                ? $aLogoProcesses['doming']['thumbnail'] 
                : (isset(array_values($aLogoProcesses)[0]['thumbnail']) && array_values($aLogoProcesses)[0]['thumbnail']
                    ? array_values($aLogoProcesses)[0]['thumbnail'] 
                    : $oProduct->field_main_photo['und'][0]['uri']))); ?>
    <div class="block-wishlist-prod-<?= $oProduct->tid ?> col-xs-12 thumbnail thumbnail-hover">
        <a href="<?= url('taxonomy/term/'.$oProduct->tid) ?>" title="<?= $sProductTitle ?>">
            <div class="col-sm-2 thumbnail margin-bottom-0">
                <img src="<?= file_create_url($sLogoProcessUri) ?>" title="<?= $sProductTitle ?>" alt="<?= $sProductTitle ?>" />
            </div>
            <div class="col-sm-6">
                <div class="font-size-20 bold margin-bottom-20 margin-top-10"><?= $sProductTitle ?></div>
                <div class="margin-bottom-10"><strong>Description:</strong> <?= substr(strip_tags($oProduct->field_description['und'][0]['value']), 0, 150).' [...]' ?></div>
                <div><strong>Item size:</strong> <?= $oProduct->field_item_size['und'][0]['value'] ?></div>
                <div><strong>Logo size:</strong> <?= $oProduct->field_logo_size['und'][0]['value'] ?></div>
                <div><strong>Packaging:</strong> <?= $oProduct->field_packaging['und'][0]['value'] ?></div>
            </div>
            <div class="col-sm-3 padding-0 margin-top-10">
                <div class="well bottom-0">
                    <div class="font-size-18 bold margin-bottom-10">Toolbox</div><?php
                    if ($oProduct->field_newsletter_url) { ?>
                        <div>
                            <span class="toolbox-icon glyphicon glyphicon-list-alt color-soft-orange"></span>
                            <a class="text-underline-hover" href="<?= $oProduct->field_newsletter_url['und'][0]['value'] ?>" title="Related newsletter">
                                Related newsletter
                            </a>
                        </div><?php
                    } 
                    if (isset($oProduct->field_complicated) && $oProduct->field_complicated['und'][0]['value']) { ?>
                        <div>
                            <span class="toolbox-icon glyphicon glyphicon-transfer color-soft-blue"></span>
                            <a class="text-underline-hover" href="<?= url('node/46', ['query' => ['product' => $oProduct->tid]]) ?>" title="Request samples">
                                Request samples
                            </a>
                        </div><?php
                    } ?>
                    <div>
                        <span class="toolbox-icon glyphicon glyphicon-envelope color-soft-green"></span> 
                        <a class="text-underline-hover" href="<?= url('node/17', ['query' => ['subject' => $sProductTitle]]) ?>" title="Quick quote" >
                            Quick quote
                        </a>
                    </div><?php
                    foreach ($aGifts as $oGift) {
                        if (isset($oGift->field_product['und'][0]['tid']) && $oGift->field_product['und'][0]['tid'] == $oProduct->tid) { ?>
                            <div>
                                <span class="toolbox-icon glyphicon glyphicon-gift color-red"></span>
                                <a class="text-underline-hover" href="<?= url('node/33', ['query' => ['gift' => $oGift->tid]]) ?>#themes_list" title="Item in gift line" >
                                    Item in gift line
                                </a>
                            </div><?php
                        }
                    } ?>
                </div>
            </div><?php
            if (isset($_SESSION['wishlist']['id']) && $_SESSION['wishlist']['id'] == $term->tid) { ?>
                <div data-toggle="tooltip" data-placement="top" title="Delete this product from the wishlist" class="wishlist-remove-prod add-to-wishlist" data-id="<?= $oProduct->tid ?>" >
                    <span class="glyphicon glyphicon-remove font-size-24"></span>
                </div><?php
            } ?>
        </a>
        <div class="clearfix"></div>
    </div><?php
}
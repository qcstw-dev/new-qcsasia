<?php
if (!isset(drupal_get_query_parameters()['wishlist']) || !wishlistExist(drupal_get_query_parameters()['wishlist'])) { ?>
    <div class="alert alert-warning bold">
        This wishlist cannot be found...
    </div><?php
} else {
    $oWishlist = taxonomy_term_load(drupal_get_query_parameters()['wishlist']); ?>
    <h2>Wishlist <?= $oWishlist->tid ?>
        <a class="pull-right font-size-18" href="<?= url('', ['query' => ['new_wishlist' => null]]) ?>" data-toggle="tooltip" data-placement="top" title="You won't be able to modify the current wishlist anymore" >
            <span class="glyphicon glyphicon-plus"></span> Create a new wishlist
        </a>
    </h2>
    <div class="col-xs-12"><?php
        // retrieve products
        $aProducts = [];
        foreach ($oWishlist->field_product['und'] as $aWishlistProduct) {
            $aProducts[] = taxonomy_term_load($aWishlistProduct['tid']);
        }
        // display products
        if ($aProducts) {
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
                <div class="block-wishlist-prod block-wishlist-prod-<?= $oProduct->tid ?> col-xs-12 thumbnail thumbnail-hover" data-id="<?= $oProduct->tid ?>">
                    <a href="<?= url('taxonomy/term/'.$oProduct->tid) ?>" title="<?= $sProductTitle ?>">
                        <div class="col-sm-2 thumbnail margin-bottom-0">
                            <img src="<?= file_create_url($sLogoProcessUri) ?>" title="<?= $sProductTitle ?>" alt="<?= $sProductTitle ?>" />
                        </div>
                        <div class="col-sm-6 margin-top-10">
                            <div class="product-title font-size-20 bold margin-bottom-20"><?= $sProductTitle ?></div>
                            <div class="margin-bottom-10"><strong>Description:</strong> <?= substr(strip_tags($oProduct->field_description['und'][0]['value']), 0, 140).' [...]' ?></div>
                            <div><strong>Item size:</strong> <?= $oProduct->field_item_size['und'][0]['value'] ?></div>
                            <div><strong>Logo size:</strong> <?= $oProduct->field_logo_size['und'][0]['value'] ?></div>
                            <div><strong>Packaging:</strong> <?= $oProduct->field_packaging['und'][0]['value'] ?></div>
                        </div>
                    </a>
                    <div class="col-sm-3 padding-0 panel panel-default margin-top-10">
                        <div class="panel-heading">
                            <div class="panel-title">Toolbox</div>
                        </div>
                        <div class="panel-body"><?php
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
                    if (isset($_SESSION['wishlist']['id']) && $_SESSION['wishlist']['id'] == $oWishlist->tid) { ?>
                        <div data-toggle="tooltip" data-placement="top" title="Delete this product from the wishlist" class="wishlist-remove-prod add-to-wishlist" data-id="<?= $oProduct->tid ?>" >
                            <span class="glyphicon glyphicon-remove font-size-24"></span>
                        </div><?php
                    } ?>
                    <div class="clearfix"></div>
                    </div><?php
                } ?>
            <div class="block-button">
                <div class="btn btn-default btn-quotation">Send quotation request for all products listed</div>
                <div class="btn btn-default btn-samples">Send samples request for all products listed</div>
                <div class="col-xs-12 alert alert-warning padding-10 margin-top-20">
                    <div class="col-xs-1 font-size-40">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                    </div>
                    <div class="col-xs-11">
                        <p>If you want to be able to get back to your wishlist, please 
                            <span class="bookmark link bold" data-title="Wishlist - <?= variable_get('site_name') ?>" 
                                  data-url="<?= url('taxonomy/term'.$oWishlist->tid, ['absolute' => true]) ?>" rel="sidebar">bookmark this page</span> or save wishlist page URL, otherwise the wishlist will be lost</p>
                        <p class="margin-bottom-0">Note that your for wishlist will be saved for <b>two weeks only</b></p>
                    </div>
                </div>
            </div><?php
        } ?>
        <div class="col-xs-12 message-no-product alert alert-success <?= ($aProducts ? 'hidden' : '') ?>">
            There is no products in your wishlist, <a href="<?= url('node/13') ?>" class="link bold" title="Promotional Products">find products to add here</a>
        </div>
    </div>
    <script>
        listenAddToWishlistEvent();
        $('.wishlist-remove-prod').click(function () {
            $('.block-wishlist-prod-'+$(this).data('id')).fadeOut('slow', function() {
                $(this).remove();
               if (!$('.block-wishlist-prod').length) {
                   $('.message-no-product').removeClass('hidden');
                   $('.block-button').addClass('hidden');
               }
            });
        });
        $('.btn-quotation').click(function () {
            var sQuery = '';
            $('.block-wishlist-prod').each(function () {
                sQuery += (sQuery ? '&' : '')+'product[]='+$(this).data('id');
            });
            window.location.href = baseUrl+'contact-us/?subject=Quotation request for all products listed&'+sQuery;
        });
        $('.btn-samples').click(function () {
            var sQuery = '';
            $('.block-wishlist-prod').each(function () {
                sQuery += (sQuery ? '&' : '')+'product[]='+$(this).data('id');
            });
            window.location.href = baseUrl+'samples-and-prototypes/?'+sQuery;
        });
        function openPopupInstruction () {
            $.magnificPopup.open({
                items: [{
                    src: $('<div class="white-popup bold">' +
                            'Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') !== - 1 ? 'Command/Cmd' : 'CTRL') + ' + D to bookmark this page.' +
                            '</div>'),
                    type: 'inline'
                }]
            });
        }

    </script><?php
}

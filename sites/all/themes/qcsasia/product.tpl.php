<div class="product-page"><?php
    $sProductTitle = $term->field_product_name['und'][0]['value']." ".$term->field_product_ref['und'][0]['value'];
    $bIsDocCenter = isset($_GET['document_center']);
    $aWishlist = (isset($_SESSION['wishlist']) && $_SESSION['wishlist'] ? $_SESSION['wishlist']['product_ids'] : [] );
    $bIsInWishlist = in_array($term->tid, $aWishlist);
    if ($bIsDocCenter) { ?>
        <h2><?= $sProductTitle ?></h2><?php
    } ?>
    <div class="col-sm-3 main-picture-block margin-top-10 padding-0">
        <div class="thumbnail thumb margin-bottom-10"><?php 
            foreach ($term->field_main_photo['und'] as $aFieldMainPhoto) { 
                $sUlrLargeMainPicture = ($term->field_large_main_photo ? file_create_url($term->field_large_main_photo['und'][0]['uri']) : ''); ?>
                <div class="event-enlarge">
                    <img src="<?= file_create_url($aFieldMainPhoto['uri']) ?>" data-large-picture="<?= $sUlrLargeMainPicture ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" />
                    <div class="enlarge"><span class="glyphicon glyphicon-zoom-in"></span></div>
                </div><?php
            }
            if ($term->field_photo_function) {
                $sUlrLargeFunctionPicture =  file_create_url($term->field_photo_function['und'][0]['uri']); ?>
                <div class="event-enlarge">
                    <img src="<?= $sUlrLargeFunctionPicture ?>" data-large-picture="<?= $sUlrLargeFunctionPicture ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" />
                    <div class="enlarge"><span class="glyphicon glyphicon-zoom-in"></span></div>
                </div><?php 
            } ?>
        </div>
        <img class="hidden" src="<?= $sUlrLargeMainPicture ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" /><?php
        if ($term->field_photo_function) { ?>
            <img class="hidden" src="<?= $sUlrLargeFunctionPicture ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" /><?php
        } ?>
        <div class="padding-left-30 padding-right-30">
            <div class="thumbnails"><?php 
                foreach ($term->field_main_photo['und'] as $aFieldMainPhoto) { ?>
                    <div class="padding-5"><img src="<?= file_create_url($aFieldMainPhoto['uri']) ?>" title="<?= ($aFieldMainPhoto['title'] ?: $term->field_product_name['und'][0]['value']) ?>" alt="<?= ($aFieldMainPhoto['uri'] ?: $term->field_product_name['und'][0]['value']) ?>" /></div><?php
                }
                if ($term->field_photo_function) { ?>
                    <div class="padding-5"><img src="<?= file_create_url($term->field_photo_function['und'][0]['uri']) ?>" title="<?= ($term->field_photo_function['und'][0]['title'] ?: $term->field_product_name['und'][0]['value']) ?>" alt="<?= ($term->field_photo_function['und'][0]['title'] ?: $term->field_product_name['und'][0]['value']) ?>" /></div><?php 
                }
                if ($term->field_youtube_video) { ?>
                    <div class="padding-5"><span class="glyphicon glyphicon-play-circle font-size-65 play-video" ></span></div><?php
                } ?>
            </div>
        </div>
    </div><?php
    if ($bIsDocCenter) { ?>
        <div class="col-sm-9 document-center">
            <h3>Document center</h3>
            <div class="border padding-10"><?php
                displayDocumentCenter($term); ?>
                <div class="clearfix"></div>
            </div>
        </div><?php
    } else { ?>
        <div class="col-sm-9">
            <h2><?= $sProductTitle ?>
                <span data-toggle="tooltip" data-placement="top" 
                      title="<?= ($bIsInWishlist ? 'Delete from wishlist' : 'Add to wishlist') ?>" 
                      class="add-to-wishlist pull-right margin-right-sm-10 cursor-pointer text-right glyphicon 
                        <?= ($bIsInWishlist ? 'glyphicon-heart' : 'glyphicon-heart-empty') ?> " data-id="<?= $term->tid ?>"></span></h2>
            <div class="panel panel-default"><?php
                $sColspan = "";
                if ($term->field_patent || $term->field_packing || $term->field_item_size) {
                    $sColspan = "5";
                } else {
                    $sColspan = "3";
                } ?>
                <!-- Table -->
                <table class="table table-product">
                    <tbody class="border-none">
                        <tr>
                            <td class="border-right cell-key">Description</td>
                            <td colspan="<?= $sColspan ?>"><?= $term->field_description['und'][0]['value'] ?></td>
                        </tr><?php
                        if ($term->field_complicated['und'][0]['value']) {
                            if ($term->field_technical_info) { ?>
                                <tr>
                                    <td class="border-right cell-key">Technical info</td>
                                    <td colspan="<?= $sColspan ?>"><?= $term->field_technical_info['und'][0]['value'] ?></td>
                                </tr><?php
                            }
                            if ($term->field_packing  || $term->field_attachement) { ?>
                                <tr><?php
                                    if ($term->field_attachement) { ?>
                                        <td class="border-right cell-key">Attachement</td>
                                        <td colspan="<?= ($term->field_patent || $term->field_packing || $term->field_item_size ? '3' : '4') ?>"><?= $term->field_attachement['und'][0]['value'] ?></td><?php
                                    }
                                    if ($term->field_packing) { ?>
                                        <td class="border-right cell-key <?= ($term->field_attachement ? 'border-left': '') ?>">Packing</td>
                                        <td><?= $term->field_packing ['und'][0]['value'] ?></td><?php
                                    } ?>
                                </tr><?php
                            }
                            if ($term->field_packaging) { ?>
                                <tr>
                                    <td class="border-right cell-key">Packaging</td>
                                    <td colspan="<?= $sColspan ?>"><?= $term->field_packaging['und'][0]['value'] ?></td>
                                </tr><?php
                            } 
                            if ($term->field_logo_size['und'][0]['value'] || $term->field_item_size['und'][0]['value'] || $term->field_patent['und'][0]['value']) { ?>
                                <tr class="visible-sm visible-md visible-lg"><?php
                                    if ($term->field_logo_size['und'][0]['value']) { ?>
                                        <td class="border-right cell-key">Logo size</td>
                                        <td><?= $term->field_logo_size['und'][0]['value'] ?></td><?php
                                    } 
                                    if ($term->field_item_size['und'][0]['value']) { ?>
                                        <td class="border-left border-right cell-key">Item size</td>
                                        <td><?= $term->field_item_size['und'][0]['value'] ?></td><?php
                                    }
                                    if ($term->field_patent['und'][0]['value']) { ?>
                                        <td class="border-left border-right cell-key">Patent</td>
                                        <td><?= $term->field_patent['und'][0]['value'] ?></td><?php
                                    } ?>
                                </tr><?php // version mobile responsive, several rows
                                    if ($term->field_logo_size['und'][0]['value']) { ?>
                                        <tr class="visible-xs">
                                            <td class="border-right cell-key">Logo size</td>
                                            <td><?= $term->field_logo_size['und'][0]['value'] ?></td>
                                        </tr><?php
                                    } 
                                    if ($term->field_item_size['und'][0]['value']) { ?>
                                        <tr class="visible-xs">
                                            <td class="border-left border-right cell-key">Item size</td>
                                            <td><?= $term->field_item_size['und'][0]['value'] ?></td>
                                        </tr><?php
                                    }
                                    if ($term->field_patent['und'][0]['value']) { ?>
                                        <tr class="visible-xs">
                                            <td class="border-left border-right cell-key">Patent</td>
                                            <td><?= $term->field_patent['und'][0]['value'] ?></td>
                                        </tr><?php
                                    } 
                            } 
                            if ($term->field_colors) { ?>
                                <tr>
                                    <td class="border-right cell-key">Colors available</td>
                                    <td colspan="<?= $sColspan ?>"><?php
                                        foreach ($term->field_colors['und'] as $value) {
                                            $sImageColor = taxonomy_term_load($value['tid'])->name.'.png'; ?>
                                            <img class="pull-left margin-right-md-10" src="<?= url(path_to_theme() . "/images/colors/$sImageColor") ?>" alt="" title="" /><?php
                                        } ?>
                                    </td>
                                </tr><?php
                            } 
                        } 
                        if ($term->field_display_image_finishes['und'][0]['value']) { ?>
                            <tr>
                                <td class="border-right cell-key">Colors available</td>
                                <td colspan="<?= $sColspan ?>">
                                    <div class="thumbnail border-none margin-bottom-0 event-enlarge">
                                        <img src="<?= url(path_to_theme() . "/images/colors/finishes.jpg") ?>" data-large-picture="<?= url(path_to_theme() . "/images/colors/finishes-large.jpg") ?>" alt="Finishes available" title="Finishes available" />
                                    </div>
                                </td>
                            </tr><?php
                        } ?>
                            <tr>
                                <td class="border-right cell-key">Toolbox</td>
                                <td colspan="5"><?php
                                    if ($term->field_newsletter_url) { ?>
                                        <div class="col-sm-6 col-md-3 padding-0">
                                            <a class="color-inherit" href="<?= $term->field_newsletter_url['und'][0]['value'] ?>" title="Related newsletter" >
                                                <span class="toolbox-icon glyphicon glyphicon-list-alt color-soft-orange"></span> Related newsletter
                                            </a>
                                        </div><?php
                                    } 
                                    $oSamplesNode = node_load(46);
                                    $aSamplesForm = drupal_get_form('webform_client_form_46', $oSamplesNode);
                                    $aSamplesValues = $aSamplesForm['submitted']['product']['#options'];
                                    if (array_intersect([$term->tid.'L',$term->tid.'B'], array_keys($aSamplesValues))) { ?>
                                        <div class="col-sm-6 col-md-3 padding-0">
                                            <a class="color-inherit" href="<?= url('node/46', ['query' => ['product' => $term->tid]]) ?>" title="Samples & prototypes" >
                                                <span class="toolbox-icon glyphicon glyphicon-transfer color-soft-blue"></span> Request samples
                                            </a>
                                        </div><?php
                                    } ?>
                                    <div class="col-sm-6 col-md-3 padding-0">
                                        <a class="color-inherit" href="<?= url('node/17', ['query' => ['subject' => $sProductTitle]]) ?>" title="Quick quote" >
                                            <span class="toolbox-icon glyphicon glyphicon-envelope color-soft-green"></span> Quick quote
                                        </a>
                                    </div><?php
                                    $aGifts = retrieveByTermName('gift');
                                    foreach ($aGifts as $oGift) {
                                        if (isset($oGift->field_product['und'][0]['tid']) && $oGift->field_product['und'][0]['tid'] == $term->tid) { ?>
                                            <div class="col-sm-6 col-md-3 padding-0">
                                                <a class="color-inherit" href="<?= url('node/33', ['query' => ['gift' => $oGift->tid]]) ?>#themes_list" title="Item in gift line" >
                                                    <span class="toolbox-icon glyphicon glyphicon-gift color-red"></span> Item in gift line
                                                </a>
                                            </div><?php
                                        }
                                    } ?>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 block-tabs">
            <nav class="navbar navbar-default margin-bottom-0">
                <div class=" navbar-collapse padding-0 tabs" id="navbar-collapse-menu-tab">
                    <ul class="nav navbar-nav text-center"><?php
                        $bIsMetalEnamelCategory = getTopCategoryReferenceByProduct($term) == 'metal-enamel' && !(isset($term->field_complicated) && $term->field_complicated['und'][0]['value']);
                        
                        $bDisplayLogoProcess = false;
                        $bDisplayOption = false;
                        $bDisplayLayoutMaker = false;
                        $bDisplayDocCenter = false;
                        
                        if ($term->field_logo_process_block) { ?>
                            <li class="border-right <?php 
                            if ($bIsMetalEnamelCategory && $term->field_image_option) { 
                                $bDisplayLogoProcess = false;
                                } else if ($term->field_logo_process_block) {
                                    $bDisplayLogoProcess = true; 
                                    echo "active"; 
                                } ?>">
                                <a class="tab" data-id-tab="1">Logo process</a>
                            </li><?php
                        }
                        if ($term->field_image_option) {?>
                            <li <?php if ((!$bDisplayLogoProcess && !$bIsMetalEnamelCategory) || $bIsMetalEnamelCategory) {
                                $bDisplayOption = true;
                                echo 'class="active"';
                            } ?>>
                                <a class="border-right tab" data-id-tab="2">Options</a>
                            </li><?php
                        } 
                        if ($term->field_complicated['und'][0]['value']) { ?>
                            <li <?php if (!$bDisplayOption && !$bDisplayLogoProcess) {
                                $bDisplayLayoutMaker = true;
                                echo 'class="active"'; 
                            } ?>>
                                <a class="border-right tab" data-id-tab="3">Layout maker</a>
                            </li><?php
                        } 
                        if ($term->field_group_document && $term->field_complicated['und'][0]['value']) { ?>
                            <li <?php 
                            if (!$bDisplayLayoutMaker && !$bDisplayOption && !$bDisplayLogoProcess) {
                                $bDisplayDocCenter = true;
                                echo 'class="active"'; 
                            } ?>>
                                <a class="tab" data-id-tab="4">Document center</a></li><?php
                        } ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav><?php
            if ($term->field_logo_process_block) { ?>
                <div class="tab-block tab-block-1 block-logo border border-top-0 <?= ($bDisplayLogoProcess ? "block-active" : '') ?>"><?php
                        displayLogoProcess($term); ?>
                    <div class="clearfix"></div>
                </div><?php
            } 
            if ($term->field_image_option) { ?>
                <div class="tab-block tab-block-2 border border-top-0 padding-top-10 padding-bottom-10 
                <?= ($bDisplayOption ? "block-active" : '') ?>"><?php
                    foreach ($term->field_image_option['und'] as $aImageOption) {
                        displayOption($aImageOption);
                    } ?>
                    <div class="clearfix"></div>
                </div><?php
            } ?>
            <div class="tab-block tab-block-3 border border-top-0 padding-20 <?= ($bDisplayLayoutMaker ? "block-active" : '') ?>">
                <div class="col-md-6 thumbnail margin-bottom-0 gallery-container">
                    <a href="<?= url(path_to_theme() . "/images/template/layout-maker-large.png") ?>" title="Layout maker">
                        <img src="<?= url(path_to_theme() . "/images/template/layout-maker-large.png") ?>" alt="" title="" />
                    </a>
                </div>
                <div class="col-md-6">
                    <h3>Under construction - coming soon</h3>
                    <div class="col-lg-5 margin-auto thumbnail border-none">
                        <img src="<?= url(path_to_theme() . "/images/template/work-in-progress.png") ?>" title="work in progress" alt="" />
                    </div>
                    <!--<p class="text-right bold"><a href="#" ><span class="glyphicon glyphicon-edit"></span> Customise your product</a></p>-->
                </div>
                <div class="clearfix"></div>
            </div><?php
            if ($term->field_group_document) { ?>
                <div class="tab-block tab-block-4 border border-top-0 padding-20 document-center padding-top-20 <?= ($bDisplayDocCenter ? "block-active" : '') ?>"><?php
                     displayDocumentCenter($term); ?>
                    <div class="clearfix"></div>
                </div><?php
            } ?>
        </div><?php
        if ($term->field_you_might_like) { ?>
            <div class="col-md-12 margin-top-20 ymal">
                <h3 class="margin-0">You might also like</h3>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 border padding-top-20 padding-0">
                    <div class="padding-left-30 padding-right-30">
                        <div class="big-slick ymal-pics"><?php
                            foreach ($term->field_you_might_like['und'] as $aYouMightLike) { 
                                $oYouMightLikeEntity = taxonomy_term_load($aYouMightLike['tid']);
                                $aLogoProcesses = getLogoProcesses($oYouMightLikeEntity);
                                $sProductYouMightLikeUrl = (!$aLogoProcesses 
                                        ? $oYouMightLikeEntity->field_main_photo['und'][0]['uri'] 
                                        : isset($aLogoProcesses['doming']['thumbnail']) && $aLogoProcesses['doming']['thumbnail'] 
                                            ? $aLogoProcesses['doming']['thumbnail'] 
                                            : (array_shift($aLogoProcesses)['thumbnail'] ?: $oYouMightLikeEntity->field_main_photo['und'][0]['uri'])); ?>
                                    <a href="<?= url('taxonomy/term/' . $oYouMightLikeEntity->tid) ?>">
                                        <div class="col-md-12">
                                            <div class="thumbnail margin-bottom-0">
                                                <img src="<?= file_create_url($sProductYouMightLikeUrl) ?>" title="<?= $oYouMightLikeEntity->field_product_name['und'][0]['value'] ?>" alt="<?= $oYouMightLikeEntity->field_product_name['und'][0]['value'] ?>" />
                                                <div class="subtitle-pic"><?= $oYouMightLikeEntity->field_product_name['und'][0]['value'] ?></div>
                                            </div>
                                        </div>
                                    </a><?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div><?php
        }
    } ?>
</div>
<script>
    $('.tab').on('click', function () {
        $('.tab').parent().removeClass('active');
        $(this).parent().addClass('active');
        $('.tab-block').removeClass('block-active');
        $('.tab-block-' + $(this).data('id-tab')).addClass('block-active');
    });
    $('.event-enlarge').on('click', function () {
        if ($(window).width() >= 768) {
            var src = '';
            if ($(this).find('img').data('large-picture')) {
                src = $(this).find('img').data('large-picture');
            } else {
                src = $(this).find('img').attr('src');
            }
            $.magnificPopup.open({
                items: [{
                        src: $('<div class="white-popup">' +
                                '<div class="thumbnail border-none"><img src="' + src + '" /></div>' +
                                '</div>'),
                        type: 'inline'

                    }]
            });
        }
    });<?php
    if ($term->field_youtube_video) { ?>
        $('.play-video').on('click', function () {
            $.magnificPopup.open({
                items: [{
                        src: $('<div class="white-popup">' +
                                '<div><?= $term->field_youtube_video['und'][0]['value'] ?></div>' +
                                '</div>'),
                        type: 'inline'

                    }]
            });
        }); <?php
    } ?>
    $('.thumb').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        centerMode: true,
        asNavFor: '.thumbnails'
    });
    $('.thumbnails').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.thumb',
        variableWidth: true,
        infinite: true,
        arrows: true,
        focusOnSelect: true
    });
    $('.ymal-pics').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>
<div class="product-page">
    <div class="col-sm-3 main-picture-block margin-top-20 padding-0">
        <div class="thumbnail thumb margin-bottom-10"><?php 
            foreach ($term->field_main_photo['und'] as $aFieldMainPhoto) { ?>
            <div class="event-enlarge"><img src="<?= file_create_url($aFieldMainPhoto['uri']) ?>" data-large-picture="<?= ($term->field_large_main_photo ? file_create_url($term->field_large_main_photo['und'][0]['uri']) : '') ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" /></div><?php
            }
            if ($term->field_photo_function) { ?>
            <div class="event-enlarge"><img src="<?= file_create_url($term->field_photo_function['und'][0]['uri']) ?>" data-large-picture="<?= file_create_url($term->field_photo_function['und'][0]['uri']) ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" /></div><?php 
            } ?>
        </div>
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
        <div class="enlarge event-enlarge"><span class="glyphicon glyphicon-zoom-in"></span></div>
    </div>
    <div class="col-sm-9">
        <h2><?= $term->field_product_name['und'][0]['value']." ".$term->field_product_ref['und'][0]['value'] ?></h2>
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
                        if ($term->field_display_image_finishes['und'][0]['value']) { ?>
                            <tr>
                                <td class="border-right cell-key">Colors available</td>
                                <td colspan="<?= $sColspan ?>">
                                    <div class="thumbnail border-none margin-bottom-0 event-enlarge">
                                        <img src="<?= url(path_to_theme() . "/images/colors/finishes.jpg") ?>" data-large-picture="<?= url(path_to_theme() . "/images/colors/finishes-large.jpg") ?>" alt="Finishes available" title="Finishes available" />
                                    </div>
                                </td>
                            </tr><?php
                        } 
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 block-tabs">
        <nav class="navbar navbar-default margin-bottom-0">
            <div class=" navbar-collapse padding-0 tabs" id="navbar-collapse-menu-tab">
                <ul class="nav navbar-nav text-center"><?php
                    if ($term->field_logo_process_block) { ?>
                        <li class="border-right <?= ($term->field_logo_process_block ? "active" : '') ?>"><a class="tab" data-id-tab="1">Logo process</a></li><?php
                    }
                    if ($term->field_image_option) {?>
                        <li <?= (!$term->field_logo_process_block ? 'class="active"' : '') ?>><a class="border-right tab" data-id-tab="2">Options</a></li><?php
                    } 
                    if ($term->field_complicated['und'][0]['value']) { ?>
                        <li <?= (!$term->field_image_option && !$term->field_logo_process_block ? 'class="active"' : '') ?>><a class="border-right tab" data-id-tab="3">Layout maker</a></li><?php
                    } 
                    if ($term->field_group_document && $term->field_complicated['und'][0]['value']) { ?>
                        <li><a class="tab" data-id-tab="4">Document center</a></li><?php
                    } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="tab-block tab-block-1 block-logo border border-top-0 <?= ($term->field_logo_process_block ? "block-active" : '') ?>"><?php
            if ($term->field_logo_process_block) { 
                displayLogoProcess($term);
            } ?>
            <div class="clearfix"></div>
        </div><?php
        if ($term->field_image_option) { ?>
            <div class="tab-block tab-block-2 border border-top-0 padding-top-10 padding-bottom-10 <?= (!$term->field_logo_process_block ? "block-active" : '') ?>"><?php
                foreach ($term->field_image_option['und'] as $aImageOption) {
                    displayOption($aImageOption);
                } ?>
                <div class="clearfix"></div>
            </div><?php
        } ?>
        <div class="tab-block tab-block-3 border border-top-0 padding-20 <?= (!$term->field_logo_process_block && !$term->field_image_option ? "block-active" : '') ?>">
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
            <div class="tab-block tab-block-4 border border-top-0 padding-20 document-center padding-top-20"><?php
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
                                <div>
                                    <a href="<?= url('taxonomy/term/' . $oYouMightLikeEntity->tid) ?>">
                                        <div class="col-md-12">
                                            <div class="thumbnail margin-bottom-0">
                                                <img src="<?= file_create_url($sProductYouMightLikeUrl) ?>" title="" alt="" />
                                                <div class="subtitle-pic"><?= $oYouMightLikeEntity->field_product_name['und'][0]['value'] ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </div><?php
                            } ?>
                    </div>
                </div>
            </div>
        </div><?php
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
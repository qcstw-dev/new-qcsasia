<div class="product-page">
    <div class="col-sm-3 main-picture-block margin-top-20">
        <div class="thumbnail thumb margin-bottom-10 event-enlarge"><?php 
            foreach ($term->field_main_photo['und'] as $aFieldMainPhoto) { ?>
                <div><img src="<?= file_create_url($aFieldMainPhoto['uri']) ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" /></div><?php
            }
            if ($term->field_photo_function) { ?>
                <div><img src="<?= file_create_url($term->field_photo_function['und'][0]['uri']) ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" /></div><?php 
            } ?>
        </div>
        <div class="padding-left-30 padding-right-30">
            <div class="thumbnails"><?php 
                foreach ($term->field_main_photo['und'] as $aFieldMainPhoto) { ?>
                    <div><img src="<?= file_create_url($aFieldMainPhoto['uri']) ?>" title="" alt="" /></div><?php
                }
                if ($term->field_photo_function) { ?>
                    <div><img src="<?= file_create_url($term->field_photo_function['und'][0]['uri']) ?>" title="<?= $term->field_product_name['und'][0]['value'] ?>" alt="<?= $term->field_product_name['und'][0]['value'] ?>" /></div><?php 
                }
                if ($term->field_youtube_video) { ?>
                    <div><span class="glyphicon glyphicon-play-circle font-size-65 play-video" ></span></div><?php
                } ?>
            </div>
        </div>
        <div class="enlarge event-enlarge"><span class="glyphicon glyphicon-zoom-in"></span></div>
    </div>
    <div class="col-sm-9">
        <h2><?= $term->field_product_name['und'][0]['value']." ".$term->field_product_ref['und'][0]['value'] ?></h2>
        <div class="panel panel-default">
            <!-- Table -->
            <table class="table table-product">
                <tbody class="border-none">
                    <tr>
                        <td class="border-right cell-key">Description</td>
                        <td colspan="5"><?= $term->field_description['und'][0]['value'] ?></td>
                    </tr><?php
//                    if ($term->field_technical_info) { ?>
                        <tr>
                            <td class="border-right cell-key">Technical info</td>
                            <td colspan="5"><?= $term->field_technical_info['und'][0]['value'] ?></td>
                        </tr><?php
//                    }
//                    if ($term->field_attachement) { ?>
                        <tr>
                            <td class="border-right cell-key">Attachement</td>
                            <td colspan="5"><?= $term->field_attachement['und'][0]['value'] ?></td>
                        </tr><?php
//                    } ?>
                    <tr>
                        <td class="border-right cell-key">Packaging</td>
                        <td colspan="5"><?= $term->field_packaging['und'][0]['value'] ?></td>
                    </tr>
                    <tr>
                        <td class="border-right cell-key">Logo size</td>
                        <td><?= $term->field_logo_size['und'][0]['value'] ?></td>
                        <td class="border-left border-right cell-key">Item size</td>
                        <td><?= $term->field_item_size['und'][0]['value'] ?></td><?php
                        if ($term->field_patent) { ?>
                            <td class="border-left border-right cell-key">Patent</td>
                            <td colspan="5"><?= $term->field_patent['und'][0]['value'] ?></td><?php
                        } ?>
                    </tr><?php
                    if ($term->field_colors) { ?>
                        <tr>
                            <td class="border-right cell-key">Colors available</td>
                            <td colspan="5"><?php
                            if ($term->field_colors) {
                                foreach ($term->field_colors['und'] as $value) {
                                    $sImageColor = taxonomy_term_load($value['tid'])->name.'.png'; ?>
                                    <img class="pull-left margin-right-md-10" src="<?= url(path_to_theme() . "/images/colors/$sImageColor") ?>" alt="" title="" /><?php
                                }
                            }
                            if ($term->field_display_image_finishes['und'][0]['value']) { ?>
                                    <img src="<?= url(path_to_theme() . "/images/colors/finishes.jpg") ?>" alt="" title="" /><?php
                            } ?>
                            </td>
                        </tr><?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 block-tabs">
        <nav class="navbar navbar-default margin-bottom-0">
            <div class=" navbar-collapse padding-0 tabs" id="navbar-collapse-menu-tab">
                <ul class="nav navbar-nav text-center">
                    <li class="border-right active"><a class="tab" data-id-tab="1">Logo process</a></li><?php
                        if ($term->field_image_option) {?>
                            <li><a class="border-right tab" data-id-tab="2">Options</a></li><?php
                        } ?>
                    <li><a class="border-right tab" data-id-tab="3">Layout maker</a></li><?php
                        if ($term->field_group_document) { ?>
                            <li><a class="tab" data-id-tab="4">Document center</a></li><?php
                        } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="tab-block tab-block-1 block-logo border border-top-0 block-active"><?php
            if ($term->field_logo_process) { ?>
                <div class="col-md-12"><?php
                    displayLogoProcess($term->field_logo_process['und'][0]['tid'], $term, 0); ?>
                </div><?php
                if (isset($term->field_logo_process['und'][1])) { ?>
                    <div class="col-md-12 hidden-text-area"><?php
                        $iPosition = 1;
                        foreach (array_slice($term->field_logo_process['und'], 1) as $aLogoProcess) { ?>
                        <div class="col-md-12 padding-0"><?php
                            displayLogoProcess($aLogoProcess['tid'], $term, $iPosition);
                            $iPosition++; ?>
                        </div><?php
                        } ?>
                    </div>
            <div class="clearfix"></div>
                    <div class="col-md-12 padding-0">
                        <div class="btn-show-hide-text-area"><span class="glyphicon glyphicon-menu-down"></span> More logo processes <span class="glyphicon glyphicon-menu-down"></span></div>
                    </div>
                    <div class="clearfix"></div><?php
                }
            } ?>
            <div class="clearfix"></div>
        </div><?php
        if ($term->field_image_option) { ?>
            <div class="tab-block tab-block-2 border border-top-0 padding-top-10 padding-bottom-10"><?php
                foreach ($term->field_image_option['und'] as $aImageOption) {
                    displayOption($aImageOption);
                } ?>
                <div class="clearfix"></div>
            </div><?php
        } ?>
        <div class="tab-block tab-block-3 border border-top-0 padding-20">
            <div class="col-md-6 thumbnail margin-bottom-0">
                <a href="#"><img src="<?= url(path_to_theme() . "/images/template/layout-maker.jpg") ?>" alt="" title="" /></a>
            </div>
            <div class="col-md-6">
                <p class="text-justify margin-bottom-0">
                    Aenean ultricies scelerisque ipsum, eget aliquam lorem pharetra 
                    ac. Proin porttitor metus non diam euismod, nec dapibus nisi 
                    elementum. Integer congue augue augue, eu rutrum est gravida ut.
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                    posuere cubilia.<br /><br />
                    Aenean ultricies scelerisque ipsum, eget aliquam lorem pharetra 
                    ac. Proin porttitor metus non diam euismod, nec dapibus nisi 
                    elementum. Integer congue augue augue, eu rutrum est gravida ut.
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                    posuere cubilia.Integer congue augue augue, eu rutrum est gravida ut.
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                    posuere cubilia.</p>
                <p class="text-right bold"><a href="#" ><span class="glyphicon glyphicon-edit"></span> Customise your product</a></p>
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
                <div class="padding-left-50 padding-right-50">
                    <div class="big-slick ymal-pics"><?php
                            foreach ($term->field_you_might_like['und'] as $aYouMightLike) { 
                                $oYouMightLikeEntity = taxonomy_term_load($aYouMightLike['tid']); ?>
                                <div>
                                    <a href="<?= url('taxonomy/term/' . $oYouMightLikeEntity->tid) ?>">
                                        <img src="<?= file_create_url($oYouMightLikeEntity->field_main_photo['und'][0]['uri']) ?>" title="" alt="" />
                                        <div class="subtitle-pic"><?= $oYouMightLikeEntity->field_product_name['und'][0]['value'] ?></div>
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
            $.magnificPopup.open({
                items: [{
                        src: $('<div class="white-popup">' +
                                '<div><img src="' + $('.thumb .slick-current img').attr('src') + '" /></div>' +
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
        slidesToShow: 5,
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
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="col-md-12">
        <div id="carousel-home" class="carousel carousel-home slide" data-ride="carousel-home">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <a href="<?= url('taxonomy/term/490') ?>" title="Large round aluminium keychain 31mm doming #PKA201">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/pka201.jpg") ?>" alt="Large round aluminium keychain 31mm doming #PKA201" title="Large round aluminium keychain 31mm doming #PKA201" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/488') ?>" title="Round aluminium keychain with 26mm doming #PKA202">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/pka202.jpg") ?>" alt="Round aluminium keychain with 26mm doming #PKA202" title="Round aluminium keychain with 26mm doming #PKA202" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/491') ?>" title="Pocket plastic ashtray/pillbox keychain #QAT3">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/qat3.jpg") ?>" alt="Pocket plastic ashtray/pillbox keychain #QAT3" title="Pocket plastic ashtray/pillbox keychain #QAT3" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/492') ?>" title="Zamac base with double doming keychain #AL">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/al.jpg") ?>" alt="Zamac base with double doming keychain #AL" title="Zamac base with double doming keychain #AL" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/494') ?>" title="Zamac top with webbing strap and doming keychain #ZST">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/zst.jpg") ?>" alt="Zamac top with webbing strap and doming keychain #ZST" title="Zamac top with webbing strap and doming keychain #ZST" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/496') ?>" title="Round zamac rubber loop keychain #ZSS205">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/zss205.jpg") ?>" alt="Round zamac rubber loop keychain #ZSS205" title="Round zamac rubber loop keychain #ZSS205" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/497') ?>" title="Silicon keychain with aluminium patch #SKC105">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/skc.jpg") ?>" alt="Silicon keychain with aluminium patch #SKC105" title="Silicon keychain with aluminium patch #SKC105" />
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/509') ?>" title="Plastic loop keychain #PSS205">
                        <img src="<?= url(path_to_theme() . "/images/theme/slideshow/pss205.jpg") ?>" alt="Plastic loop keychain #PSS205" title="Plastic loop keychain #PSS205" />
                    </a>
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="btn-show-hide-text-area margin-bottom-10"><span class="glyphicon glyphicon-menu-down"></span> Browse by product <span class="glyphicon glyphicon-menu-down"></span></div>
    <div class="col-sm-3 padding-0 border-right-bold hidden-text-area">
        <div class="col-md-12">
            <h3>Browse by product</h3>
        </div>
        <div class="col-xs-12">
            <div class="btn btn-default untick-all width-100-percent"><span class="glyphicon glyphicon-remove color-red"></span> Untick all boxes</div>
        </div><?php
        $count = 0;
            foreach ($aGifts as $key => $oGift) { 
                $bChecked = (isset(drupal_get_query_parameters()['gift']) && in_array($oGift->tid, (is_array(drupal_get_query_parameters()['gift']) ? array_values(drupal_get_query_parameters()['gift']) : [drupal_get_query_parameters()['gift']])) ? 'checked' : '' ) ;
                if ($count == 0) { ?>
                    <div class="col-xs-12 padding-0"><?php
                } ?>   
                <div class="block-gift col-xs-4 margin-right-xs-5 padding-0 margin-top-10 <?= ( $bChecked ? 'block-gift-selected' : '') ?>">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn checkbox-container">
                            <input class="filter" data-id="<?= $oGift->tid ?>" type="checkbox" autocomplete="off" <?= $bChecked ?> ><span class="glyphicon glyphicon-<?= ($bChecked ? 'check' : 'unchecked') ?>"></span>
                        </label>
                    </div>
                    <div class="thumbnail border-none margin-bottom-0">
                        <img class="" src="<?= (isset($oGift->field_thumbnail['und'][0]['uri']) ? image_style_url('thumbnail', $oGift->field_thumbnail['und'][0]['uri']) : url(path_to_theme() . "/images/POP8S-BLK-BMW5.jpg") ) ?>" alt="<?= (isset($oGift->field_thumbnail['und'][0]['alt']) ? $oGift->field_thumbnail['und'][0]['alt'] : $oGift->field_product_name['und'][0]['value']) ?>" title="<?= (isset($oGift->field_thumbnail['und'][0]['title']) ?$oGift->field_thumbnail['und'][0]['title']:$oGift->field_product_name['und'][0]['value']) ?>" />
                    </div>
                    <div class = "ref-product"><?= $oGift->field_product_ref['und'][0]['value'] ?></div>
                </div><?php
                $count++;
                if ($count % 3 == 0) { ?>
                    </div>
                    <div class="col-xs-12 padding-0"><?php
                }
                if ($count == count($aGifts)) { ?>
                    </div><?php
                }
            } ?>   
        <div class="clearfix"></div>
        <div class="btn-show-hide-text-area margin-bottom-10"><span class="glyphicon glyphicon-menu-down"></span> Browse by product <span class="glyphicon glyphicon-menu-down"></span></div>
    </div>
    
    <div class="col-sm-9 padding-0">
        <div class="col-md-12">
            <h3>Browse by theme</h3>
        </div>
        <div class="themes_list">
            <?php include 'html--themes_ajax.tpl.php'; ?>
        </div>
    </div>
</div>
<script>
    $('.block-gift').on('click', function (){
        event.stopPropagation();
        checkUncheckGift($(this).find('.checkbox-container'));
        updateSearchThemesResults();
    });
    $('.untick-all').on('click', function (){
        $('.block-gift').each(function() {
           if ($(this).find('input').is(':checked')) {
//               $(this).trigger('click');
                checkUncheckGift($(this).find('.checkbox-container'));
                $(this).find('input').attr('checked', false);
           }
        });
        updateSearchThemesResults();
    });
    function updateSearchThemesResults () {
        var aFilterGift = [];
        var bIssetGetVars = false;
        $('.filter').each(function () {
            if ($(this).is(':checked')) {
                aFilterGift.push($(this).data('id'));
            }
        });
        var url = baseUrl + '/themes_ajax/';
        var query = '';
        $.each(aFilterGift, function (index, value) {
            query = query + (bIssetGetVars ? '&' : '?')+ 'gift[]=' + value;
            bIssetGetVars = true;
        });
        
        console.log(url + query);
        $.ajax(url + query, {
            dataType: 'html',
            beforeSend: function () {
                if($(window).width() >= 667) {
                    $('html,body').animate({scrollTop: $('.themes_list').offset().top}, 200);
                }
                $('.themes_list').html('<div class="col-sm-12 text-center margin-top-70"><img src="<?= url(path_to_theme() . "/images/template/loader.gif") ?>" /></div>');
            },
            success: function (data) {
                $('.themes_list').html(data);
                var newUrl = baseUrl + (window.location.host !== 'localhost' ? window.location.pathname.split('/')['1'] : '/' + window.location.pathname.split('/')['2']) + '/' + query;
                window.history.pushState({path: newUrl}, '', newUrl);
            }
        });
    }
    function checkUncheckGift(element) {
        if (element.find('input').is(':checked')) {
            element.parent().parent().removeClass('block-gift-selected');
            element.find('input').attr('checked', false);
            element.find('.glyphicon').removeClass('glyphicon-check');
            element.find('.glyphicon').addClass('glyphicon-unchecked');
        } else {
            element.parent().parent().addClass('block-gift-selected');
            element.find('input').attr('checked', true);
            element.find('.glyphicon').removeClass('glyphicon-unchecked');
            element.find('.glyphicon').addClass('glyphicon-check');
        }
    }
    </script>
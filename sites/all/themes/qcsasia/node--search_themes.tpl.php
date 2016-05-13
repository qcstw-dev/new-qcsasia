<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2><?= $node->title ?></h2>
    <div class="btn-show-hide-text-area margin-bottom-10"><span class="glyphicon glyphicon-menu-down"></span> Browse by product <span class="glyphicon glyphicon-menu-down"></span></div>
    <div class="col-sm-3 padding-0 border-right-bold hidden-text-area">
        <div class="col-md-12">
            <h3>Browse by product</h3>
        </div><?php
        $count = 0;
            foreach ($aGifts as $key => $oGift) { 
                $bChecked = (isset(drupal_get_query_parameters()['gift']) && in_array($oGift->tid, (is_array(drupal_get_query_parameters()['gift']) ? array_values(drupal_get_query_parameters()['gift']) : [drupal_get_query_parameters()['gift']])) ? 'checked' : '' ) ;?>
                <div class="block-gift col-xs-4 padding-0">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn checkbox-container">
                            <input class="filter" data-id="<?= $oGift->tid ?>" type="checkbox" autocomplete="off" <?= $bChecked ?> ><span class="glyphicon glyphicon-<?= ($bChecked ? 'check' : 'unchecked') ?>"></span>
                        </label>
                    </div>
                    <div class="thumbnail border-none margin-bottom-0">
                        <img class="" src="<?= (isset($oGift->field_thumbnail['und'][0]['uri']) ? image_style_url('thumbnail', $oGift->field_thumbnail['und'][0]['uri']) : url(path_to_theme() . "/images/POP8S-BLK-BMW5.jpg") ) ?>" alt="<?= (isset($oGift->field_thumbnail['und'][0]['alt']) ?: $oGift->field_product_name['und'][0]['value']) ?>" title="<?= (isset($oGift->field_thumbnail['und'][0]['title']) ?:$oGift->field_product_name['und'][0]['value']) ?>" />
                    </div>
                    <div class = "ref-product"><?= $oGift->field_product_ref['und'][0]['value'] ?></div>
                </div><?php
                $count++;
                if ($count % 3 == 0) { ?>
                    <div class="clearfix"></div><?php
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
        checkUncheck($(this).find('.checkbox-container'));
        updateSearchResults();
    });
    function updateSearchResults () {
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
            console.log(query);
            bIssetGetVars = true;
        });
        
        console.log(url + query);
        $.ajax(url + query, {
            dataType: 'html',
            beforeSend: function () {
                if($(window).width() >= 667) {
                    $('html,body').animate({scrollTop: $('#menu-top').offset().top}, 200);
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
    
    function checkUncheck(element) {
        if (element.find('input').is(':checked')) {
            element.find('input').attr('checked', false);
            element.find('.glyphicon').removeClass('glyphicon-check');
            element.find('.glyphicon').addClass('glyphicon-unchecked');
        } else {
            element.find('input').attr('checked', true);
            element.find('.glyphicon').removeClass('glyphicon-unchecked');
            element.find('.glyphicon').addClass('glyphicon-check');
        }
    }
    </script>
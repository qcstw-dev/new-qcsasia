<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="block-filter col-md-3 thumbnail padding">
        <h4>Filter by:</h4>
        <div class="block-filter-group visible">
            <div><label><input type="checkbox" class="filter new" value="new" <?= (isset($_GET['new']) ? 'checked' : '') ?>/>New Product <span class="count"><?= (!isset($_GET['new']) ? '(' . $aFilterNumProducts['new'] . ')' : '') ?></span></label></div>
            <div><label><input type="checkbox" class="filter patented" value="patented" <?= (isset($_GET['patented']) ? 'checked' : '') ?>/>Patented Product <span class="count"><?= (!isset($_GET['patented']) ? '(' . $aFilterNumProducts['patented'] . ')' : '') ?></span></label></div>
            <div><label><input type="checkbox" class="filter cheap" value="cheap" <?= (isset($_GET['cheap']) ? 'checked' : '') ?>/>Very cheap product <span class="count"><?= (!isset($_GET['cheap']) ? '(' . $aFilterNumProducts['cheap'] . ')' : '') ?></span></label></div>
            <div><label><input type="checkbox" class="filter rush" value="rush" <?= (isset($_GET['rush']) ? 'checked' : '') ?>/>Rush service product <span class="count"><?= (!isset($_GET['rush']) ? '(' . $aFilterNumProducts['rush'] . ')' : '') ?></span></label></div>
        </div>
        <div class="filter-group-title" data-group-title="material"><span class="glyphicon glyphicon-chevron-down"></span> Material</div>
        <div class="block-filter-group group-material"><?php
            if (isset($_GET['category']) && !is_array($_GET['category'])) {
                $_GET['category'] = [$_GET['category']];
            }
            foreach (retrieveFilters('category') as $oTerm) {
                $sRef = $oTerm->field_reference['und'][0]['value'];
                $bChecked = isset($_GET['category']) && in_array($sRef, $_GET['category']);
                ?>
                <div>
                    <label>
                        <input type="checkbox" class="filter multiple category <?= $sRef ?>" value="<?= $sRef ?>" <?= ($bChecked ? 'checked' : '') ?>/>
                        <?= $oTerm->name ?> <span class="count"><?= (!$bChecked ? '(' . $aFilterNumProducts['category'][$sRef] . ')' : '') ?></span>
                    </label>
                </div><?php }
                    ?>
        </div>
        <div class="filter-group-title" data-group-title="function"><span class="glyphicon glyphicon-chevron-down"></span> Function</div>
        <div class="block-filter-group group-function"><?php
            if (isset($_GET['function']) && !is_array($_GET['function'])) {
                $_GET['function'] = [$_GET['function']];
            }
            foreach (retrieveFilters('function') as $oTerm) {
                $sRef = $oTerm->field_reference['und'][0]['value'];
                $bChecked = isset($_GET['function']) && in_array($sRef, $_GET['function']);
                ?>
                <div>
                    <label>
                        <input type="checkbox" class="filter multiple function <?= $sRef ?>" value="<?= $sRef ?>" <?= ($bChecked ? 'checked' : '') ?>/>
                        <?= $oTerm->name ?> <span class="count"><?= (!$bChecked ? '(' . $aFilterNumProducts['function'][$sRef] . ')' : '') ?></span>
                    </label>
                </div><?php }
                    ?>
        </div>
        <div class="filter-group-title" data-group-title="logo_process"><span class="glyphicon glyphicon-chevron-down"></span> Logo process</div>
        <div class="block-filter-group group-function"><?php
            if (isset($_GET['logo-process']) && !is_array($_GET['logo-process'])) {
                $_GET['logo-process'] = [$_GET['logo-process']];
            }
            foreach (retrieveFilters('logo_process') as $oTerm) {
                $sRef = $oTerm->field_reference['und'][0]['value'];
                $bChecked = isset($_GET['logo-process']) && in_array($sRef, $_GET['logo-process']);
                ?>
                <div>
                    <label>
                        <input type="checkbox" class="filter multiple logo-process <?= $sRef ?>" value="<?= $sRef ?>" <?= ($bChecked ? 'checked' : '') ?>/>
                        <?= $oTerm->name ?> <span class="count"><?= (!$bChecked ? '(' . $aFilterNumProducts['logo-process'][$sRef] . ')' : '') ?></span>
                    </label>
                </div><?php }
                    ?>
        </div>
    </div>
    <div class="col-md-9 padding-0 block-list-products">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div><!-- /input-group -->
        </div>
        <div class="col-md-12 products_list"><?php include 'html--products_ajax.tpl.php'; ?>
        </div>
    </div>
</div>
<script>
    $('.filter').on('click', function () {
        var aFilterValues = [];
        var aFilterCat = [];
        var aFilterFunction = [];
        var aFilterLogo = [];
        var bIssetGetVars = false;
        $('.filter').each(function () {
            if ($(this).is(':checked')) {
                if ($(this).hasClass('multiple')) {
                    if ($(this).hasClass('category')) {
                        aFilterCat.push($(this).val());
                    } else if ($(this).hasClass('function')) {
                        aFilterFunction.push($(this).val());
                    } else if ($(this).hasClass('logo-process')) {
                        aFilterLogo.push($(this).val());
                    }
                } else {
                    aFilterValues.push($(this).val());
                }
            }
        });

        var url = baseUrl + '/products_ajax/';
        var query = '';
        $.each(aFilterValues, function (index, value) {
            query = query + (bIssetGetVars ? '&' : '?') + value;
            bIssetGetVars = true;
        });
        $.each(aFilterCat, function (index, value) {
            query = query + (bIssetGetVars ? '&' : '?') + 'category[]=' + value;
            bIssetGetVars = true;
        });
        $.each(aFilterFunction, function (index, value) {
            query = query + (bIssetGetVars ? '&' : '?') + 'function[]=' + value;
            bIssetGetVars = true;
        });
        $.each(aFilterLogo, function (index, value) {
            query = query + (bIssetGetVars ? '&' : '?') + 'logo-process[]=' + value;
            bIssetGetVars = true;
        });
        console.log(url + query);

        $.ajax(url + query, {
            dataType: 'html',
            beforeSend: function () {
                $('html,body').animate({scrollTop: $('#menu-top').offset().top}, 200);
                $('.products_list').html('<div class="col-md-12 text-center margin-top-70"><img src="<?= url(path_to_theme() . "/images/template/loader.gif") ?>" /></div>');
            },
            success: function (data) {
                $('.products_list').html(data);
                var newUrl = baseUrl + '/' + window.location.pathname.split('/')[2] + '/' + query;
                window.history.pushState({path: newUrl}, '', newUrl);
            }
        });

        $(this).parent().find('.count').html('');
        console.log(baseUrl + '/products_number_ajax/' + query);
        $.ajax(baseUrl + '/products_number_ajax/' + query, {
            dataType: 'json',
            success: function (data) {
                $.each(data, function (index, filter) {
                    if ($.type(filter) !== 'string') {
                        $.each(filter, function (i, value) {
                            $('.' + i).parent().find('.count').html(($('.' + i).is(':checked') ? '' : '(' + value + ')'));
                        });
                    } else {
                        $('.' + index).parent().find('.count').html(($('.' + index).is(':checked') ? '' : '(' + filter + ')'));
                    }
                });
            }
        });
    });
</script>
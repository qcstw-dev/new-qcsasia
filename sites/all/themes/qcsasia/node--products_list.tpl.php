<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="block-filter col-md-3 thumbnail padding">
        <h4>Filter by:</h4>
        <div class="block-filter-group visible">
            <div><label><input type="checkbox" class="filter" value="new" <?= (isset($_GET['new']) ? 'checked' : '') ?>/>New Product (50)</label></div>
            <div><label><input type="checkbox" class="filter" value="patented" <?= (isset($_GET['patented']) ? 'checked' : '') ?>/>Patented Product (15)</label></div>
            <div><label><input type="checkbox" class="filter" value="cheap" <?= (isset($_GET['cheap']) ? 'checked' : '') ?>/>Very cheap product (69)</label></div>
            <div><label><input type="checkbox" class="filter" value="rush" <?= (isset($_GET['rush']) ? 'checked' : '') ?>/>Rush service product (32)</label></div>
        </div>
        <div class="filter-group-title" data-group-title="material"><span class="glyphicon glyphicon-chevron-down"></span> Material</div>
        <div class="block-filter-group group-material"><?php
        if (!is_array($_GET['category'])) { $_GET['category'] = [$_GET['category']]; }
        foreach (retrieveFilters('category') as $oCategory) { ?>
            <div>
                <label>
                    <input type="checkbox" class="filter multiple" data-filter-type="category" name="filter" value="<?= $oCategory->field_reference['und'][0]['value'] ?>" <?= (isset($_GET['category']) && in_array($oCategory->field_reference['und'][0]['value'], $_GET['category']) ? 'checked' : '') ?>/>
                    <?= $oCategory->name ?> (24)
                </label>
            </div><?php
        } ?>
        </div>
        <div class="filter-group-title" data-group-title="function"><span class="glyphicon glyphicon-chevron-down"></span> Function</div>
        <div class="block-filter-group group-function"><?php
        if (!is_array($_GET['function'])) { $_GET['function'] = [$_GET['function']]; }
        foreach (retrieveFilters('function') as $oFunction) { ?>
            <div>
                <label>
                    <input type="checkbox" class="filter multiple" data-filter-type="function" name="filter" value="<?= $oFunction->field_reference['und'][0]['value'] ?>" <?= (isset($_GET['function']) && in_array($oFunction->field_reference['und'][0]['value'], $_GET['function']) ? 'checked' : '') ?>/>
                    <?= $oFunction->name ?> (24)
                </label>
            </div><?php
        } ?>
        </div>
        <div class="filter-group-title" data-group-title="logo_process"><span class="glyphicon glyphicon-chevron-down"></span> Logo process</div>
        <div class="block-filter-group group-function"><?php
        if (!is_array($_GET['logo-process'])) { $_GET['logo-process'] = [$_GET['logo-process']]; }
        foreach (retrieveFilters('logo_process') as $oLogoProcess) { ?>
            <div>
                <label>
                    <input type="checkbox" class="filter multiple" data-filter-type="logo-process" name="filter" value="<?= $oLogoProcess->field_reference['und'][0]['value'] ?>" <?= (isset($_GET['logo-process']) && in_array($oLogoProcess->field_reference['und'][0]['value'], $_GET['logo-process']) ? 'checked' : '') ?>/>
                    <?= $oLogoProcess->name ?> (24)
                </label>
            </div><?php
        } ?>
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
        <div class="col-md-12 products_list"><?php
            include 'html--products_ajax.tpl.php'; ?>
        </div>
    </div>
</div>
<script>
    $('.filter').on('click', function () {
        var aFilterValues = [];
        var aFilterMultipleValues = {};
        var aFilterCat = [];
        var aFilterFunction = [];
        var aFilterLogo = [];
        var bIssetGetVars = false;
        $('.filter').each(function() {
            if($(this).is(':checked')) {
                if ($(this).hasClass('multiple')) {
                    if ($(this).data('filter-type') === 'category') {
                        aFilterCat.push($(this).val());
                    } else if ($(this).data('filter-type') === 'function') {
                        aFilterFunction.push($(this).val());
                    } else if ($(this).data('filter-type') === 'logo-process') {
                        aFilterLogo.push($(this).val());
                    }
                } else {
                    aFilterValues.push($(this).val());
                }
            }
        });
        
        var url = baseUrl+'/products_ajax/';
        $.each(aFilterValues, function(index, value){
            url = url+(bIssetGetVars ? '&' : '?')+value;
            bIssetGetVars = true;
        });
        
        $.each(aFilterCat, function (index, value) {
                url = url+(bIssetGetVars ? '&' : '?')+'category[]='+value;
                bIssetGetVars = true;
        });
        $.each(aFilterFunction, function (index, value) {
                url = url+(bIssetGetVars ? '&' : '?')+'function[]='+value;
                bIssetGetVars = true;
        });
        $.each(aFilterLogo, function (index, value) {
                url = url+(bIssetGetVars ? '&' : '?')+'logo-process[]='+value;
                bIssetGetVars = true;
        });
        
        console.log(url);
        $.ajax(url , {
            dataType: 'html',
            beforeSend: function () {
                $('html,body').animate({scrollTop: $('#menu-top').offset().top}, 200);
                $('.products_list').html('<div class="col-md-12 text-center margin-top-70"><img src="<?= url(path_to_theme() . "/images/template/loader.gif") ?>" /></div>');
            },
            success: function (data) {
                $('.products_list').html(data);
            }
        });
    });
</script>
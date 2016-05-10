<?php
if ($aThemes) {
    foreach ($aThemes as $oTheme) {
        displayThemeBlock($oTheme);
    }
} else { ?>
    <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no products matching with your criteria</div><?php
}

function displayThemeBlock($oTheme) {
    $sName = $oTheme->field_theme_title['und'][0]['value']; ?>
    <div class = "block-product col-xs-6 col-sm-4">
        <div class = "thumbnail thumbnail-hover">
            <a href = "<?= url('taxonomy/term/' . $oTheme->tid) ?>" title = ""><?php
                $sLogoProcessUri = (isset($oTheme->field_theme_thumbnail['und'][0]['uri']) ? $oTheme->field_theme_thumbnail['und'][0]['uri'] : ''); ?>
                <img src = "<?= ($sLogoProcessUri ? file_create_url($sLogoProcessUri) : url(path_to_theme()."/images/POP8S-BLK-BMW5.jpg")) ?>" alt = "<?= $sName ?>" title = "<?= $sName ?>" />
                <div class = "subtitle-pic"><?= $sName ?></div>
            </a>
        </div>
    </div><?php
}
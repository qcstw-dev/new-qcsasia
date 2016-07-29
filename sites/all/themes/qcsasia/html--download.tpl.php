<?php
$sPictureName = (isset(drupal_get_query_parameters()['layout']) && drupal_get_query_parameters()['layout'] ? drupal_get_query_parameters()['layout'] : '');
global $base_url;
$sPictureUrl = 'sites/default/files/products/layout-maker/uploads/'.$sPictureName;
if ($sPictureName) {
    $sPictureSize = filesize($sPictureUrl);
    header("Content-disposition: attachment; filename=$sPictureName");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: application/octet-stream");
    header("Content-Length: $sPictureSize");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
    header("Expires: 0");
    header('Content-Transfer-Encoding: binary');
    readfile($sPictureUrl);
    exit;
//    header('location: '.$base_url); 
//    header('location: '.($_SERVER[HTTP_HOST] == 'localhost' ? 'http' : 'https').'://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]); ?>
    <div class="col-xs-12">
        <a class="link" href="<?= $base_url ?>" title="Go to homepage"><span class="glyphicon glyphicon-arrow-left"></span> Go to homepage</a>
    </div>
    <div class="col-xs-12 ">
        <a href="<?= $sPictureUrl ?>">
            <img class="text-center thumbnail" src="<?= $sPictureUrl ?>" title="<?= $sPictureName ?>" alt="<?= $sPictureName ?>" />
        </a>
    </div><?php
} else { ?>
    <div class="alert alert-warning text-center">
        <span class="glyphicon glyphicon-warning-sign font-size-20"></span><strong> No picture Found</strong>
    </div><?php
}
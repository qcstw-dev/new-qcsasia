<?php
if (isset($_POST['layout_url'], $_POST['layout_name']) && $_POST['layout_url'] && $_POST['layout_name']) {
    global $base_url;

    $sImgPath = $_POST['layout_url'];
    $sImgPath = str_replace('data:image/png;base64,', '', $sImgPath);
    $sImgPath = str_replace(' ', '+', $sImgPath);
    $sData = base64_decode($sImgPath);
    $sFileName = $_POST['layout_name'].'-'.time().'.png';
    $sImgFinalPath = 'sites/default/files/products/layout-maker/uploads/'.$sFileName;
    $result = file_put_contents($sImgFinalPath, $sData);
    echo $sFileName;
}
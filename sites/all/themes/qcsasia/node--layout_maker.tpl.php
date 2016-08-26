<?php
// retrieve products
$aOptions = ['layout_maker' => true, 'get_object' => true];
//$aAllProducts = getProducts(drupal_get_query_parameters(), $aOptions); 
$aProducts = [];
if (isset(drupal_get_query_parameters()['category'])) {
    $aProducts = getProducts(drupal_get_query_parameters(), $aOptions); 
} else {
    $aProducts = [];
    $aParameters = drupal_get_query_parameters();
    if (isset(drupal_get_query_parameters()['write-info']) && !drupal_get_query_parameters()['write-info']) {
        $aProducts = [
            '331', '820', '819', '818', '323', '324', '326', '327', '328', 
            '331', '333', '334', '336', '337', '341', '343', '344', '345', 
            '346', '347', '348', '349', '350', '351', '353', '354', '355',
            '358', '359', '360', '362', '363', '365', '366', '368', '369',
            '370', '372', '373', '374', '394', '396', '397', '398', '406',
            '416'];
        $aParameters['product'] = $aProducts;
    } 
    
    foreach (['plastic-injection', 'metal-enamel', 'aluminium'] as $sCategory) {
        $aProducts[$sCategory] = getProducts(array_merge($aParameters, ['category' => [$sCategory]]), $aOptions);
    }
    
}
include("layout.tpl.php");
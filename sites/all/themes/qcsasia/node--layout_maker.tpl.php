<?php
// retrieve products
$aOptions = ['layout_maker' => true, 'get_object' => true];
//$aAllProducts = getProducts(drupal_get_query_parameters(), $aOptions); 
$aProducts = [];
if (isset(drupal_get_query_parameters()['category'])) {
    $aProducts = getProducts(drupal_get_query_parameters(), $aOptions); 
} else {
    foreach (['plastic-injection', 'metal-enamel', 'aluminium'] as $sCategory) {
        $aProducts[$sCategory] = getProducts(array_merge(drupal_get_query_parameters(), ['category' => [$sCategory]]), $aOptions);
    }
}
include("layout.tpl.php");
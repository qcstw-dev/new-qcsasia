<h2>Search</h2><?php
// Retrieve all the product
$aProducts = [];
$aProductVocabulary = taxonomy_vocabulary_machine_name_load('product');
$aAllProducts = taxonomy_get_tree($aProductVocabulary->vid, 0, NULL, TRUE);
if (drupal_get_query_parameters()) {
    foreach ($aAllProducts as $aAllProductsKey => $oProduct) {
        foreach (drupal_get_query_parameters() as $sKey => $sValue) {
            switch ($sKey) {
                case 'new': 
                    if (!$oProduct->field_new_product['und'][0]['value']) { unset($aAllProducts[$aAllProductsKey]); }
                break;
                case 'cheap': 
                    if (!$oProduct->field_cheap_item['und'][0]['value']) { unset($aAllProducts[$aAllProductsKey]); }
                break;
                case 'patented': 
                    if (!$oProduct->field_patented_item['und'][0]['value']) { unset($aAllProducts[$aAllProductsKey]); }
                break;
                case 'category': 
                    $sProductCategoryTerm = taxonomy_term_load($oProduct->field_category['und'][0]['tid']);
                    if ($sProductCategoryTerm->field_reference['und'][0]['value'] != $sValue) { unset($aAllProducts[$aAllProductsKey]); }
                break;
            }
        }
    }
} else {
    $aProducts = $aAllProducts;
}
// Display Products
include 'products_list.tpl.php'; ?>
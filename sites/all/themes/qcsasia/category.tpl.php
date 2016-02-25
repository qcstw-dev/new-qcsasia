<h2>Category: <?= $term_name ?></h2><?php
// Retrieve all the product
$aProducts = [];
$aProductVocabulary = taxonomy_vocabulary_machine_name_load('product');
$aAllProducts = taxonomy_get_tree($aProductVocabulary->vid, 0, NULL, TRUE);

if ($term->tid) {
    foreach ($aAllProducts as $oProduct) {
        if ($oProduct->field_category['und'][0]['tid'] == $term->tid) {
            $aProducts[] = $oProduct;
        }
    }
} else {
    $aProducts = $aAllProducts;
}

// If a variable new is passed in GET variable then we filter
if (isset(drupal_get_query_parameters()['new'])) {
    $aTmpProducts = [];
    foreach ($aProducts as $aProduct) {
        if ($aProduct->field_new_product['und'][0]['value']) {
            $aTmpProducts[] = $aProduct;
        }
    }
    $aProducts = $aTmpProducts;
}
// Display Products
echo "<ul>";
foreach ($aProducts as $oProduct) {
    echo '<li><a href="'.url('taxonomy/term/'.$oProduct->tid).'" >' . $oProduct->name . '</li>';
}
echo "</ul>";
?>
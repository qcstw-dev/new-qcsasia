<h2>Search</h2><?php
// retrieve products
$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'product')
        ->range(0, 5);

if (drupal_get_query_parameters()) {
    foreach (drupal_get_query_parameters() as $sKey => $sValue) {
        switch ($sKey) {
            case 'new': 
                $oQuery->fieldCondition('field_new_product', 'value', '1');
            break;
            case 'cheap': 
                $oQuery->fieldCondition('field_cheap_item', 'value', '1');
            break;
            case 'patented': 
                $oQuery->fieldCondition('field_patented_item', 'value', '1');
            break;
            case 'category': 
                $oCategory = taxonomy_get_term_by_name($sValue);
                $oQuery->fieldCondition('field_category', 'tid', $oCategory->tid);
            break;
        }
    }
}

$aResult = $oQuery->execute();
$aProducts = taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));

// Display Products
include 'products_list.tpl.php'; ?>
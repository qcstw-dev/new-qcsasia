<h2>Category: <?= $term_name ?></h2><?php
// retrieve products
$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'product')
        ->fieldCondition('field_category', 'tid', $term->tid)
        ->range(0, 5);
$aResult = $oQuery->execute();

$aProducts = taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));

// Display Products
include 'products_list.tpl.php'; ?>
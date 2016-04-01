<?php
set_time_limit(0);

$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'category');
$aResult = $oQuery->execute();

foreach ($aResult['taxonomy_term'] as $result) {
    $oTerm = taxonomy_term_load($result->tid);
    preg_match('/(#[a-zA-Z0-9]+)/', $oTerm->name, $matches);

    if ($matches[0] != '') {
        $oTerm->field_category_reference['und'][0]['value'] = $matches[0];
        $oTerm->field_category_title['und'][0]['value'] = str_replace($matches[0], "", $oTerm->field_product_name['und'][0]['value']);
    } else {
        $oTerm->field_category_title['und'][0]['value'] = $oTerm->name;
    }
    taxonomy_term_save($oTerm);
}
?>


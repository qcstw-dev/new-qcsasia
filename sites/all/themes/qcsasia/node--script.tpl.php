<?php
set_time_limit(0);

$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'display');
$aResult = $oQuery->execute();

foreach ($aResult['taxonomy_term'] as $result) {
    $oTerm = taxonomy_term_load($result->tid);
    
//    $oTerm->field_reference['und'][0]['value'] = strtolower(str_replace(' ', '-', str_replace('#', '', $oTerm->name)));
//    $oTerm->field_display_title['und'][0]['value'] = $oTerm->name;
    
//    $oTerm->field_rush['und'][0]['value'] = $oTerm->field_program_item['und'][0]['value'];
//    
//    
    taxonomy_term_save($oTerm);
} ?>


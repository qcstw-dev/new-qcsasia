<?php

set_time_limit(0);

$oQuery = new EntityFieldQuery();

$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'member');

$result = $oQuery->execute();
$oTerms = taxonomy_term_load_multiple(array_keys($result['taxonomy_term']));

foreach ($oTerms as $oTerm) {
//    $oTerm->field_draft = ['und' => ['0' => ['value' => '0']]];
//    $oTerm->name = $oTerm->name.' '.$oTerm->field_member_email['und'][0]['value'];
//    var_dump($oTerm->name);
//        taxonomy_term_save($oTerm);
}
?>


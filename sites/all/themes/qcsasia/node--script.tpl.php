<?php

set_time_limit(0);

$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'product');
$aResult = $oQuery->execute();

foreach ($aResult['taxonomy_term'] as $result) {
    $oTerm = taxonomy_term_load($result->tid);

    
//    preg_match('~<strong>Description:</strong>([\s\S]*?)<strong>Attachement:</strong>~', $oTerm->field_description['und'][0]['value'], $matches);
    preg_match('~Description:~', $oTerm->field_description['und'][0]['value'], $matches);
    
    if ($matches) {
        var_dump($result->tid);
        
//        $oTerm->field_technical_info['und'][0]['value'] = $matches[1];
//        
//        var_dump($oTerm->field_technical_info['und'][0]['value']);
    }

    
    
//    preg_match('/src="(.*?)"/', $oTerm->field_youtube_video['und'][0]['value'], $matches);
//    if ($matches) {
//        var_dump($matches);
//        $oTerm->field_youtube_video['und'][0]['value'] = str_replace($matches[1], $matches[1].'?rel=0&amp;showinfo=0', $oTerm->field_youtube_video['und'][0]['value']);
//        var_dump($oTerm->field_youtube_video['und'][0]['value']);
//    ?rel=0&amp;showinfo=0
//        taxonomy_term_save($oTerm);
//    }
    
//    preg_match('/height="(.*?)"/', $oTerm->field_youtube_video['und'][0]['value'], $matches);
//    if ($matches) {
//        $oTerm->field_youtube_video['und'][0]['value'] = str_replace($matches[0], 'height="315"', $oTerm->field_youtube_video['und'][0]['value']);
//        var_dump($oTerm->field_youtube_video['und'][0]['value']);
//        taxonomy_term_save($oTerm);
//    }
    
    
//    preg_match('/<iframe[\s\S]*?<\/iframe>/', $oTerm->field_description['und'][0]['value'], $matches);
//    if ($matches) {
//        $oTerm->field_youtube_video['und'][0]['value'] = $matches[0];
//        
//        $oTerm->field_description['und'][0]['value'] = str_replace($oTerm->field_youtube_video['und'][0]['value'], '', $oTerm->field_description['und'][0]['value']);
//        if ($oTerm->field_youtube_video['und'][0]['value']) {
//            var_dump($oTerm->name);
//            var_dump($oTerm->field_youtube_video['und'][0]['value']);
//            var_dump($oTerm->field_description['und'][0]['value']);
//            exit;
//        }
//    }

//    $oTerm->field_description['und'][0]['value'] = strtolower(str_replace(' ', '-', str_replace('#', '', $oTerm->name)));
//    $oTerm->field_category_description['und'][0]['value'] = $oTerm->description;
//    $oTerm->field_rush['und'][0]['value'] = $oTerm->field_program_item['und'][0]['value'];
//    
//    
//    taxonomy_term_save($oTerm);
}
?>


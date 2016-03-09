<?php

$response_xml_data = file_get_contents("http://localhost/qcsasia/xml-products/");
$XMLposts = simplexml_load_string($response_xml_data)->posts->post or die("Error: Cannot create object");
$stermId = '';
foreach ($XMLposts as $XMLpost) {
    $stermId = (string) $XMLpost->id;
    if (taxonomy_term_load($stermId)->field_old_id['und'][0]['value'] == $stermId) {
        $oTerm = taxonomy_term_load($stermId);
    } 
    else {
        $oTerm = custom_create_taxonomy_term((string) $XMLpost->title, $stermId, '2');
    }
}

function custom_create_taxonomy_term($sName, $sId, $sVid) {
    $term = new stdClass();
    $term->name = $sName;
    $term->vid = $sVid;
    $term->field_old_id['und'][0]['value'] = $sId;
    $term->language = 'und';
    taxonomy_term_save($term);
    return $term;
}

//$term = new stdClass();
//$term->name = ‘Your New Term Name’;
//$term->vid = 'vocabulary id'; 
//$term->field_new[LANGUAGE_NONE][0]['value'] = ‘Value for this field’; 
//taxonomy_term_save($term);

//$url = "http://qcsasia.com/.........";
//$target = "/images/....";
//copy($url, $target);
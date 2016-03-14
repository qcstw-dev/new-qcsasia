<?php

$response_xml_data = file_get_contents("http://localhost/qcsasia/xml-products/");
$XMLposts = simplexml_load_string($response_xml_data)->posts->post or die("Error: Cannot create object");
$stermId = '';

// for each product in the xml file
foreach ($XMLposts as $XMLpost) {
    $stermId = (string) $XMLpost->id;
    // if the produc already exist, we modify it
    if (taxonomy_term_load($stermId)->field_old_id['und'][0]['value'] == $stermId) {
        $oTerm = taxonomy_term_load($stermId);
    } 
    // else we create it
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



/**** RETRIEVE PICTURE ****/
//$url = "http://qcsasia.com/.........";
//$target = "/images/....";
//copy($url, $target);
<?php

$response_xml_data = file_get_contents("http://localhost/qcsasia/xml-products/");
$XMLposts = simplexml_load_string($response_xml_data)->posts->post or die("Error: Cannot create object");
$stermId = '';

// for each product in the xml file
foreach ($XMLposts as $XMLpost) {
    $stermId = (string) $XMLpost->id;

    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->fieldCondition('field_old_id', 'value', $stermId)
            ->range(0, 5);

    $aResult = $oQuery->execute();

    // if the produc already exist, we modify it
    if ($aResult) {
        $oTerm = taxonomy_term_load(key(array_shift($aResult)));
    }
    // else we create it
    else {
        $oTerm = custom_create_taxonomy_term((string) $XMLpost->name, $stermId);
    }
}

var_dump($oTerm);

function custom_create_taxonomy_term($sName, $sId, $sVid = 2) {

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
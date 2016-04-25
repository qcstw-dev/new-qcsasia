<?php

if (isset($_GET['delete_all'])) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'gift');
    $aResult = $oQuery->execute();
    foreach ($aResult['taxonomy_term'] as $result) {
        $oTerm = taxonomy_term_load($result->tid);
        taxonomy_term_delete($oTerm->tid);
    }
    exit;
}

set_time_limit(0);
$response_xml_data = file_get_contents("https://qcsasia.com/xml-gifts/" . (isset($_GET['id']) && $_GET['id'] ? '?id=' . $_GET['id'] : ''));
//$response_xml_data = file_get_contents("http://localhost/qcsasia/xml-gifts/" . (isset($_GET['id']) && $_GET['id'] ? '?id=' . $_GET['id'] : ''));

$XMLposts = simplexml_load_string($response_xml_data)->posts->post or die("Error: Cannot create object");
$stermId = '';

// for each product in the xml file
foreach ($XMLposts as $XMLpost) {
    $stermId = (string) $XMLpost->id;

    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'gift')
            ->fieldCondition('field_old_id', 'value', $stermId)
            ->range(0, 1);

    $aResult = $oQuery->execute();

    // if the gift already exist, we modify it
    if ($aResult) {
        // echo 'already exit !';
        $oTerm = taxonomy_term_load(key(array_shift($aResult)));
    }
    // else we create it
    else {
        $oTerm = custom_create_taxonomy_term((string) $XMLpost->name, $stermId, 11);
    }
    saveData($oTerm, $XMLpost);
}

function saveData($oTerm, $XMLpost) {
    // DATA

    $oTerm->description = (string) $XMLpost->description;
    $oTerm->field_description['und'][0]['value'] = (string) $XMLpost->description;

    preg_match('/(#[a-zA-Z0-9]+)/', (string) $XMLpost->name, $matches);

    if ($matches[0] != '') {
        $oTerm->field_product_ref['und'][0]['value'] = $matches[0];
        $oTerm->field_product_name['und'][0]['value'] = str_replace($matches[0], "", (string) $XMLpost->name);
    } else {
        $oTerm->field_product_name['und'][0]['value'] = (string) $XMLpost->name;
    }

    $oTerm->field_date_gmt['und'][0]['value'] = (string) $XMLpost->date_gmt;
    $oTerm->field_item_size['und'][0]['value'] = (string) $XMLpost->item_size;
    $oTerm->field_logo_size['und'][0]['value'] = (string) $XMLpost->logo_size;
    $oTerm->field_packaging['und'][0]['value'] = (string) $XMLpost->packaging;
    $oTerm->field_patent['und'][0]['value'] = (string) $XMLpost->patent;

    foreach ($XMLpost->images->image as $aImage) {
        savePicture($aImage->title, $aImage->url, $oTerm);
    }

//     RELATION WITH OTHERS TAXONOMY TERMS
//     RESET COLORS
    $oTerm->field_colors['und'] = [];

    foreach ((array) $XMLpost->color_available as $sValue) {
        switch ($sValue) {
            case '01-pms021c' :
                $oTerm->field_colors['und'][] = ['tid' => '304'];
                break;
            case '02-pms200c' :
                $oTerm->field_colors['und'][] = ['tid' => '305'];
                break;
            case '03-pms287c' :
                $oTerm->field_colors['und'][] = ['tid' => '306'];
                break;
            case '04-pms2602' :
                $oTerm->field_colors['und'][] = ['tid' => '307'];
                break;
            case '05-pmsblack' :
                $oTerm->field_colors['und'][] = ['tid' => '308'];
                break;
            case '06-pmsgreenc' :
                $oTerm->field_colors['und'][] = ['tid' => '309'];
                break;
            case '07-pms1' :
                $oTerm->field_colors['und'][] = ['tid' => '310'];
                break;
            case '08-pms312c' :
                $oTerm->field_colors['und'][] = ['tid' => '311'];
                break;
            case '09-pms237c' :
                $oTerm->field_colors['und'][] = ['tid' => '312'];
                break;
            case '10-pms116c' :
                $oTerm->field_colors['und'][] = ['tid' => '310'];
                break;
            case '11-pms032c' :
                $oTerm->field_colors['und'][] = ['tid' => '311'];
                break;
            case '12-pms367c' :
                $oTerm->field_colors['und'][] = ['tid' => '312'];
                break;
            case '13-pms349c' :
                $oTerm->field_colors['und'][] = ['tid' => '313'];
                break;
        }
    }

    $aThemes = (array) $XMLpost->themes;
    
    foreach ($aThemes['theme'] as $oTheme) {
        saveTheme($oTheme, $oTerm);
    }
    
    $aDisplays = (array) $XMLpost->displays;
    
    foreach ($aDisplays['display'] as $oDisplay) {
        saveDisplay($oDisplay, $oTerm);
    }
    
    var_dump($oTerm);
    taxonomy_term_save($oTerm);
}

function saveDisplay($oDisplay, $oTerm) {
    $sDisplayRef = $oDisplay->display_ref;
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_gift_display'));
    switch ($sDisplayRef) {
        case 'rotative-carton-counter-display' :
            $field_collection_item->field_display['und'][] = ['tid' => '483'];
            break;
        case 'rotative-metal-table-top-display' :
            $field_collection_item->field_display['und'][] = ['tid' => '484'];
            break;
        case 'carton-table-top-display' :
            $field_collection_item->field_display['und'][] = ['tid' => '485'];
            break;
        case 'image-1' :
            $field_collection_item->field_display['und'][] = ['tid' => '486'];
            break;
    }
    foreach ($oDisplay->picture as $aPicture) {
        $oDisplayEntity = taxonomy_term_load($field_collection_item->field_display['und'][0]['tid']);
        $field_collection_item->field_display_image['und'][] = savePictureCustom('display', $aPicture, $oTerm->field_product_ref['und'][0]['value'].' - '.$oDisplayEntity->name);
    }
    // Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save();
}
function saveTheme($oTheme, $oTerm) {
    $sThemeRef = $oTheme->theme_ref;
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_gift_theme'));
    switch ($sThemeRef) {
        case 'espana' :
            $field_collection_item->field_theme['und'][] = ['tid' => '494'];
            break;
        case 'ibiza' :
            $field_collection_item->field_theme['und'][] = ['tid' => '499'];
            break;
        case '2' :
            $field_collection_item->field_theme['und'][] = ['tid' => '498'];
            break;
        case 'amname1' :
            $field_collection_item->field_theme['und'][] = ['tid' => '497'];
            break;
        case 'icon' :
            $field_collection_item->field_theme['und'][] = ['tid' => '500'];
            break;
        case 'je-suie-charlie' :
            $field_collection_item->field_theme['und'][] = ['tid' => '489'];
            break;
        case 'names-3' :
            $field_collection_item->field_theme['und'][] = ['tid' => '506'];
            break;
        case 'names-2' :
            $field_collection_item->field_theme['und'][] = ['tid' => '505'];
            break;
        case 'entertain' :
            $field_collection_item->field_theme['und'][] = ['tid' => '493'];
            break;
        case 'street' :
            $field_collection_item->field_theme['und'][] = ['tid' => '510'];
            break;
        case 'touristic' :
            $field_collection_item->field_theme['und'][] = ['tid' => '512'];
            break;
        case 'others' :
            $field_collection_item->field_theme['und'][] = ['tid' => '513'];
            break;
        case 'nhl' :
            $field_collection_item->field_theme['und'][] = ['tid' => '507'];
            break;
        case 'dogs' :
            $field_collection_item->field_theme['und'][] = ['tid' => '492'];
            break;
        case 'soccer-team' :
            $field_collection_item->field_theme['und'][] = ['tid' => '509'];
            break;
        case 'events' :
            $field_collection_item->field_theme['und'][] = ['tid' => '495'];
            break;
        case 'names' :
            $field_collection_item->field_theme['und'][] = ['tid' => '504'];
            break;
        case 'chinese-words' :
            $field_collection_item->field_theme['und'][] = ['tid' => '503'];
            break;
        case 'astrology-3' :
            $field_collection_item->field_theme['und'][] = ['tid' => '487'];
            break;
        case 'cars' :
            $field_collection_item->field_theme['und'][] = ['tid' => '488'];
            break;
        case 'cities' :
            $field_collection_item->field_theme['und'][] = ['tid' => '490'];
            break;
        case 'love' :
            $field_collection_item->field_theme['und'][] = ['tid' => '501'];
            break;
        case 'kamasutra' :
            $field_collection_item->field_theme['und'][] = ['tid' => '502'];
            break;
        case 'temper' :
            $field_collection_item->field_theme['und'][] = ['tid' => '511'];
            break;
        case 'skull' :
            $field_collection_item->field_theme['und'][] = ['tid' => '508'];
            break;
        case 'flags' :
            $field_collection_item->field_theme['und'][] = ['tid' => '496'];
            break;
        case 'theme-2' :
            $field_collection_item->field_theme['und'][] = ['tid' => '491'];
            break;
    }
    foreach ($oTheme->picture as $aPicture) {
        $oThemeEntity = taxonomy_term_load($field_collection_item->field_theme['und'][0]['tid']);
        $field_collection_item->field_theme_image['und'][] = savePictureCustom('theme', $aPicture, $oTerm->field_product_ref['und'][0]['value'].' - '.$oThemeEntity->name);
    }
    // Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save();
}

function savePictureCustom($sType, $sImgPath, $sThemeName) {
    $sTargetPath = 'gift/' . $sType;

    $file_temp = file_get_contents($sImgPath);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sImgPath), FILE_EXISTS_REPLACE);

    $file_temp->title = $sThemeName;
    $file_temp->alt = $sThemeName;
    
    return (array) $file_temp;
}

function savePicture($sType, $sImgPath, $oTerm) {
    $sFolderName = '';
    switch ($sType) {
        case 'thumbnail':
            $sFolderName = 'thumbnail';
            break;
        case 'photo_function':
            $sFolderName = 'function';
            break;
        case 'image_new_gift':
            $sFolderName = 'main';
            break;
    }
    $sTargetPath = 'gift/' . $sFolderName;
    
    
//    var_dump('public://' . $sTargetPath . '/' . basename($sImgPath));
    $file_temp = file_get_contents($sImgPath);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sImgPath), FILE_EXISTS_REPLACE);

    $sFieldName = '';
    switch ($sType) {
        case 'photo_function':
            $sFieldName = 'photo-function';
            break;
        case 'image_new_gift':
            $sFieldName = 'main';
            break;
    }
    
    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    $oTerm->{$sFieldName}['und'][0] = (array) $file_temp;
}

function custom_create_taxonomy_term($sName, $sId, $sVid = 11) {
    $oTerm = new stdClass();
    $oTerm->name = $sName;
    $oTerm->vid = $sVid;
    $oTerm->field_old_id['und'][0]['value'] = $sId;
    $oTerm->language = 'und';
    taxonomy_term_save($oTerm);
    return $oTerm;
}

<?php
//if (isset($_GET['delete_all'])) {
//    $oQuery = new EntityFieldQuery();
//    $oQuery->entityCondition('entity_type', 'taxonomy_term')
//            ->entityCondition('bundle', 'product');
//    $aResult = $oQuery->execute();
//    foreach ($aResult['taxonomy_term'] as $result) {
//        $oTerm = taxonomy_term_load($result->tid);
//        taxonomy_term_delete($oTerm->tid);
//    }
//    exit;
//}

set_time_limit(0);
$response_xml_data = file_get_contents("https://qcsasia.com/xml-products/" . (isset($_GET['id']) && $_GET['id'] ? '?id=' . $_GET['id'] : ''));
//$response_xml_data = file_get_contents("http://localhost/qcsasia/xml-products/" . (isset($_GET['id']) && $_GET['id'] ? '?id=' . $_GET['id'] : ''));

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
//        echo 'already exit !';
        $oTerm = taxonomy_term_load(key(array_shift($aResult)));
    }
    // else we create it
    else {
        $oTerm = custom_create_taxonomy_term((string) $XMLpost->name, $stermId);
    }
        saveData($oTerm, $XMLpost);
}

function saveData($oTerm, $XMLpost) {
    // DATA
    /*
    $oTerm->field_description['und'][0]['value'] = (string) $XMLpost->description;
    
    preg_match('/(#[a-zA-Z0-9]+)/', (string) $XMLpost->name, $matches);

    if ($matches[0] != '') {
        $oTerm->field_product_ref['und'][0]['value'] = $matches[0];
        $oTerm->field_product_name['und'][0]['value'] = str_replace($matches[0], "", (string) $XMLpost->name);
    } else {
        $oTerm->field_product_name['und'][0]['value'] = (string) $XMLpost->name;
    }
    
    $oTerm->description = (string) $XMLpost->description;
    $oTerm->field_date_gmt['und'][0]['value'] = (string) $XMLpost->date_gmt;
    $oTerm->field_complicated['und'][0]['value'] = (string) $XMLpost->complicated;
    $oTerm->field_item_size['und'][0]['value'] = (string) $XMLpost->item_size;
    $oTerm->field_logo_size['und'][0]['value'] = (string) $XMLpost->logo_size;
    $oTerm->field_packaging['und'][0]['value'] = (string) $XMLpost->packaging;
//    $oTerm->field_patented_item['und'][0]['value'] = (string) $XMLpost->patented;
    $oTerm->field_patent['und'][0]['value'] = (string) $XMLpost->patent;
    $oTerm->field_new_product['und'][0]['value'] = (string) $XMLpost->new;
    $oTerm->field_cheap_item['und'][0]['value'] = (string) $XMLpost->cheap_item;
    $oTerm->field_rush['und'][0]['value'] = (string) $XMLpost->program_item;
    $oTerm->field_activate_supplier_program['und'][0]['value'] = (string) $XMLpost->activate_supplier_program;
    $oTerm->field_activate_sales_program['und'][0]['value'] = (string) $XMLpost->activate_sales_program;
    
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
                $oTerm->field_colors['und'][] = ['tid' => '313'];
                break;
            case '11-pms032c' : 
                $oTerm->field_colors['und'][] = ['tid' => '314'];
                break;
            case '12-pms367c' : 
                $oTerm->field_colors['und'][] = ['tid' => '315'];
                break;
            case '13-pms349c' : 
                $oTerm->field_colors['und'][] = ['tid' => '316'];
                break;
        }
    }
    /*
    // RESET
    $oTerm->field_function['und'] = [];

    foreach ((array) $XMLpost->function as $sValue) {
        switch ($sValue) {
            case 'keychain' :
            case 'led-products' : // Keychain
                $oTerm->field_function['und'][] = ['tid' => '12'];
                break;
            case 'coin-keychain' : // trolley token
                $oTerm->field_function['und'][] = ['tid' => '15'];
                break;
            case 'magnet-stickers' : //stickers and magnets
                $oTerm->field_function['und'][] = ['tid' => '65'];
                break;
            case 'label-pins' : //wearable
                $oTerm->field_function['und'][] = ['tid' => '17'];
                break;
            case 'bottle-opener' : // bar accessory
            case 'bag-hanger' : // bar accessory
                $oTerm->field_function['und'][] = ['tid' => '13'];
                break;
            case 'container-canister' :
                $oTerm->field_function['und'][] = ['tid' => '19'];
                break;
            case 'phone-accessories' : // 3C accessory
                $oTerm->field_function['und'][] = ['tid' => '63'];
                break;
            case 'office-awards' : // Office
                $oTerm->field_function['und'][] = ['tid' => '62'];
            case 'wearable' : // Office
                $oTerm->field_function['und'][] = ['tid' => '17'];
                break;
        }
    }
    // RESET
    $oTerm->field_category['und'] = [];
    switch ($XMLpost->category) {
        case 'metal-enamel' :
            $oTerm->field_category['und'][] = ['tid' => '1'];
            break;
        case 'aluminium' :
            $oTerm->field_category['und'][] = ['tid' => '3'];
            break;
        case 'plastic-injection' :
            $oTerm->field_category['und'][] = ['tid' => '4'];
            break;
        case 'psba-silicon-wristband-with-plastic-patch-plastic-injection' :
            $oTerm->field_category['und'][] = ['tid' => '76'];
            break;
        case 'quick-up-ring-bottle-opener-qck' :
            $oTerm->field_category['und'][] = ['tid' => '77'];
            break;
        case 'pdtov-dogtag-and-dogcharm' :
            $oTerm->field_category['und'][] = ['tid' => '71'];
            break;
        case 'keychain' : // metal enamel keychain
            $oTerm->field_category['und'][] = ['tid' => '82'];
            break;
        case 'pskc-silicon-keychain-with-plastic-patch' :
            $oTerm->field_category['und'][] = ['tid' => '78'];
            break;
        case 'aluminium-coin-keychain-with-doming' :
            $oTerm->field_category['und'][] = ['tid' => '72'];
            break;
        case 'soft-pvc-cloisonne' :
            $oTerm->field_category['und'][] = ['tid' => '2'];
            break;
        case 'kcodd-double-side-doming-keychain' :
            $oTerm->field_category['und'][] = ['tid' => '79'];
            break;
        case 'soft-pvc-wearable-items' :
            $oTerm->field_category['und'][] = ['tid' => '68'];
            break;
        case 'rubber-trolley-coin-keychain' :
            $oTerm->field_category['und'][] = ['tid' => '80'];
            break;
        case 'pka-aluminium-keychain-with-doming' :
            $oTerm->field_category['und'][] = ['tid' => '73'];
            break;
        case 'soft-pvc-desk-accessories' :
            $oTerm->field_category['und'][] = ['tid' => '69'];
            break;
        case 'coin-keychain' :
            $oTerm->field_category['und'][] = ['tid' => '84'];
            break;
        case 'aop-aluminium-bottle-opener' :
            $oTerm->field_category['und'][] = ['tid' => '74'];
            break;
        case 'blinking-perfumed-glow-in-the-dark-and-uv-sensitive-soft-pvc' :
            $oTerm->field_category['und'][] = ['tid' => '70'];
            break;
        case 'bar-accessories' :
            $oTerm->field_category['und'][] = ['tid' => '85'];
            break;
        case 'pop-aluminium-bottle-opener' :
            $oTerm->field_category['und'][] = ['tid' => '75'];
            break;
        case 'desk-accessories' :
            $oTerm->field_category['und'][] = ['tid' => '86'];
            break;
        case 'wearable-accessories' :
            $oTerm->field_category['und'][] = ['tid' => '87'];
            break;
        case 'lapel-pins' :
            $oTerm->field_category['und'][] = ['tid' => '81'];
            break;
        case 'metal-lapel-pins-mlp' :
            $oTerm->field_category['und'][] = ['tid' => '81'];
            break;
        case 'medals-and-emblems' :
            $oTerm->field_category['und'][] = ['tid' => '89'];
            break;
    }
    
    // RESET
    $oTerm->field_supplier_program['und'] = [];
    foreach ((array) $XMLpost->supplier_program as $sValue) {
        switch ($sValue) {
            case 'ODD':
                $oTerm->field_supplier_program['und'][] = ['tid' => '41'];
                break;
            case 'OD':
                $oTerm->field_supplier_program['und'][] = ['tid' => '42'];
                break;
            case 'LR':
                $oTerm->field_supplier_program['und'][] = ['tid' => '43'];
                break;
            case 'PP':
                $oTerm->field_supplier_program['und'][] = ['tid' => '44'];
                break;
        }
    }

    $oTerm->field_sales_program['und'] = [];
    foreach ((array) $XMLpost->sales_program as $sValue) {
        switch ($sValue) {
            case 'ODD':
                $oTerm->field_sales_program['und'][] = ['tid' => '37'];
                break;
            case 'OD':
                $oTerm->field_sales_program['und'][] = ['tid' => '38'];
                break;
            case 'LR':
                $oTerm->field_sales_program['und'][] = ['tid' => '39'];
                break;
            case 'PP':
                $oTerm->field_sales_program['und'][] = ['tid' => '40'];
                break;
        }
    }
*/
    
    $aLogoImages = [];
    foreach ($XMLpost->images->image as $aImage) {
        if ($aImage->title == 'image_logo_process') {
            $aLogoImages[] = $aImage->url;
        }
    }
    $aLargeImage = [];
    foreach ($XMLpost->slideshow->slide as $aSlide) {
       if (strposa(strtolower($aSlide->slide_title), ['doming',
           'laser engraving', 
           'pvc', 
           'silk',
           'digital',
           'offset printing',
           'epoxy', 
           'blind',
           'soft',
           'woven',
           'offset',
           'iron',
           'brass',
           'zamac',
           ])) {
           $aLargeImage[] = $aSlide;
       }
    }
    
    
    // RESET
    $oTerm->field_logo_process_block['und'] = [];
    foreach ((array) $XMLpost->logo_process as $key => $sValue) {
        switch ($sValue) {
            case '2D-PVC-Cloisonne': // PVC Cloisonne
            case '3D-PVC-Cloisonne': // PVC Cloisonne
                add_field_collection_image_logo('29', $aLogoImages[$key], $oTerm);
                break;
            case 'Laser-engraving': // laser engraving
                add_field_collection_image_logo('31', $aLogoImages[$key], $oTerm);
                break;
            case 'Silk-screen-printing': // silk screen printing
                add_field_collection_image_logo('32', $aLogoImages[$key], $oTerm);
                break;
            case 'Digitel-printing': // digital printing
                add_field_collection_image_logo('33', $aLogoImages[$key], $oTerm);
                break;
            case 'Doming': // doming
                add_field_collection_image_logo('34', $aLogoImages[$key], $oTerm);
                break;
            case 'Offset-printing': // offset printing
            case 'Epoxy': // offset printing
                add_field_collection_image_logo('36', $aLogoImages[$key], $oTerm);
                break;
            case 'Blind-stamping':
                break;
            case 'Soft-enamel': // enamel
            case 'Woven-enamel': // enamel
            case 'Zamac':
            case 'Brass':
            case 'Iron':
            case 'Offset':
                add_field_collection_image_logo('27', $aLogoImages[$key], $oTerm);
                break;
            case 'Pvc-label': // PVC Cloisonne
                add_field_collection_image_logo('29', $aLogoImages[$key], $oTerm);
                break;
        }
    }
    
    
/*
    // IMAGES
    $bAlreadyAdd = [
        'field_image_option' => false,
        'field_image_logo_process' => false
    ];
    foreach ($XMLpost->images->image as $aImage) {
        if ($aImage->title == 'image_option') {
            add_field_collection_image_option($aImage->title_image, $aImage->url, $oTerm);
        } else {
            savePicture($aImage->title, $aImage->url, $oTerm, $bAlreadyAdd);
        }
    }

    // SLIDESHOW
//    foreach ($XMLpost->slideshow->slide as $aSlide) {
//        add_field_collection_slide($aSlide->slide_title, $aSlide->slide_image, $oTerm);
//    }

    
     // DOCUMENT CENTER
    // RESET
    if ($oTerm->field_group_document) {
        $aIdFieldDocumentToDelete = [];
        foreach ($oTerm->field_group_document['und'] as $key => $sValue) {
            $aIdFieldDocumentToDelete[] = $sValue['value'];
            unset($oTerm->field_group_document['und'][$key]);
        }
        entity_delete_multiple('field_collection_item', $aIdFieldDocumentToDelete);
    }
//    var_dump((array) $XMLpost->document_center );
    foreach ((array) $XMLpost->document_center as $sKey => $aGroupDocument) {
        $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_group_document'));
        switch ($sKey) {
            case 'picture_high_definition':
                $field_collection_item->field_group_document_title['und'][0]['value'] = "Pictures high definition";   
                break;
            case 'pricelist':
                $field_collection_item->field_group_document_title['und'][0]['value'] = "Pricelist";   
                break;
            case 'patent':
                $field_collection_item->field_group_document_title['und'][0]['value'] = "Patent";   
                break;
            case 'digital_drawing':
                $field_collection_item->field_group_document_title['und'][0]['value'] = "Digital drawing";   
                break;
            case 'other':
                $field_collection_item->field_group_document_title['und'][0]['value'] = "Other";   
                break;
            default:
                break;
        }
        $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
        $field_collection_item->save();
//        var_dump($aGroupDocument);
        if ($sKey == 'picture_high_definition') {
            foreach ($aGroupDocument as $aDocument) {
                add_field_collection_document($field_collection_item, (array) $aDocument);
            }
        } else {
            add_field_collection_document($field_collection_item, (array) $aGroupDocument);
        }
        $field_collection_item->save();
    }
    */
    taxonomy_term_save($oTerm);
}

/* * ***************************************************** FUNCTIONS ************************************************ */
function add_field_collection_document($field_collection_item, $aValues) {
    $field_collection_item_document = entity_create('field_collection_item', array('field_name' => 'field_document'));
    $field_collection_item_document->field_document_title['und'][0]['value'] = $aValues['title'];
    $field_collection_item_document->field_document_link['und'][0]['value'] = $aValues['file'];

// Save field collection item
    $field_collection_item_document->setHostEntity('field_collection_item', $field_collection_item);
    $field_collection_item_document->save();
    $field_collection_item->save();
}
function custom_create_taxonomy_term($sName, $sId, $sVid = 2) {
    $oTerm = new stdClass();
    $oTerm->name = $sName;
    $oTerm->vid = $sVid;
    $oTerm->field_old_id['und'][0]['value'] = $sId;
    $oTerm->language = 'und';
    taxonomy_term_save($oTerm);
    return $oTerm;
}

function add_field_collection_slide($sTitle, $sUrl, $oTerm) {
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_slide'));
    $field_collection_item->field_slide_title[LANGUAGE_NONE][] = ['value' => $sTitle];

    saveSlide($sUrl, $oTerm, $field_collection_item);

// Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save();
}

function saveSlide($sUrl, $oTerm, $field_collection_item) {
    $sTargetPath = 'products/slideshow';

    $file_temp = file_get_contents($sUrl);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sUrl), FILE_EXISTS_REPLACE);

    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    $field_collection_item->field_slide_image['und'][0] = (array) $file_temp;
}

function savePicture($sType, $sImgPath, $oTerm, $bAlreadyAdd) {
    $sFolderName = '';
    switch ($sType) {
        case 'thumbnail':
            $sFolderName = 'thumbnail';
            break;
        case 'photo_function':
            $sFolderName = 'photo-function';
            break;
        case 'first_image':
            $sFolderName = 'main';
            break;
//        case 'image_option':
//            $sFolderName = 'option';
//            break;
        case 'image_new_product':
            $sFolderName = 'new-product';
            break;
        case 'image_logo_process':
            $sFolderName = 'logo-process';
            break;
    }

    $sTargetPath = 'products/' . $sFolderName;

    $file_temp = file_get_contents($sImgPath);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sImgPath), FILE_EXISTS_REPLACE);

    $sFieldName = '';
    switch ($sType) {
        case 'thumbnail':
            $sFieldName = 'field_thumbnail';
            break;
        case 'photo_function':
            $sFieldName = 'field_photo_function';
            break;
        case 'first_image':
            $sFieldName = 'field_main_photo';
            break;
//        case 'image_option':
//            $sFieldName = 'field_image_option';
//            break;
        case 'image_new_product':
            $sFieldName = 'field_image_new_product';
            break;
        case 'image_logo_process':
            $sFieldName = 'field_image_logo_process';
            break;
    }

    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    if ($sFieldName == 'field_image_logo_process') {
        $oTerm->{$sFieldName}['und'][] = (array) $file_temp;
//        if ($bAlreadyAdd[$sFieldName] == true) {
//            $oTerm->{$sFieldName}['und'][] = (array) $file_temp;
//        } else {
//            $oTerm->{$sFieldName}['und'][0] = (array) $file_temp;
//            $bAlreadyAdd[$sFieldName] = true;
//        }
    } else {
        $oTerm->{$sFieldName}['und'][0] = (array) $file_temp;
    }
}

function add_field_collection_image_option($sTitle, $sUrl, $oTerm) {
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_image_option'));
    $field_collection_item->field_image_option_title[LANGUAGE_NONE][] = ['value' => $sTitle];

    saveImageOption($sUrl, $oTerm, $field_collection_item);

    // Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save();
}


function add_field_collection_image_logo($sLogoId, $sUrl, $oTerm) {
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_logo_process_block'));
    $field_collection_item->field_logo_process[LANGUAGE_NONE][0] = ['tid' => $sLogoId];

    saveImageLogoProcess($sUrl, $oTerm, $field_collection_item);

    // Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save();
}


function saveImageLogoProcess($sUrl, $oTerm, $field_collection_item) {
    $sTargetPath = 'products/logo-process';

    $file_temp = file_get_contents($sUrl);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sUrl), FILE_EXISTS_REPLACE);

    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    $field_collection_item->field_logo_process_thumbnail['und'][0] = (array) $file_temp;
}
function saveImageOption($sUrl, $oTerm, $field_collection_item) {
    $sTargetPath = 'products/option';

    $file_temp = file_get_contents($sUrl);
    $file_temp = file_save_data($file_temp, 'public://' . $sTargetPath . '/' . basename($sUrl), FILE_EXISTS_REPLACE);

    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    $field_collection_item->field_image_option_img['und'][0] = (array) $file_temp;
}


function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}
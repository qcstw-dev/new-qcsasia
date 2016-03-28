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
//    $oTerm->field_description['und'][0]['value'] = (string) $XMLpost->description;
    $oTerm->field_product_name['und'][0]['value'] = (string) $XMLpost->name;
    /*
    $oTerm->description = (string) $XMLpost->description;
    $oTerm->field_date_gmt['und'][0]['value'] = (string) $XMLpost->date_gmt;
    $oTerm->field_complicated['und'][0]['value'] = (string) $XMLpost->complicated;
    $oTerm->field_item_size['und'][0]['value'] = (string) $XMLpost->item_size;
    $oTerm->field_logo_size['und'][0]['value'] = (string) $XMLpost->logo_size;
    $oTerm->field_packaging['und'][0]['value'] = (string) $XMLpost->packaging;
    $oTerm->field_patented_item['und'][0]['value'] = (string) $XMLpost->patented;
    $oTerm->field_patent['und'][0]['value'] = (string) $XMLpost->patent;
    $oTerm->field_new_product['und'][0]['value'] = (string) $XMLpost->new;
    $oTerm->field_cheap_item['und'][0]['value'] = (string) $XMLpost->cheap_item;
    $oTerm->field_program_item['und'][0]['value'] = (string) $XMLpost->program_item;
    $oTerm->field_activate_supplier_program['und'][0]['value'] = (string) $XMLpost->activate_supplier_program;
    $oTerm->field_activate_sales_program['und'][0]['value'] = (string) $XMLpost->activate_sales_program;
    */
    
    // RELATION WITH OTHERS TAXONOMY TERMS
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

    // RESET
    $oTerm->field_logo_process['und'] = [];
    foreach ((array) $XMLpost->logo_process as $sValue) {
        switch ($sValue) {
            case '2D-PVC-Cloisonne': // PVC Cloisonne
            case '3D-PVC-Cloisonne': // PVC Cloisonne
                $oTerm->field_logo_process['und'][] = ['tid' => '29'];
                break;
            case 'Laser-engraving': // laser engraving
                $oTerm->field_logo_process['und'][] = ['tid' => '31'];
                break;
            case 'Silk-screen-printing': // silk screen printing
                $oTerm->field_logo_process['und'][] = ['tid' => '32'];
                break;
            case 'Digitel-printing': // digital printing
                $oTerm->field_logo_process['und'][] = ['tid' => '33'];
                break;
            case 'Doming': // doming
                $oTerm->field_logo_process['und'][] = ['tid' => '34'];
                break;
            case 'Offset-printing': // offset printing
            case 'Epoxy': // offset printing
                $oTerm->field_logo_process['und'][] = ['tid' => '36'];
                break;
            case 'Blind-stamping':
                break;
            case 'Soft-enamel': // enamel
            case 'Woven-enamel': // enamel
                $oTerm->field_logo_process['und'][] = ['tid' => '27'];
                break;
            case 'Pvc-label': // PVC Cloisonne
                $oTerm->field_logo_process['und'][] = ['tid' => '29'];
                break;
            case 'Zamac':
            case 'Brass':
            case 'Iron':
            case 'Offset':
                $oTerm->field_logo_process['und'][] = ['tid' => '27'];
                break;
        }
    }
    
    /*
    // DOCUMENT CENTER
    // RESET
    if ($oTerm->field_document) {
        $aIdFieldDocumentToDelete = [];
        foreach ($oTerm->field_document['und'] as $key => $sValue) {
            $aIdFieldDocumentToDelete[] = $sValue['value'];
            unset($oTerm->field_document['und'][$key]);
        }
        entity_delete_multiple('field_collection_item', $aIdFieldDocumentToDelete);
    }
    foreach ($XMLpost->document_center->document as $aDocument) {
        add_field_collection_document($oTerm, (string) $aDocument->title, (string) $aDocument->file);
    }

    // IMAGES
    $bAlreadyAdd = [
        'field_image_option' => false,
        'field_image_logo_process' => false
    ];
    foreach ($XMLpost->images->image as $aImage) {
        savePicture($aImage->title, $aImage->url, $oTerm, $bAlreadyAdd);
    }

    // SLIDESHOW
//    foreach ($XMLpost->slideshow->slide as $aSlide) {
//        add_field_collection_slide($aSlide->slide_title, $aSlide->slide_image, $oTerm);
//    }
     
     */
    taxonomy_term_save($oTerm);
}
/*
  if () {
  ?>
  <script>
  setTimeout(function () {
  location.reload();
  }, 5000);
  </script><?php } */



/* * ***************************************************** FUNCTIONS ************************************************ */

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
    $field_collection_item->save(FALSE);
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
        case 'image_option':
            $sFolderName = 'option';
            break;
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
        case 'image_option':
            $sFieldName = 'field_image_option';
            break;
        case 'image_new_product':
            $sFieldName = 'field_image_new_product';
            break;
        case 'image_logo_process':
            $sFieldName = 'field_image_logo_process';
            break;
    }

    $file_temp->title = $oTerm->name;
    $file_temp->alt = $oTerm->name;

    if (in_array($sFieldName, ['field_image_option', 'field_image_logo_process'])) {
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

function add_field_collection_document($oTerm, $sTitle, $sLink) {
    $field_collection_item = entity_create('field_collection_item', array('field_name' => 'field_document'));
    $field_collection_item->field_document_title[LANGUAGE_NONE][] = ['value' => $sTitle];
    $field_collection_item->field_document_link[LANGUAGE_NONE][] = ['value' => $sLink];

// Save field collection item
    $field_collection_item->setHostEntity('taxonomy_term', $oTerm);
    $field_collection_item->save(FALSE);
}

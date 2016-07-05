<?php
$aResponse = ['success' => false];
$aGet = drupal_get_query_parameters();
if (isset($aGet['id']) && $aGet['id']) {
    $aResponse = addToWishlist($aGet['id']);
} else {
    $aResponse['success'] = false;
    $aResponse['error'] = 'Id is missing';
}

echo json_encode($aResponse);
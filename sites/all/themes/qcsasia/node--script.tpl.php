
<!--<span class="font-size-150 glyphicon glyphicon-transfer color-soft-blue"></span>
<span class="font-size-150 glyphicon glyphicon-envelope color-soft-green"></span>
<span class="font-size-150 glyphicon glyphicon-list-alt color-soft-orange"></span>
<span class="font-size-150 glyphicon glyphicon-gift color-red"></span>
<span class="font-size-150 glyphicon glyphicon-user color-soft-orange"></span>-->
<span class="font-size-150 glyphicon glyphicon-pencil color-soft-orange"></span>

<?php

set_time_limit(0);

/*
 *  METATAGS
 * 
 */
/*
modifyTitle('patented');
modifyTitle('rush');
modifyTitle('cheap');
modifyTitle('new');
modifyTitle('category');
modifyTitle('function');
modifyTitle('logo_process');

function modifyTitle ($sTermName) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', $sTermName);

    $aResults = taxonomy_term_load_multiple(array_keys($oQuery->execute()['taxonomy_term']));
    $metatags = [];
    foreach ($aResults as $key => $oResult) {
        $meta = metatags_get_entity_metatags($oResult->tid, 'taxonomy_term');
        $metatags['en'] = [
            'title' => ['value' => $oResult->name]
    //        ,
    //        'description' => ['value' => str_replace(CHR(13) . CHR(10), "", strip_tags($oResult->field_description[und][0][value]))]
            ];
        metatag_metatags_save('taxonomy_term', $oResult->tid, 0, $metatags);
        echo $oResult->name.'<br />';
    }
    
}
*/

/*
 *  FINISHES
 */

/*
  $oQuery = new EntityFieldQuery();
  $oQuery->entityCondition('entity_type', 'taxonomy_term')
  ->entityCondition('bundle', 'product')
  ->fieldCondition('field_complicated', 'value', '0')
  ->fieldCondition('field_display_image_finishes', 'value', '0');
  $mCategories = getTermByRef('metal-enamel', 'category');
  $aCategoriesBis = [];
  if (!is_array($mCategories)) {
  $aCategoriesBis[] = $mCategories;
  } else {
  $aCategoriesBis = $mCategories;
  }
  $aChildrenCategories = [];
  foreach ($aCategoriesBis as $oCategory) {
  // retrieve children categories
  $aChildrenCategories = taxonomy_get_children($oCategory->tid);
  if ($aChildrenCategories) {
  foreach ($aChildrenCategories as $oChildrenCategory) {
  $aCategoriesBis[$oChildrenCategory->tid] = $oChildrenCategory;
  }
  } else {
  $aCategoriesBis[$oChildrenCategory->tid] = $oChildrenCategory;
  }
  }
  $oQuery->fieldCondition('field_category', 'tid', array_keys($aCategoriesBis));
  $aResults = taxonomy_term_load_multiple(array_keys($oQuery->execute()['taxonomy_term']));
  foreach ($aResults as $oResult) {
  $oResult->field_display_image_finishes['und'][0]['value'] = 1;
  taxonomy_term_save($oResult);
      var_dump($oResult->name);
  } */
?>


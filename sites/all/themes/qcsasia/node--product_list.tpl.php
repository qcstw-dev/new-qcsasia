<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <?php var_dump(drupal_get_query_parameters()); ?>
    <h2><?= $title ?></h2><?php 
    // Retrieve all the categories
    $aCategoryVocabulary = taxonomy_vocabulary_machine_name_load('category');
    $aCategories = taxonomy_get_tree($aCategoryVocabulary->vid, 0, NULL, TRUE);
    
    $iFilterCategoryById = null;
    
    // If a category is pass in GET variable then we filter
    if (drupal_get_query_parameters()['category']) {
        foreach ($aCategories as $oCategorie) {
            if (isset($oCategorie->field_reference['und'][0]['value']) && $oCategorie->field_reference['und'][0]['value'] === drupal_get_query_parameters()['category']) {
                $iFilterCategoryById = $oCategorie->tid;
                break;
            }
        }
        if (!$iFilterCategoryById) {
            echo '<div class="alert alert-danger text-center" role="alert">'
                    . '<span class="glyphicon glyphicon-warning-sign"></span> This category does not exist <span class="glyphicon glyphicon-warning-sign"></span>'
                . '</div>';
        }
    }
    
    // Retrieve all the product
    $aProducts = [];
    $aProductVocabulary = taxonomy_vocabulary_machine_name_load('product');
    $aAllProducts = taxonomy_get_tree($aProductVocabulary->vid, 0, NULL, TRUE);
    
    if ($iFilterCategoryById) {
        foreach ($aAllProducts as $oProduct) {
            if ($oProduct->field_category['und'][0]['tid'] == $iFilterCategoryById) {
                $aProducts[] = $oProduct;
            }
        }
    } else {
        $aProducts = $aAllProducts;
    }
    // Display Products
    echo "<ul>";
    foreach ($aProducts as $oProduct) {
        echo "<li>".$oProduct->name."</li>";
    }
    echo "</ul>"; ?>
</div>
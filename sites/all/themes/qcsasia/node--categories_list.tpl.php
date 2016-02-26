<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2><?= $title ?></h2><?php
    // Retrieve all the categories
    // retrieve products
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'category')
            ->range(0, 5);

    $aResult = $oQuery->execute();
    $aCategories = taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));

    // Display categories
    print "<ul>";
    foreach ($aCategories as $oCategory) {
        print '<li><a href="' . url(entity_uri('taxonomy_term', $oCategory)['path']) . '" >' . $oCategory->name . '</a></li>';
    }
    print "</ul>";
    ?>
</div>
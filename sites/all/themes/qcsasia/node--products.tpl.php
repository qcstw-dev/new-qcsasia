<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2><?= $title ?></h2><?php 
    // Retrieve all the categories
    $aCategoryVocabulary = taxonomy_vocabulary_machine_name_load('category');
    $aCategories = taxonomy_get_tree($aCategoryVocabulary->vid, 0, NULL, TRUE);
    
    // Display categories
    print "<ul>";
        foreach ($aCategories as $oCategory) {
            print '<li><a href="'.url('taxonomy/term/'.$oCategory->tid).'" >'.$oCategory->name.'</a></li>';
        }
    print "</ul>"; ?>
</div>
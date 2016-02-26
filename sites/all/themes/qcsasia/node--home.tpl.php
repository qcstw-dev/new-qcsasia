<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>><?php
    // retrieve posts
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'node')
            ->propertyCondition('status', 1)
            ->propertyCondition('type', array('post'))
            ->propertyOrderBy('created', 'DESC')
            ->range(0, 5);
    $aResult = $oQuery->execute();
    
    $aPosts = node_load_multiple(array_keys($aResult['node']));
    
    var_dump($aPosts);
    foreach ($aPosts as $oPost) {
        
    }
    ?>    
</div>
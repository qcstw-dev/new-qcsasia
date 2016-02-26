<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2>Our promotional products lines</h2><?php 
     displayCategories(); ?>
    <h2>News</h2><?php
    // retrieve posts
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'node')
            ->propertyCondition('status', 1)
            ->propertyCondition('type', array('post'))
            ->propertyOrderBy('created', 'DESC')
            ->range(0, 5);
    $aResult = $oQuery->execute();

    $aPosts = node_load_multiple(array_keys($aResult['node']));

    echo '<ul>';
    foreach ($aPosts as $oPost) {
        echo '<li><a href="' . url(entity_uri('node', $oPost)['path']) . '" title="' . $oPost->title . '">' . $oPost->title . '</a><br />'
        . '<p>' . $oPost->body['und'][0]['value'] . '</p></li>';
    }
    echo '</ul>'; ?>    
</div>
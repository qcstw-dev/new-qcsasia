<h2><?= $node->title ?></h2>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix col-md-12"<?php print $attributes; ?>>
    <?= $node->body['und'][0]['value'] ?>
</div>
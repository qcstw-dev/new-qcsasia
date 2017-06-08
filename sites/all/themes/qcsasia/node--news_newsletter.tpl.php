<h2><?= $node->title ?></h2>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix col-md-12"<?php print $attributes; ?>><?php
    global $base_url; ?>
    <?= $node->field_newsletter_description['und'][0]['value'] ?>
    <div class="clearfix"></div>
    <a class="thumbnail border-none margin-top-10"  href="<?= str_replace('{base_url}', $base_url, $node->field_newsletter_news_link['und'][0]['value']) ?>">
        <img src="<?= file_create_url($node->field_newsletter_news_image['und'][0]['uri']) ?>" alt="<?= $node->title ?>" title="<?= $node->title ?>" />
    </a>
</div>
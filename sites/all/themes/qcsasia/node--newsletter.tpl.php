<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2 class="margin-top-0">Newsletter</h3>
    <div class="col-xs-12 padding-0"><?php
    global $base_url;
    foreach ($field_newsletter as $field_nl) {
        $oNewsletter = array_values(entity_load('field_collection_item', [$field_nl['value']]))[0]; ?>
        <div class="col-sm-3">
            <a href="<?= str_repeat('{base_url}', $base_url, $oNewsletter->field_newsletter_link['und'][0]['value']) ?>" target="_blank" title="<?= $oNewsletter->field_newsletter_title['und'][0]['value'] ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= file_create_url($oNewsletter->field_newsletter_picture['und'][0]['uri']) ?>" alt="<?= $oNewsletter->field_newsletter_title['und'][0]['value'] ?>" title="<?= $oNewsletter->field_newsletter_title['und'][0]['value'] ?>" />
                    <div class="subtitle-pic font-size-13"><?= $oNewsletter->field_newsletter_title['und'][0]['value'] ?></div>
                </div>
            </a>
        </div><?php
    } ?>
    </div>
</div>
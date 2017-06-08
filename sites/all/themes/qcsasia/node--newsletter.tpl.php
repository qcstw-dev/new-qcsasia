<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2 class="margin-top-0">Newsletters</h3>
    <div class="col-xs-12 padding-0"><?php
    global $base_url;
        $vocabulary = taxonomy_vocabulary_machine_name_load('newsletter_block');
        $aNewsletterBlocks = entity_load('taxonomy_term', FALSE, array('vid' => $vocabulary->vid));
        foreach ($aNewsletterBlocks as $aNewsletterBlock) { ?>
            <div class="col-sm-3">
                <a href="<?= str_replace('{base_url}', $base_url, $aNewsletterBlock->field_newsletter_link['und'][0]['value']) ?>" target="_blank" title="<?= $aNewsletterBlock->field_newsletter_title['und'][0]['value'] ?>">
                    <div class="thumbnail thumbnail-hover">
                        <img src="<?= file_create_url($aNewsletterBlock->field_newsletter_image['und'][0]['uri']) ?>" alt="<?= $aNewsletterBlock->field_newsletter_title['und'][0]['value'] ?>" title="<?= $aNewsletterBlock->field_newsletter_title['und'][0]['value'] ?>" />
                        <div class="subtitle-pic font-size-13"><?= $aNewsletterBlock->field_newsletter_title['und'][0]['value'] ?></div>
                    </div>
                </a>
            </div><?php
        } ?>
    </div>
</div>
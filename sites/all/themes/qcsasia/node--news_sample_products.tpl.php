<h2><?= $node->title ?></h2>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix col-md-12"<?php print $attributes; ?>><?php global $base_url; ?>
    <?= $node->field_news_sample_products_descr['und'][0]['value'] ?>
    <div class="thumbnail margin-auto">
        <img src="<?= file_create_url($node->field_news_sample_products_image['und'][0]['uri']) ?>" alt="<?= $node->title ?>" title="<?= $node->title ?>" />
    </div><?php
    if ($node->field_news_sample_products_links) { ?>
        <div class="margin-top-20">
        <p><strong>Item description (from left to right, top to bottom):</strong></p><?php
        foreach ($node->field_news_sample_products_links['und'] as $key => $aProduct) { 
            $oProduct = taxonomy_term_load($aProduct['tid']); ?>
            <a href="<?= url('taxonomy/term/' . $oProduct->tid) ?>" title="<?= $oProduct->field_product_name['und'][0]['value'] ?>"><?= $oProduct->field_product_name['und'][0]['value'] ?></a><?= isset($node->field_news_sample_products_links['und'][$key+1]) ? ',' : '' ?><?php
        }
    } ?>
</div>
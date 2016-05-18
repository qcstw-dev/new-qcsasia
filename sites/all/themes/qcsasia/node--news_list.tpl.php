<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix col-md-12"<?php print $attributes; ?>>
    <?php
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'node')
            ->propertyCondition('status', 1)
            ->propertyCondition('type', 'news')
            ->propertyOrderBy('created', 'DESC');
    $aResult = $oQuery->execute();
    if ($aResult) {
        $aNewsList = node_load_multiple(array_keys($aResult['node'])); 
        foreach ($aNewsList as $oNews) { ?>
            <div class="col-xs-12 news-row border-md-bottom margin-bottom-20">
                <a href="<?= url('node/'.$oNews->nid) ?>" title="">
                    <div class="col-sm-3 thumbnail margin-bottom-sm-10">
                        <img class="width-100" src="<?= file_create_url($oNews->field_news_thumbnail['und'][0]['uri']) ?>" title="<?= ($oNews->field_news_thumbnail['und'][0]['title'] ?: $oNews->title) ?>" alt="<?= ($oNews->field_news_thumbnail['und'][0]['alt'] ?: $oNews->title) ?>" />
                    </div>
                    <div class="col-sm-9 news-text">
                        <h4><?= $oNews->title ?></h4>
                        <p><?= $oNews->body['und'][0]['summary'] ?></p>
                    </div>
                </a>
            </div><?php
        }
    } ?>
</div>
<?php 
$xml = new SimpleXMLElement('<xml/>');

$oQuery = new EntityFieldQuery();
$oQuery->entityCondition('entity_type', 'node')
            ->propertyCondition('status', 1)
            ->propertyCondition('type', 'news')
            ->propertyOrderBy('created', 'DESC')
            ->range(0, 6);

$aNews = node_load_multiple(array_keys($oQuery->execute()['node']));

if ($aNews) {
    foreach ($aNews as $oNews) {
        $post_id = $oNews->nid;
        $title = $oNews->title;
        $url = url('node/'.$oNews->nid, ['absolute' => true]);
        $thumbnail_url = file_create_url($oNews->field_news_thumbnail['und'][0]['uri']);
        $post = $xml->addChild('post');
        $post->addAttribute('id', $post_id);
        $post->addChild('title', $title);
        $post->addChild('url', $url);
        $post->addChild('thumbnail_url', $thumbnail_url);
    }
}
header('Content-Type: text/xml; charset=UTF-8');
print($xml->asXML());

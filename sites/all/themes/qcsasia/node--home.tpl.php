<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="col-md-12 padding-0">
        <div id="carousel-home" class="carousel carousel-home slide" data-ride="carousel-home">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox"><?php
                $aHomeSlideShow = array_values(taxonomy_get_term_by_name('Home slideshow', 'slideshow'))[0]; 
                global $base_url;
                foreach ($aHomeSlideShow->field_slide['und'] as $key => $aSlide) { 
                $oSlide = field_collection_item_load($aSlide['value']); ?>
                    <div class="item <?= ($key == 0 ? 'active' : '') ?>">
                        <a href="<?= str_replace('{base_url}', $base_url, $oSlide->field_slide_url['und'][0]['value']) ?>" title="<?= $oSlide->field_slide_title['und'][0]['value'] ?>">
                            <img src="<?= file_create_url($oSlide->field_slide_image['und'][0]['uri']) ?>" alt="<?= $oSlide->field_slide_title['und'][0]['value'] ?>" title="<?= $oSlide->field_slide_title['und'][0]['value'] ?>" />
                            <div class="slide-text"><?= $oSlide->field_slide_title['und'][0]['value'] ?></div>
                        </a>
                    </div><?php
                } ?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="col-md-12 margin-top-10 padding-0">
        <h2>Our product lines</h2>
    </div>
    <div class="col-md-12 padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-category">
                <div>
                    <a href="<?= url('node/13', ['query' => ['category' => 'metal-enamel']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/metal-enamel.jpg") ?>" alt="Metal enamel" title="Metal enamel" />
                        <div class="subtitle-pic">Metal enamel</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['category' => 'soft-pvc-cloisonne']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/pvc-cloisonne.jpg") ?>" alt="PVC Cloisonne" title="PVC Cloisonne" />
                        <div class="subtitle-pic">Soft PVC cloisonne</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['category' => 'aluminium']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/aluminium.jpg") ?>" alt="Aluminium" title="Aluminium" />
                        <div class="subtitle-pic">Aluminium</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['category' => 'plastic-injection']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/plastic-injection.jpg") ?>" alt="Plastic injection" title="Plastic injection" />
                        <div class="subtitle-pic">Plastic injection</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/33') ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/gift.jpg") ?>" alt="Gift and souvenirs" title="Gift and souvenirs" />
                        <div class="subtitle-pic">Gift & souvenirs</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2>Our product functions</h2>
    </div>
    <div class="col-md-12 padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-function">
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'keychain']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/keychain.jpg") ?>" title="Keychain" alt="Keychain" />
                        <div class="subtitle-pic">Keychain</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'bar-accessory']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/bar.jpg") ?>" title="Bar - accessory" alt="Bar - accessory" />
                        <div class="subtitle-pic">Bar - accessory</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'trolley-token']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/trolley-token.jpg") ?>" title="Trolley token" alt="Trolley token" />
                        <div class="subtitle-pic">Trolley token</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'wearable']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/wearable.jpg") ?>" title="Wearable" alt="Wearable" />
                        <div class="subtitle-pic">Wearable</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'canister-container']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/canister.jpg") ?>" title="Canister and container" alt="Canister and container" />
                        <div class="subtitle-pic">Canister and container</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => '3c-accessory']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/3c.jpg") ?>" title="3C accessory" alt="3C accessory" />
                        <div class="subtitle-pic">3C accessory</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'tools']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/tools.jpg") ?>" title="Tools" alt="Tools" />
                        <div class="subtitle-pic">Tools</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['function' => 'stickers-and-magnets']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/stickers.jpg") ?>" title="Stickers / Doming" alt="Stickers / Doming" />
                        <div class="subtitle-pic">Stickers / Doming</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2>Our logo processes</h2>
    </div>
    <div class="col-md-12 padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-logo-process">
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'doming']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/doming.jpg") ?>" title="Doming" alt="Doming" />
                        <div class="subtitle-pic">Doming</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'digital-printing']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/digital-printing.jpg") ?>" title="Digital printing" alt="Digital printing" />
                        <div class="subtitle-pic">Digital printing</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'silk-screen-printing']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/silk-screen-print.jpg") ?>" title="Silk screen print" alt="Silk screen print" />
                        <div class="subtitle-pic">Silk screen print</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'laser-engraving']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/laser.jpg") ?>" title="Laser engraving" alt="Laser engraving" />
                        <div class="subtitle-pic">Laser engraving</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'offset-printing']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/offset-printing.jpg") ?>" title="Offset printing" alt="Offset printing" />
                        <div class="subtitle-pic">Offset printing</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => 'enamel']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/enamel.jpg") ?>" title="Enamel" alt="Enamel" />
                        <div class="subtitle-pic">Enamel</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => '2d-pvc']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="2D PVC cloisonné" alt="2D PVC cloisonné" />
                        <div class="subtitle-pic">2D PVC cloisonné</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('node/13', ['query' => ['logo-process' => '3d-pvc']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="3D PVC cloisonné" alt="3D PVC cloisonné" />
                        <div class="subtitle-pic">3D PVC cloisonné</div>
                    </a>
                </div>
            </div>
        </div>
    </div><?php
    // retrieve posts
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'node')
            ->propertyCondition('status', 1)
            ->propertyCondition('type', 'news')
            ->propertyOrderBy('created', 'DESC')
            ->range(0, 6);
    $aResult = $oQuery->execute();
    if ($aResult) {
        $aNewsList = node_load_multiple(array_keys($aResult['node'])); ?>        
        <div class="col-md-12 margin-top-10 padding-0 news-content">
            <div class="col-xs-12 padding-0">
                <h3>News</h3>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6 border-right padding-0"><?php
                $iCounter = 1;
                foreach ($aNewsList as $oNews) { ?>
                    <div class="col-xs-12 news-row">
                        <a href="<?= url('node/'.$oNews->nid) ?>" title="">
                            <div class="col-sm-5 thumbnail margin-bottom-sm-10">
                                <img class="width-100" src="<?= file_create_url($oNews->field_news_thumbnail['und'][0]['uri']) ?>" title="<?= ($oNews->field_news_thumbnail['und'][0]['title'] ?: $oNews->title) ?>" alt="<?= ($oNews->field_news_thumbnail['und'][0]['alt'] ?: $oNews->title) ?>" />
                            </div>
                            <div class="col-sm-7 news-text">
                                <h4><?= $oNews->title ?></h4>
                                <p><?= substr(strip_tags($oNews->body['und'][0]['summary']), 0, 150).' [...]' ?></p>
                            </div>
                        </a>
                    </div><?php
                    if ($iCounter == 3) { ?>
                        </div>
                        <div class="col-md-6 padding-0"><?php
                    }
                    $iCounter++;
                } ?>
        </div><?php
    } ?>
            <div class="col-md-12 bold"><a class="pull-right" href="<?= url('node/23')?>"><span class="glyphicon glyphicon-arrow-right"></span> Read previous news</a></div>
</div>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="col-md-12 padding-0">
        <div id="carousel-home" class="carousel carousel-home slide" data-ride="carousel-home">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-home" data-slide-to="1" ></li>
                <li data-target="#carousel-home" data-slide-to="2" ></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <a href="search?line=metal-fridge-magnet-mfm" title="Metal fridge magnet #MFM line">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/mfm-line.jpg") ?>" alt="Metal fridge magnet #MFM line" title="Metal fridge magnet #MFM line" />
                        <div class="slide-text">Metal fridge magnet #MFM line</div>
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/331') ?>" title="Plastic glass holder badge and keychain #PKGH">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/pkgh.jpg") ?>" alt="Plastic glass holder badge and keychain #PKGH" title="Plastic glass holder badge and keychain #PKGH" />
                        <div class="slide-text">Plastic glass holder badge and keychain #PKGH</div>
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/328') ?>" title="Plastic cable organizer badge #PCW204">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/pcw.jpg") ?>" alt="Plastic cable organizer badge #PCW204" title="Plastic cable organizer badge #PCW204" />
                        <div class="slide-text">Plastic cable organizer badge #PCW204</div>
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/337') ?>" title="Doming patch with scratch #LPODD Line">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/lpodd-line.jpg") ?>" alt="Doming patch with scratch #LPODD Line" title="Doming patch with scratch #LPODD Line" />
                        <div class="slide-text">Doming patch with scratch #LPODD Line</div>
                    </a>
                </div>
                <div class="item">
                    <a href="search?line=doming-patch-with-scratch-lpodd" title="Doming magnet #MGODD">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/mgodd-line.jpg") ?>" alt="Doming magnet #MGODD" title="Doming magnet #MGODD" />
                        <div class="slide-text">Doming magnet #MGODD</div>
                    </a>
                </div>
                <div class="item">
                    <a href="<?= url('taxonomy/term/349') ?>" title="Plastic key hanger #PHM203">
                        <img src="<?= url(path_to_theme() . "/images/home/slider/phm.jpg") ?>" alt="Plastic key hanger #PHM203" title="Plastic key hanger #PHM203" />
                        <div class="slide-text">Plastic key hanger #PHM203</div>
                    </a>
                </div>
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
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-category">
                <div>
                    <a href="<?= url('search', ['query' => ['category' => 'metal-enamel']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/metal-enamel.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Metal enamel</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['category' => 'soft-pvc-cloisonne']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/pvc-cloisonne.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Soft PVC cloisonne</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['category' => 'aluminium']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/aluminium.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Aluminium</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['category' => 'plastic-injection']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/plastic-injection.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Plastic injection</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search-theme') ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/gift.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Gift & souvenirs</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2>Our product functions</h2>
    </div>
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-function">
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'keychain']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/keychain.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Keychain</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'bar-accessory']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/bar.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Bar - accessory</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'trolley-token']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/trolley-token.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Trolley token</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'wearable']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/wearable.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Wearable</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'canister-container']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/canister.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Canister and container</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => '3c-accessory']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/3c.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">3C accessory</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'tools']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/tools.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Tools</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['function' => 'stickers-and-magnet']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/stickers.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Stickers / Doming</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2>Our logo processes</h2>
    </div>
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-logo-process">
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'doming']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/doming.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Doming</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'digital-printing']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/digital-printing.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Digital printing</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'silk-screen-print']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/silk-screen-print.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">silk screen print</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'laser-engraving']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/laser.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Laser</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'offset-printing']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/offset-printing.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Offset printing</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'enamel']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/enamel.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Enamel</div>
                    </a>
                </div>
                <div>
                    <a href="<?= url('search', ['query' => ['logo-process' => 'pvc-cloisonne']]) ?>">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">PVC cloisonne</div>
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
                    <div class="col-xs-12 news-row border-md-bottom">
                        <a href="<?= url('node/'.$oNews->nid) ?>" title="">
                            <div class="col-sm-5 thumbnail margin-bottom-sm-10">
                                <img src="<?= file_create_url($oNews->field_news_thumbnail['und'][0]['uri']) ?>" title="<?= ($oNews->field_news_thumbnail['und'][0]['title'] ?: $oNews->title) ?>" alt="<?= ($oNews->field_news_thumbnail['und'][0]['alt'] ?: $oNews->title) ?>" />
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
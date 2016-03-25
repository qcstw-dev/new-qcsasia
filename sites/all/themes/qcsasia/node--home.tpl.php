<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <!--    <h2>Our promotional products lines</h2><?php displayCategories(); ?>
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
    echo '</ul>';
    ?>    -->
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
                    <img src="<?= url(path_to_theme() . "/images/home/slider/pkm.jpg") ?>" alt="" title="" />
                    <div class="slide-text">Plastic keychain tag with magnet #PKM205</div>
                </div>
                <div class="item">
                    <img src="<?= url(path_to_theme() . "/images/home/slider/zmr.jpg") ?>" alt="" title="" />
                    <div class="slide-text">Zamac multi-ring keychain #ZMR205</div>
                </div>
                <div class="item">
                    <img src="<?= url(path_to_theme() . "/images/home/slider/zum.jpg") ?>" alt="" title="" />
                    <div class="slide-text">Zamac coin holder keychain #ZUM01302</div>
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
        <h2 class="margin-0">Our product lines</h2>
    </div>
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-category">
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/metal-enamel.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Metal enamel</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/pvc-cloisonne.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Soft PVC cloisonne</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/aluminium.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Aluminium</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/plastic-injection.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Plastic injection</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/category/gift.jpg") ?>" alt="" title="" />
                        <div class="subtitle-pic">Gift</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2 class="margin-0">Our product functions</h2>
    </div>
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-function">
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/keychain.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Keychain</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/bar.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Bar - accessory</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/trolley-token.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Trolley token</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/wearable.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Wearable</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/canister.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Canister and container</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/3c.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">3C accessory</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/tools.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Tools</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/function/stickers.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Stickers / Doming</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-top-10 padding-0">
        <h2 class="margin-0">Our logo processes</h2>
    </div>
    <div class="col-md-12 border padding-0">
        <div class="col-md-12 padding-top-10 padding-right-50 padding-left-50">
            <div class="big-slick carousel-function">
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/doming.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Doming</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/digital-printing.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Digital printing</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/silk-screen-print.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">silk screen print</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/laser.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Laser</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/offset-printing.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Offset printing</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/enamel.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">Enamel</div>
                    </a>
                </div>
                <div>
                    <a href="#">
                        <img class="thumbnail" src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="" alt="" />
                        <div class="subtitle-pic">PVC cloisonne</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="col-md-12 padding-0">
            <div id="carousel-home-2" class="carousel carousel-home-2 slide" data-ride="carousel-home-2">
                <div class="carousel-inner" role="listbox">
                    <div class="block-line category item active">
                        <h2>Our product lines</h2>
                        <div class="col-md-12 block-line-content">
                            <div class="col-md-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/metal-enamel.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Metal enamel</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/pvc-cloisonne.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Soft PVC cloisonne</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/aluminium.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Aluminium</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/plastic-injection.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Plastic injection</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 block-line-content margin-top-20">
                            <div class="col-md-3 col-md-offset-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/gift/2.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Gift</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" title="">
                                    <div class="thumbnail">
                                        <div class="padding-0">
                                            <img src="<?= url(path_to_theme() . "/images/home/category/licence/2.jpg") ?>" alt="" title="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="subtitle-pic">Licence</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="block-line function item">
                        <h2>Our product functions</h2>
                        <div class="col-md-12 block-line-content margin-bottom-20">
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/keychain.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Keychain</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/bar.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Bar - accessory</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/trolley-token.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Trolley token</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/wearable.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Wearable</div>
                            </div>
                        </div>
                        <div class="col-md-12 block-line-content">
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/canister.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Canister and container</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/3c.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">3C accessory</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/tools.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Tools</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/function/stickers.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Stickers / Doming</div>
                            </div>
                        </div>
                    </div>
                    <div class="block-line logo-process item">
                        <h2>Our logo processes</h2>
                        <div class="col-md-12 block-line-content margin-bottom-20">
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/doming.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Doming</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/digital-printing.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Digital printing</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/silk-screen-print.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">silk screen print</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/laser.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Laser</div>
                            </div>
                        </div>
                        <div class="col-md-12 block-line-content">
                            <div class="col-md-3 col-md-offset-2">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/offset-printing.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Offset printing</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/enamel.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">Enamel</div>
                            </div>
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <img src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="" alt="" />
                                </div>
                                <div class="subtitle-pic">PVC cloisonne</div>
                            </div>
    
                        </div>
                    </div>
                </div>
                 Controls 
                <a class="left carousel-control" href="#carousel-home-2" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-home-2" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>-->
    <div class="col-md-12 padding-0 news-content">
        <div class="col-xs-12 padding-0">
            <h3>News</h3>
        </div>
        <div class="col-md-6 border-right padding-0">
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/logo-process/pvc-cloisonne.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/category/pvc-cloisonne.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/function/3c.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 padding-0">
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/function/keychain.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/function/bar.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
            <div class="col-md-12 news-row">
                <a href="#" title="">
                    <div class="col-md-3 thumbnail">
                        <img src="<?= url(path_to_theme() . "/images/home/function/trolley-token.jpg") ?>" title="" alt="" />
                    </div>
                    <div class="col-md-9 news-text">
                        <h4>Visit us at the Canton Fair 119th, Apr 23-27th, booth 11.1E26</h4>
                        <p>You are welcome to visit us at Canton fair 119th (Guangzhou) from April 23rd – 27th. Booth no. 11.1E26 Check out our new catalog 2016 !...</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6">

        </div>

    </div>
<!--    <div class="col-md-12"><?php
        $response_xml_data = file_get_contents("https://www.qcsasia.com/rss-posts/");
        $posts = simplexml_load_string($response_xml_data) or die("Error: Cannot create object");
        if ($posts) {
            ?>
            <div class="col-xs-12 padding-0">
                <h3>News</h3>
            </div>
            <div class="col-xs-12 padding-0 blocks qcs-news-block"><?php
                $i = 0;
                foreach ($posts as $post) {
                    ?>
                    <a href="<?= $post->url ?>" title="<?= $post->title ?>" >
                        <div class="col-sm-3">
                            <div class="col-xs-12 thumbnail margin-bottom-10">
                                <img src="<?= $post->thumbnail_url ?>" alt="<?= $post->title ?>" title="<?= $post->title ?>" />
                                <div class="subtitle-pic"><?= $post->title ?></div>
                            </div>
                        </div>
                    </a><?php
                    $i++;
                    if ($i == 4) {
                        break;
                    }
                }
                ?>
            </div><?php }
            ?>
    </div>-->
</div>
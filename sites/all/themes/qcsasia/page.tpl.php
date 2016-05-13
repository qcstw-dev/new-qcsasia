<div id="main-content" class="container"><?php if (isset($menu_top) && $menu_top): ?>
    <div id="header" class="row hidden-print">
        <div id="menu-top" class="col-xs-12 padding-0">
            <div class="col-md-6 visible-lg"><?php
                displaySocialMediaLogo() ?>
            </div>
            <div class="col-md-6 padding-0">
                <!--<div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-gb"></span> English <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="flag-icon flag-icon-cn"></span> Chinese</a></li>
                        <li><a href="#"><span class="flag-icon flag-icon-fr"></span> French</a></li>
                        <li><a href="#"><span class="flag-icon flag-icon-de"></span> German</a></li>
                        <li><a href="#"><span class="flag-icon flag-icon-es"></span> Spanish</a></li>
                    </ul>
                </div>--><?php
                print theme('links__system_menu_top', array(
                    'links' => menu_tree_all_data('menu-menu-top'),
                    'attributes' => array(
                        'id' => 'menu-top-links',
                        'class' => array('nav', 'nav-tabs'),
                    ),
                    'heading' => array(
                        'text' => t('Menu top'),
                        'level' => 'h2',
                        'class' => array('element-invisible'),
                    ),
                )); ?>
                </div>
            </div><?php endif;
            ?>
        <div id="banner" class="col-xs-12">
            <?php if ($logo): ?>
                <div id="logo" class="col-xs-12 col-sm-2 text-center">
                    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                    </a>
                </div>
            <?php endif; ?>
            <div id="title" class="hidden-xs col-sm-10">
                <?php if ($site_name) { ?>
                    <h1 class="col-xs-12 margin-top-10 main-title"><?php print $site_name ?><br /><span class="font-dfkai">台灣妍品禮贈品有限公司</span></h1><?php }
                ?>
                <?php if ($site_slogan) { ?>
                    <div class="col-xs-12">
                        <i><?php print $site_slogan ?><br /><span class="font-dfkai font-size-24">人生苦短，寧缺勿濫</span></i>
                    </div><?php } ?>
            </div>
        </div><?php if (isset($main_menu) && $main_menu): ?>
            <div id="menu" class="col-xs-12 padding-0"><?php
                print theme('links__system_main_menu', array(
                    'links' => menu_tree_all_data('main-menu'),
                    'attributes' => array(
                        'id' => 'main-menu-links',
                        'class' => array('nav', 'nav-tabs'),
                    ),
                    'heading' => array(
                        'text' => t('Main menu'),
                        'level' => 'h2',
                        'class' => array('element-invisible'),
                    ),
                ));
                ?>
            </div><?php endif;
            ?>
    </div>
    <div id="content" class="row">
        <?php if ($breadcrumb): ?>
            <ol class="breadcrumb hidden-print margin-top-10 margin-bottom-10"><?php print $breadcrumb; ?></ol>
        <?php endif; ?>
        <div class="col-xs-12 padding-0"><?php
            print render($page['content']);
            ?>
        </div>
    </div>
    <?php if ($page['footer']): ?>
            <div class="clearfix"></div>
        <div id="footer" class="col-xs-12">
            <?php print render($page['footer']); ?>
        </div>
    <?php endif; ?>
            <div class="clearfix"></div>
    <div class="margin-bottom-20">
        <div class="col-xs-offset-1 col-xs-2 thumbnail border-none">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/caefi.jpg" ?>" alt="caefi" title="caefi" />
        </div>

        <div class="col-xs-2 thumbnail border-none">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/eppa.jpg" ?>" alt="eppa" title="eppa" />
        </div>

        <div class="col-xs-2 thumbnail border-none">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/promota300.jpg" ?>" alt="promota" title="promota" />
        </div>

        <div class="col-xs-2 thumbnail border-none">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/sedex_trans.jpg" ?>" alt="sedex" title="sedex" />
        </div>
        <div class="col-xs-2 thumbnail border-none">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/PPAI-logo-QCS.jpg" ?>" alt="PPAI" title="PPAI" />
        </div>
    </div>
</div>
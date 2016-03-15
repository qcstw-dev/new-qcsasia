<div id="main-content" class="container"><?php 
    if (isset($menu_top) && $menu_top): ?>
        <div id="menu-top" class="col-xs-12"><?php
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
        </div><?php
    endif; ?>
    <div id="header" class="row hidden-print">
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
        </div><?php
        if (isset($main_menu) && $main_menu): ?>
            <div id="menu" class="col-xs-12 padding-xs-0"><?php
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
                )); ?>
            </div><?php 
        endif; ?>
    </div>
    <div id="content" class="col-xs-12 padding-0">
        <?php if ($breadcrumb): ?>
            <ol class="breadcrumb hidden-print"><?php print $breadcrumb; ?></ol>
            <?php endif; ?>
        <div class="col-xs-12 padding-0"><?php
//                  var_dump($page['content']['system_main']['nodes'][2]['#node']->metatags);
            print render($page['content']);
            ?>
        </div>
    </div>
        <?php if ($page['footer']): ?>
        <div id="footer" class="col-xs-12">
        <?php print render($page['footer']); ?>
        </div>
<?php endif; ?>
    <div class="margin-bottom-20">
        <div class="footer-logo min-width-15-percent" style="margin-left: 80px;">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/caefi.png" ?>">
        </div>

        <div class="footer-logo min-width-15-percent">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/eppa.png" ?>">
        </div>

        <div class="footer-logo min-width-10-percent">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/promota300.jpg" ?>">
        </div>

        <div class="footer-logo min-width-15-percent">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/sedex_trans.jpg" ?>">
        </div>
        <div class="footer-logo min-width-20-percent">
            <img src="<?= base_path() . path_to_theme() . "/images/footer/PPAI-logo-QCS.jpg" ?>">
        </div>
    </div>
</div>
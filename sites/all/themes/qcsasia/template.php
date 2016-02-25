<?php

function qcsasia_links__system_main_menu($variables) {
    if ($variables['links']) {
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid padding-sm-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand visible-xs">Menu</span>
                </div>
                <div class="navbar-collapse collapse padding-sm-0" id="bs-example-navbar-collapse-1" aria-expanded="false">
                    <ul class="nav navbar-nav"><?php foreach ($variables['links'] as $link) { ?>
                            <li class="<?= ($link['below'] ? 'dropdown' : '') ?><?= (($_SERVER["REQUEST_URI"] === url($link['link']['link_path']) && $link['link']['href'] != '<front>') ? ' active' : '') ?>">
                                <a <?= ($link['below'] ? 'role="button" aria-haspopup="true" aria-expanded="false"' : '') ?> href="<?= url($link['link']['link_path']) ?>" >
                                    <?= $link['link']['link_title'] ?>
                                </a><?php if ($link['below']) { ?>
                                    <ul class="dropdown-menu hidden-xs"><?php
                                        foreach ($link['below'] as $below) {
                                            if (isset($below['link'])) { ?>
                                                <li>
                                                    <a href="<?= url($below['link']['link_path']) .(isset($below['link']['localized_options']['query']) ? "?" . drupal_http_build_query($below['link']['localized_options']['query']) : '') ?>"><?= $below['link']['link_title'] ?></a>
                                                </li><?php
                                            }
                                        }
                                        ?>
                                    </ul><?php }
                                    ?>
                            </li><?php }
                                ?>
                    </ul>
                </div>
            </div>
        </nav><?php
    }
}

function qcsasia_breadcrumb($variables) {
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        $sNormalPath = drupal_get_normal_path(current_path());
        if (strchr($sNormalPath, "taxonomy")) {
            $sTermId = substr($sNormalPath, 14);
            $oTerm = taxonomy_term_load($sTermId);
            switch ($oTerm->vocabulary_machine_name) {
                case 'product': 
                    $oCategory = taxonomy_term_load($oTerm->field_category['und'][0]['tid']);
                    $breadcrumb[] = '<a href="'.url('taxonomy/term/'.$oCategory->tid).'">'.$oCategory->name.'</a>';
                    break;
                case 'category':
                    $breadcrumb[] = '<a href="'.url('products').'">Promotional products</a>';
                    break;
            }
        }
        $title = drupal_get_title();
        if (!empty($title)) {
            $breadcrumb[] = $title;
        }
        // Provide a navigational heading to give context for breadcrumb links to
        // screen-reader users. Make the heading invisible with .element-invisible.
        $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

        $output = implode(' » ', $breadcrumb);
        return $output;
    }
}

function qcsasia_preprocess_page(&$vars) {
    // delete eror message no content for term
    if (isset($vars['page']['content']['system_main']['no_content'])) {
        unset($vars['page']['content']['system_main']['no_content']);
    }
}

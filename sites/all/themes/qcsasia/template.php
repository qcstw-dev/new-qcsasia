<?php

function retrieveCategories($iStart = null, $iLength = null) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'category')
            ->range(($iStart ? : 0), ($iLength ? : 6));

    $aResult = $oQuery->execute();
    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
}

function displayCategories($iStart = null, $iLength = null) {
    $aCategories = retrieveCategories($iStart = null, $iLength = null);
    include 'categories_list.tpl.php';
}

function retrieveProducts($oTerm = null, $iStart = null, $iLength = null) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->range(($iStart ? : 0), ($iLength ? : 5));
    if ($oTerm) {
        $oQuery->fieldCondition('field_category', 'tid', $oTerm->tid);
    }
    $aResult = $oQuery->execute();

    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
}

function displayProducts($oTerm = null, $iStart = null, $iLength = null) {
    $aProducts = retrieveProducts($oTerm, $iStart = null, $iLength = null);
    include 'products_list.tpl.php';
}

function qcsasia_links__system_menu_top($variables) {
    if ($variables['links']) {
        ?>
        <ul class="menu-list pull-right"><?php foreach ($variables['links'] as $link) { ?>
                <li class="border-left">
                    <a href="<?= url($link['link']['link_path']) ?>" >
                        <?= $link['link']['link_title'] ?>
                    </a>
                </li><?php }
                    ?>
        </ul><?php
    }
}

function qcsasia_links__system_main_menu($variables) {
    if ($variables['links']) {
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid padding-sm-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-main-menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand visible-xs">Menu</span>
                </div>
                <div class="navbar-collapse collapse padding-sm-0" id="navbar-collapse-main-menu" aria-expanded="false">
                    <ul class="nav navbar-nav"><?php foreach ($variables['links'] as $link) { ?>
                            <li class="<?= ($link['below'] ? 'dropdown' : '') ?><?= (($_SERVER["REQUEST_URI"] === url($link['link']['link_path']) && $link['link']['href'] != '<front>') ? ' active' : '') ?>">
                                <a <?= ($link['below'] ? 'role="button" aria-haspopup="true" aria-expanded="false"' : '') ?> href="<?= url($link['link']['link_path']) ?>" >
                                    <?= $link['link']['link_title'] ?>
                                </a><?php if ($link['below']) { ?>
                                    <ul class="dropdown-menu hidden-xs"><?php
                                        foreach ($link['below'] as $below) {
                                            if (isset($below['link'])) {
                                                ?>
                                                <li>
                                                    <a href="<?= url($below['link']['link_path']) . (isset($below['link']['localized_options']['query']) ? "?" . drupal_http_build_query($below['link']['localized_options']['query']) : '') ?>"><?= $below['link']['link_title'] ?></a>
                                                </li><?php
                                            }
                                        }
                                        ?>
                                    </ul><?php }
                                    ?>
                            </li><?php }
                                ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right search-form-content">
                        <li><form><input class="margin-right-md-10" type="text" /><button class="btn btn-primary" type="submit">Search</button></form></li>
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
                    $breadcrumb[] = '<a href="' . url('taxonomy/term/' . $oCategory->tid) . '">' . $oCategory->name . '</a>';
                    break;
                case 'category':
                    $breadcrumb[] = '<a href="' . url('products') . '">Promotional products</a>';
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

function qcsasia_preprocess_node(&$vars) {
    switch ($vars['node']->type) {
        case 'products_list' :
            $aProducts = getProducts();
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));
            break;
    }
}

function getProducts() {
    // retrieve products
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->fieldOrderBy('field_date_gmt', 'value', 'DESC')
            ->range(0, 200);

    if (drupal_get_query_parameters()) {
        foreach (drupal_get_query_parameters() as $sKey => $sValue) {
            switch ($sKey) {
                case 'new':
                    $oQuery->fieldCondition('field_new_product', 'value', '1');
                    break;
                case 'cheap':
                    $oQuery->fieldCondition('field_cheap_item', 'value', '1');
                    break;
                case 'patented':
                    $oQuery->fieldCondition('field_patented_item', 'value', '1');
                    break;
                case 'category':
                    $oCategory = taxonomy_get_term_by_name($sValue);
                    $oQuery->fieldCondition('field_category', 'tid', $oCategory->tid);
                    break;
            }
        }
    }

    $aResult = $oQuery->execute();

    return $aResult['taxonomy_term'];
}

function qcsasia_preprocess_page(&$vars) {
    // delete eror message no content for term
    if (isset($vars['page']['content']['system_main']['no_content'])) {
        unset($vars['page']['content']['system_main']['no_content']);
    }

    $vars['menu_top'] = theme('links', array('links' => menu_navigation_links('menu-menu-top')));
}

function qcsasia_preprocess_html(&$vars) {
    header('HTTP/1.1 200 OK');
    switch ($vars['theme_hook_suggestions'][0]) {
        case 'html__products_ajax' :
            $aProducts = getProducts();
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));
            break;
    }
}

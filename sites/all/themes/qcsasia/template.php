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
            // retrieve products
            $aProducts = getProducts(drupal_get_query_parameters());
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));

            // retrieve potential number for filters
            $vars['aFilterNumProducts'] = getPotentialNumberForFilters();
            break;
    }
}

function getPotentialNumberForFilters() {
    // retrieve potential number for filters
    //get all filters
    $aAllFilters = ['new', 'cheap', 'patented'];
    foreach (retrieveFilters('category') as $oTerm) {
        $aAllFilters['category'][] = $oTerm->field_reference['und'][0]['value'];
    }
    foreach (retrieveFilters('function') as $oTerm) {
        $aAllFilters['function'][] = $oTerm->field_reference['und'][0]['value'];
    }
    foreach (retrieveFilters('logo_process') as $oTerm) {
        $aAllFilters['logo-process'][] = $oTerm->field_reference['und'][0]['value'];
    }
    $aCurrentFilters = drupal_get_query_parameters();
    $aFiltersPotential = [];
    foreach ($aAllFilters as $sKey => $mValue) {
        if (is_array($mValue)) {
            foreach ($mValue as $sValue) {
                $aFiltersPotential = $aCurrentFilters;
                if (!isset($aCurrentFilters[$sKey]) || !in_array($sValue, $aCurrentFilters[$sKey])) {
                    $aFiltersPotential[$sKey][] = $sValue;
                    $aFilterNumProducts[$sKey][$sValue] = getProducts($aFiltersPotential, true);
                }
            }
        } else {
            if (!in_array($mValue, $aCurrentFilters)) {
                $aFiltersPotential = $aCurrentFilters;
                $aFiltersPotential[$mValue] = '';
                $aFilterNumProducts[$mValue] = getProducts($aFiltersPotential, true);
            }
        }
    }
    return $aFilterNumProducts;
}

function getProducts($aQueryParameters, $bCount = false) {
    // retrieve products
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->fieldOrderBy('field_date_gmt', 'value', 'DESC')
            ->range(0, 200);

    if ($aQueryParameters) {
        foreach ($aQueryParameters as $sKey => $mValue) {
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
                    // Rettrieve the category
                    $aCategories = getTermByRef($mValue, 'category');
                    $aChildrenCategories = [];
                    foreach ($aCategories as $oCategory) {
                        // retrieve children categories
                        $aChildrenCategories = taxonomy_get_children($oCategory->tid);
                        if ($aChildrenCategories) {
                            foreach ($aChildrenCategories as $oChildrenCategory) {
                                $aCategories[$oChildrenCategory->tid] = $oChildrenCategory;
                            }
                        }
                    }
                    $oQuery->fieldCondition('field_category', 'tid', array_keys($aCategories));
                    break;
                case 'function':
                    $aFunctions = getTermByRef($mValue, 'function');
                    $oQuery->fieldCondition('field_function', 'tid', array_keys($aFunctions));
                    break;
                case 'logo-process':
                    $aLogoProcesses = getTermByRef($mValue, 'logo_process');
                    $oQuery->fieldCondition('field_logo_process', 'tid', array_keys($aLogoProcesses));
                    break;
            }
        }
    }
    if ($bCount) {
        return $oQuery->count()->execute();
    } else {
        $aResult = $oQuery->execute();
        return $aResult['taxonomy_term'];
    }
}

function qcsasia_preprocess_page(&$vars) {
    // delete eror message no content for term
    if (isset($vars['page']['content']['system_main']['no_content'])) {
        unset($vars['page']['content']['system_main']['no_content']);
    }

    $vars['menu_top'] = theme('links', array('links' => menu_navigation_links('menu-menu-top')));
}

/**
 * 
 * @return array Main Category term object (that has children)
 */
function retrieveFilters($sType) {
    $aFilters = [];
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', $sType)
            ->range(0, 200);
    $aResult = $oQuery->execute();
    if ($sType === 'category') {
        foreach ($aResult['taxonomy_term'] as $oTerm) {
            if (taxonomy_get_children($oTerm->tid)) {
                $aFilters[] = $oTerm->tid;
            }
        }
    } else {
        $aFilters = array_keys($aResult['taxonomy_term']);
    }
    return taxonomy_term_load_multiple($aFilters);
}

/**
 * 
 * @param multiple (array or string) $mReferences
 * @return Object Term
 */
function getTermByRef($mReferences, $sType) {
    $aReferences = [];
    if (!is_array($mReferences)) {
        $aReferences[] = $mReferences;
    } else {
        $aReferences = $mReferences;
    }
    $oQueryTerm = new EntityFieldQuery();
    $oQueryTerm->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', $sType)
            ->fieldCondition('field_reference', 'value', $aReferences)
            ->range(0, count($aReferences));

    $aTermResult = $oQueryTerm->execute();
    $aTermsIds = [];
    foreach ($aTermResult['taxonomy_term'] as $oTerm) {
        $aTermsIds[] = $oTerm->tid;
    }
    return taxonomy_term_load_multiple($aTermsIds);
}

function qcsasia_preprocess_html(&$vars) {
    header('HTTP/1.1 200 OK');
    switch ($vars['theme_hook_suggestions'][0]) {
        case 'html__products_ajax' :
            $aProducts = getProducts(drupal_get_query_parameters());
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));
            break;
        case 'html__products_number_ajax' :
            $vars['aFilterNumProducts'] = getPotentialNumberForFilters();
            break;
    }
}

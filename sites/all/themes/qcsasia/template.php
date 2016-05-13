<?php

function displaySocialMediaLogo() { ?>
    <div class="block-social-network">
        <div class="social-network"><a href="https://www.facebook.com/pages/QCS-ASIA/182231511328?fref=ts"><span class="icomoon-facebook2"></span></a></div>
        <div class="social-network"><a href="https://plus.google.com/105432120660907122700/posts?hl=fr&partnerid=gplp0"><span class="icomoon-google-plus2"></span></a></div>
        <div class="social-network"><a href="http://www.linkedin.com/company/qcs-asia-co.-ltd"><span class="icomoon-linkedin"></span></a></div>
<!--        <div class="social-network"><a href=""><span class="icomoon-twitter"></span></a></div>
        <div class="social-network"><a href=""><span class="icomoon-pinterest"></span></a></div>-->
    </div><?php
}

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

//function displayProducts($oTerm = null, $iStart = null, $iLength = null) {
//    $aProducts = retrieveProducts($oTerm, $iStart = null, $iLength = null);
//    include 'products_list.tpl.php';
//}

function qcsasia_links__system_menu_top($variables) {
    if ($variables['links']) {
        ?>
        <nav class="navbar navbar-default navbar-top">
            <div class="container-fluid padding-sm-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-menu-top" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <div class="visible-xs visible-sm pull-left margin-left-xs-20 margin-top-10"><?= displaySocialMediaLogo() ?></div>
                </div>
                <div class="navbar-collapse collapse padding-xs-0 padding" id="navbar-collapse-menu-top" aria-expanded="false">
                    <ul class="menu-list menu-list"><?php foreach ($variables['links'] as $link) { ?>
                            <li>
                                <a href="<?= url($link['link']['link_path']) ?>" >
                                    <?= $link['link']['link_title'] ?>
                                </a>
                            </li><?php }
                                ?>
                    </ul>
                </div>
            </div>
        </nav><?php
        /*
          ?>
          <ul class="menu-list pull-right"><?php
          foreach ($variables['links'] as $link) { ?>
          <li class="border-left">
          <a href="<?= url($link['link']['link_path']) ?>" >
          <?= $link['link']['link_title'] ?>
          </a>
          </li><?php
          } ?>
          </ul><?php */
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
                <div class="navbar-collapse collapse" id="navbar-collapse-main-menu" aria-expanded="false">
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
                                    </ul><?php } ?>
                            </li><?php } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right search-form-content">
                        <li><form action="/search" method="get"><input class="margin-right-xs-10" placeholder="Search Products" name="keyword" type="text" autocomplete="off" /><button class="btn btn-primary" type="submit">Search</button></form></li>
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
                    $aCategoryParents = taxonomy_get_parents($oCategory->tid);
                    if ($aCategoryParents) {
                        foreach ($aCategoryParents as $oCategoryParent) {
                            $breadcrumb[] = '<a href="' . url('search', ['query' => ['category' => $oCategoryParent->field_reference['und'][0]['value']]]) . '">' . $oCategoryParent->field_category_title['und'][0]['value'] . '</a>';
                        }
                    }
                    $breadcrumb[] = '<a href="' . url('search', ['query' => ['category' => $oCategory->field_reference['und'][0]['value']]]) . '">' . $oCategory->field_category_title['und'][0]['value'] . ' ' . $oCategory->field_category_reference['und'][0]['value'] . '</a>';
                    break;
                case 'category':
                    $breadcrumb[] = '<a href="' . url('products') . '">Promotional products</a>';
                    break;
                case 'theme':
                    $breadcrumb[] = '<a href="' . url('search-theme') . '">Themes</a>';
                    break;
            }
        } else if (strchr($sNormalPath, "node")) {
            $sNodeId = substr($sNormalPath, 5);
            $aNode = entity_load('node', [$sNodeId]);
            if ($aNode[$sNodeId]->type == 'news') {
                $breadcrumb[] = '<a href="' . url('node/23') . '">News</a>';
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
        case 'search_products' :
            // retrieve products
            $aProducts = getProducts(drupal_get_query_parameters());
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));

            // retrieve potential number for filters
            $vars['aFilterNumProducts'] = getPotentialNumberForFilters();
            break;
        case 'search_gifts' :
            // retrieve gifts
            $aGifts = getGifts(drupal_get_query_parameters());
            $vars['aGifts'] = taxonomy_term_load_multiple(array_keys($aGifts));
            break;
        case 'search_themes' :
            // retrieve gifts
            $aGifts = getGifts();
            $vars['aGifts'] = taxonomy_term_load_multiple(array_keys($aGifts));
            $aThemes = getThemes(drupal_get_query_parameters());
            $vars['aThemes'] = taxonomy_term_load_multiple(array_keys($aThemes));
            break;
    }
}

function getPotentialNumberForFilters() {
    // retrieve potential number for filters
    //get all filters
    $aAllFilters = ['new', 'cheap', 'patented', 'rush'];
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

    $iNumberProducts = getProducts($aCurrentFilters, true);
    foreach ($aAllFilters as $sKey => $mValue) {
        if (is_array($mValue)) {
            foreach ($mValue as $sValue) {
                $aFiltersPotential = $aCurrentFilters;
                if (!isset($aCurrentFilters[$sKey]) || !in_array($sValue, $aCurrentFilters[$sKey])) {
                    if (isset($aFiltersPotential[$sKey]) && count($aFiltersPotential[$sKey]) > 1) {
                        $aFiltersPotential[$sKey][] = $sValue;
                    } else {
                        $aFiltersPotential[$sKey] = $sValue;
                    }
                    $iNumberProductFiltrated = getProducts($aFiltersPotential, true);
                    $aFilterNumProducts[$sKey][$sValue] = ($iNumberProductFiltrated > $iNumberProducts ? $iNumberProductFiltrated - $iNumberProducts : $iNumberProductFiltrated);
                }
            }
        } else {
            if (!in_array($mValue, $aCurrentFilters)) {
                $aFiltersPotential = $aCurrentFilters;
                $aFiltersPotential[$mValue] = '';
                $iNumberProductFiltrated = getProducts($aFiltersPotential, true);
                $aFilterNumProducts[$mValue] = ($iNumberProductFiltrated > $iNumberProducts ? $iNumberProductFiltrated - $iNumberProducts : $iNumberProductFiltrated);
            }
        }
    }
    return $aFilterNumProducts;
}
function getAddons() {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'add_on');

    $aResult = $oQuery->execute();
    if ($aResult) {
        return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
    } else {
        return false;
    }
}
function retrieveDisplayByRefMultiple ($aRef){
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'display')
            ->fieldCondition('field_display_ref', 'value', $aRef);

    $aResult = $oQuery->execute();
    if ($aResult) {
        return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
    } else {
        return false;
    }
}
function retrieveDisplayByRef ($sRef){
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'display')
            ->fieldCondition('field_display_ref', 'value', $sRef);

    $aResult = $oQuery->execute();
    if ($aResult) {
        return taxonomy_term_load(strval(array_shift($aResult['taxonomy_term'])->tid));
    } else {
        return false;
    }
}

function getGifts($aQueryParameters = null) {
    // retrieve gifts
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'gift')
            ->fieldOrderBy('field_product_name', 'value', 'ASC');

    $aResult = $oQuery->execute();
    $aGifts = $aResult['taxonomy_term'];

    if ($aQueryParameters) {
        reset($aQueryParameters);
        switch (key($aQueryParameters)) {
            case 'theme':
                // retrieve theme
                $oTheme = array_shift(getTermByRef($aQueryParameters['theme'], 'theme'));
                break;
            case 'display':
                $oDisplay = array_shift(getTermByRef($aQueryParameters['display'], 'display'));
                break;
        }
    }

    $aGiftToDisplay = [];
    if (isset($oTheme) || isset($oDisplay)) {
        if (isset($oTheme)) {
            foreach ($aGifts as $oGift) {
                $oGiftEntity = taxonomy_term_load($oGift->tid);
                $aFieldCollections = [];
                foreach ($oGiftEntity->field_gift_theme['und'] as $oGiftEntityFieldTheme) {
                    $aFieldCollections[] = field_collection_item_load($oGiftEntityFieldTheme['value']);
                }
                foreach ($aFieldCollections as $aFieldCollection) {
                    if ($aFieldCollection->field_theme && ($oTheme->tid == $aFieldCollection->field_theme['und'][0]['tid'])) {
                        $aGiftToDisplay[$oGiftEntity->tid] = $oGiftEntity;
                        break;
                    }
                }
            }
        }
        if (isset($oDisplay)) {
            foreach ($aGifts as $oGift) {
                $oGiftEntity = taxonomy_term_load($oGift->tid);
                $aFieldCollections = [];
                foreach ($oGiftEntity->field_gift_display['und'] as $oGiftEntityFieldDisplay) {
                    $aFieldCollections[] = field_collection_item_load($oGiftEntityFieldDisplay['value']);
                }
                foreach ($aFieldCollections as $aFieldCollection) {
                    if ($aFieldCollection->field_display && $oDisplay->tid == $aFieldCollection->field_display['und'][0]['tid']) {
                        $aGiftToDisplay[$oGiftEntity->tid] = $oGiftEntity;
                        break;
                    }
                }
            }
        }
    } else {
        $aGiftToDisplay = $aResult['taxonomy_term'];
    }
    return $aGiftToDisplay;
}

function getThemes($aQueryParameters) {
    // retrieve themes
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'theme');

    if ($aQueryParameters && isset($aQueryParameters['gift'])) {
//            $oQuery->fieldCondition('field_gift', 'tid', (is_array($aQueryParameters['gift']) ? array_values($aQueryParameters['gift']) : $aQueryParameters['gift']));
//        $oQuery->fieldCondition('field_theme_gift', 'field_gift', (is_array($aQueryParameters['gift']) ? array_values($aQueryParameters['gift']) : $aQueryParameters['gift']));
        $inner = new EntityFieldQuery();
        $inner_r = $inner->entityCondition('entity_type', 'field_collection_item')
                ->entityCondition('bundle', 'field_theme_gift')
                ->fieldCondition('field_gift', 'tid', (is_array($aQueryParameters['gift']) ? array_values($aQueryParameters['gift']) : $aQueryParameters['gift']))
                ->execute();

        $aFieldCollections = entity_load('field_collection_item', array_keys($inner_r['field_collection_item']));
        if ($aFieldCollections) {
            // retrieve themes
            $oQuery->fieldCondition('field_theme_gift', 'value', array_keys($aFieldCollections));
        }
    }
    $aResult = $oQuery->execute();
    return $aResult['taxonomy_term'];
}

function getProducts($aQueryParameters, $bCount = false) {
    // retrieve products
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->fieldOrderBy('field_date_gmt', 'value', 'DESC')
            ->fieldCondition('field_old_id', 'value', NULL, 'IS NOT NULL');
    if ($aQueryParameters) {
        foreach ($aQueryParameters as $sKey => $mValue) {
            switch ($sKey) {
                case 'keyword':
                    $sKeyword = $mValue;
                        $oQuery->propertyCondition('name', $sKeyword, 'CONTAINS');
//                    preg_match('/(#[a-zA-Z0-9]+)/', $sKeyword, $matches);
//                    if ($matches) {
//                        $oQuery->fieldCondition('field_product_ref', 'value', $sKeyword, 'CONTAINS');
//                    } else {
//                        $oQuery->fieldCondition('field_product_name', 'value', $sKeyword, 'CONTAINS');
//                    }
//                    $mValue = explode(' ', $mValue);
//                    foreach ($mValue as $sKeyword) {
//                        preg_match('/(#[a-zA-Z0-9]+)/', $sKeyword, $matches);
//                        if ($matches) {
//                            $oQuery->fieldCondition('field_product_ref', 'value', $sKeyword, 'CONTAINS');
//                        } else {
//                            $oQuery->fieldCondition('field_description', 'value', $sKeyword, 'CONTAINS');
//                        }
//                    }
                    break;
                case 'new':
                    $oQuery->fieldCondition('field_new_product', 'value', '1');
                    break;
                case 'cheap':
                    $oQuery->fieldCondition('field_cheap_item', 'value', '1');
                    break;
                case 'patented':
                    $oQuery->fieldCondition('field_patent', 'value', '', '<>');
                    break;
                case 'rush':
                    $oQuery->fieldCondition('field_rush', 'value', '1');
                    break;
                case 'category':
                    // Rettrieve the category
                    $mCategories = getTermByRef($mValue, 'category');
                    $aCategoriesBis = [];
                    if (!is_array($mCategories)) {
                        $aCategoriesBis[] = $mCategories;
                    } else {
                        $aCategoriesBis = $mCategories;
                    }
                    $aChildrenCategories = [];
                    foreach ($aCategoriesBis as $oCategory) {
                        // retrieve children categories
                        $aChildrenCategories = taxonomy_get_children($oCategory->tid);
                        if ($aChildrenCategories) {
                            foreach ($aChildrenCategories as $oChildrenCategory) {
                                $aCategoriesBis[$oChildrenCategory->tid] = $oChildrenCategory;
                            }
                        } else {
                            $aCategoriesBis[$oChildrenCategory->tid] = $oChildrenCategory;
                        }
                    }
                    $oQuery->fieldCondition('field_category', 'tid', array_keys($aCategoriesBis));
                    break;
                case 'function':
                    $aFunctions = getTermByRef($mValue, 'function');
                    $oQuery->fieldCondition('field_function', 'tid', array_keys($aFunctions));
                    break;
                case 'logo-process':
                    $aLogoProcesses = getTermByRef($mValue, 'logo_process');
                    $inner = new EntityFieldQuery();
                    $inner_r = $inner->entityCondition('entity_type', 'field_collection_item')
                            ->entityCondition('bundle', 'field_logo_process_block')
                            ->fieldCondition('field_logo_process', 'tid', array_keys($aLogoProcesses))
                            ->execute();
                    $aFieldCollections = entity_load('field_collection_item', array_keys($inner_r['field_collection_item']));
                    if ($aFieldCollections) {
                        // retrieve logo
                        $oQuery->fieldCondition('field_logo_process_block', 'value', array_keys($aFieldCollections));
                    }


//                    $oQuery->fieldCondition('field_logo_process', 'tid', array_keys($aLogoProcesses));
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

function getLineProductThumbnails($sLineCategoryTid) {
    $aThumbnailsUrl = [];
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->fieldCondition('field_category', 'tid', $sLineCategoryTid)
            ->range(0, 4);
    $aResults = $oQuery->execute();
    foreach ($aResults['taxonomy_term'] as $oProduct) {
        $aThumbnailsUrl[] = taxonomy_term_load($oProduct->tid)->field_thumbnail['und'][0]['uri'];
    }
    return $aThumbnailsUrl;
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
            ->entityCondition('bundle', $sType);
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
    if (count($aTermsIds) == 1) {
        $aTermsIds = [$aTermsIds[0] => $aTermsIds[0]];
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
        case 'html__themes_ajax' :
            $aThemes = getThemes(drupal_get_query_parameters());
            $vars['aThemes'] = taxonomy_term_load_multiple(array_keys($aThemes));
            break;
        case 'html__products_number_ajax' :
            $vars['aFilterNumProducts'] = getPotentialNumberForFilters();
            break;
    }
}

function displayDocumentCenter($term) {
    $iCounter = 1;
    $aIdDocumentsGroupsEntities = [];
    foreach ($term->field_group_document['und'] as $aGroupDocument) {
        $aIdDocumentsGroupsEntities[] = $aGroupDocument['value'];
    }
    $oFieldDocumentsGroups = entity_load('field_collection_item', $aIdDocumentsGroupsEntities);
    foreach ($oFieldDocumentsGroups as $oFieldDocumentsGroup) {
        if (count($term->field_group_document['und']) > 2 && $iCounter == 1) {
            ?>
            <div class="col-sm-6 border-sm-right"><?php }
        ?>
            <div class="list-title" data-id-doc="1"><span class="glyphicon glyphicon-<?= (strpos(strtolower($oFieldDocumentsGroup->field_group_document_title['und'][0]['value']), 'picture') !== false ? 'picture' : 'file') ?>"></span> <?= $oFieldDocumentsGroup->field_group_document_title['und'][0]['value'] ?></div><?php
            $aIdDocumentsEntities = [];
            foreach ($oFieldDocumentsGroup->field_document['und'] as $aDocument) {
                $aIdDocumentsEntities[] = $aDocument['value'];
            }
            $oFieldDocuments = entity_load('field_collection_item', $aIdDocumentsEntities);
            if ($oFieldDocuments) {
                ?>
                <ul class="list-doc"><?php foreach ($oFieldDocuments as $oFieldDocument) { ?>
                        <li><a target="blank" href="<?= str_replace("www", "dl", $oFieldDocument->field_document_link['und'][0]['value']) ?>"><span class="glyphicon glyphicon-<?= (strpos(strtolower($oFieldDocument->field_document_title['und'][0]['value']), 'picture') !== false ? 'picture' : 'download-alt') ?>"></span> <?= getNameFromDocument($oFieldDocument->field_document_link['und'][0]['value']) ?></a></li><?php }
                ?>
                </ul><?php
            }
            if ($iCounter == 2) {
                ?>
            </div>
            <div class="col-sm-6"><?php
            }
            if (count($term->field_group_document['und']) == $iCounter) {
                ?>
            </div><?php
        }
        $iCounter++;
    }
}

function getNameFromDocument($file) {
    $file = str_replace("?dl=0", "", $file);

    $tab = explode("/", $file);

    $name = str_replace("%20", " ", $tab[count($tab) - 1]);

    $name = urldecode($name);

    $name = str_replace("?m=", " ", $name);

    return $name;
}

function displayOption($aImageOption) {
    $aImageOptionEntity = array_shift(entity_load('field_collection_item', [$aImageOption['value']])); ?>
    <div class="col-sm-3 margin-bottom-10 block-option">
        <div class="thumbnail margin-bottom-0">
            <img src="<?= file_create_url($aImageOptionEntity->field_image_option_img['und'][0]['uri']) ?>" alt="<?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?>" title="<?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?>" />
        </div>
        <div class="subtitle-pic"><?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?></div>
    </div><?php
}

function getLogoProcesses ($oTerm) {
    $aIds = [];
    $aLogoProcess = [];
    if (isset($oTerm->field_logo_process_block['und'])) {
        foreach ($oTerm->field_logo_process_block['und'] as $aLogoProcessBlock) {
            $aIds[] = $aLogoProcessBlock['value'];
        }
        foreach ($aIds as $sId) {
            $oFieldLogoProcess = array_values(entity_load('field_collection_item', [$sId]))[0];
            if (isset($oFieldLogoProcess->field_logo_process['und'][0]['tid'])) {
                $oLogoProcess = taxonomy_term_load($oFieldLogoProcess->field_logo_process['und'][0]['tid']);
                $sRefLogoProcess = isset($oLogoProcess->field_reference['und'][0]['value']) ? $oLogoProcess->field_reference['und'][0]['value'] : '';
                $aLogoProcess[$sRefLogoProcess]['id'] = $oLogoProcess->tid;
                $aLogoProcess[$sRefLogoProcess]['thumbnail'] = isset($oFieldLogoProcess->field_logo_process_thumbnail['und'][0]['uri']) ? $oFieldLogoProcess->field_logo_process_thumbnail['und'][0]['uri'] : '';
                $aLogoProcess[$sRefLogoProcess]['large'] = isset($oFieldLogoProcess->field_logo_process_large_picture['und'][0]['uri']) ? $oFieldLogoProcess->field_logo_process_large_picture['und'][0]['uri'] : '';
            }
        }
    }
     return $aLogoProcess;
}

function displayLogoProcess($term) { ?>
    <div class="col-md-12"><?php
        $aLogoProcesses = getLogoProcesses($term);
        $bIssetDoming = isset($aLogoProcesses['doming']);
        displayLogoProcessBlock(($bIssetDoming ? $aLogoProcesses['doming'] : array_shift($aLogoProcesses))); ?>
    </div><?php
    if (count($aLogoProcesses) > 1) { ?>
        <div class="col-md-12 hidden-text-area"><?php
        $count = 0;
            foreach ($aLogoProcesses as $key => $aLogoProcess) {
                if (($bIssetDoming && $key != 'doming') || (!$bIssetDoming && $count > 1 )) { ?>
                    <div class="col-md-12 padding-0"><?php
                        displayLogoProcessBlock($aLogoProcess); ?>
                    </div><?php
                } 
                $count++;
            } ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 padding-0">
            <div class="btn-show-hide-text-area"><span class="glyphicon glyphicon-menu-down"></span> More logo processes <span class="glyphicon glyphicon-menu-down"></span></div>
        </div>
        <div class="clearfix"></div><?php
    }
}


function displayLogoProcessBlock($aLogoProcess) {
    $oLogoProcess = taxonomy_term_load($aLogoProcess['id']);
    $bComplicatedDisplay = $aLogoProcess['thumbnail'];
    $bLargePicture = $aLogoProcess['large'];
    if ($bComplicatedDisplay) { ?>
        <div class="col-sm-3 thumbnail margin-top-20 <?= ($bLargePicture ? 'pointer event-enlarge' : '') ?>">
            <img src="<?= file_create_url($aLogoProcess['thumbnail']) ?>" <?= ($bLargePicture ? 'data-large-picture="'.file_create_url($aLogoProcess['large']).'"' : '') ?> alt="<?= $oLogoProcess->name ?>" title="<?= $oLogoProcess->name ?>" />
        </div><?php 
    } ?>
    <div class="<?= $bComplicatedDisplay ? 'col-sm-9' : 'col-sm-12' ?> padding-xs-0">
        <h3 class=""><?= $oLogoProcess->name ?></h3>
        <div class="col-md-7 margin-bottom-sm-10">
            <?= $oLogoProcess->field_logo_process_description['und'][0]['value'] ?>
        </div>
        <div class="col-md-5">
            <?= $oLogoProcess->field_youtube_video['und'][0]['value'] ?>
        </div>
    </div><?php
}

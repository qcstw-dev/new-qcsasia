<?php
function wishlistExist($sId) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'wishlist')
            ->propertyCondition('tid', $sId, '=');
          
    if ($oQuery->execute()['taxonomy_term']) {
        return true;
    } else {
        return false;
    }
}
function createWishlist () {
    // create wishlist
    $oWishlist = new stdClass();
    $oWishlist->name = "Wishlist";
    $vocab = taxonomy_vocabulary_machine_name_load('wishlist');
    $oWishlist->vid = $vocab->vid;
    $oWishlist->language = 'und';
    $oWishlist->field_date_gmt['und'][0]['value'] = date("Y-m-d");
    taxonomy_term_save($oWishlist);
    
    $_SESSION['wishlist']['id'] = $oWishlist->tid;
    
    $oWishlist->name = $oWishlist->tid;
    taxonomy_term_save($oWishlist);
    
    return $oWishlist;
}
function addToWishlist ($sId) {
    $aResponse = ['success' => false];
    $aResponse['first_add'] = false;
    
    if (isset($_SESSION['wishlist']['id']) && $_SESSION['wishlist']) {
        $oWishlist = taxonomy_term_load($_SESSION['wishlist']['id']);
        if (!$oWishlist) {
            $aResponse['success'] = false;
            $aResponse['error'] = 'Wishlist does not exist';
            unset($_SESSION['wishlist']);
//            addToWishlist($sId);
        } else {
            $bDelete = false;
            if ($oWishlist->field_product) {
                foreach ($oWishlist->field_product['und'] as $sKey => $aProduct) {
                    if ($aProduct['tid'] == $sId) {
                        unset($oWishlist->field_product['und'][$sKey]);
                        if(($key = array_search($sId, $_SESSION['wishlist']['product_ids'])) !== false) {
                            unset($_SESSION['wishlist']['product_ids'][$key]);
                        }
                        $bDelete = true;
                    } 
                }
            }
            if (!$bDelete || !$oWishlist->field_product) {
                if (!$oWishlist->field_product) {
                    $aResponse['first_add'] = true;
                }
                $oWishlist->field_product['und'][] = ['tid' => $sId];
                $_SESSION['wishlist']['product_ids'][] = $sId;
            }

            taxonomy_term_save($oWishlist);
            $aResponse['success'] = true;
            $aResponse['wishlist']['id'] = $oWishlist->tid;
            $aResponse['wishlist']['product_ids'] = $_SESSION['wishlist']['product_ids'];
        }
    } else {
        
        $oWishlist = createWishlist();
        
        // add product to list
        $oWishlist->field_product['und'][] = ['tid' => $sId];
        taxonomy_term_save($oWishlist);
        
        $_SESSION['wishlist']['product_ids'][] = $sId;
        
        $aResponse['success'] = true;
        $aResponse['first_add'] = true;
        $aResponse['wishlist']['id'] = $oWishlist->tid;
        $aResponse['wishlist']['product_ids'] = $_SESSION['wishlist']['product_ids'];
    }
    
    return $aResponse;
}

function registerMember ($aFields) {
    $aResult = [];
    if (isset(
        $aFields['first_name'],
        $aFields['last_name'],
        $aFields['company_name'],
        $aFields['company_address'],
        $aFields['country'],
        $aFields['company_phone'],
        $aFields['company_website'],
        $aFields['password'],
        $aFields['password_confirm'],
        $aFields['email']) 
        && $aFields['first_name']
        && $aFields['last_name']
        && $aFields['company_name']
        && $aFields['company_address']
        && $aFields['country']
        && $aFields['company_phone']
        && $aFields['company_website']
        && $aFields['password']
        && $aFields['password_confirm']) {
            if (($_SERVER["HTTP_HOST"] != 'localhost' && !user_is_logged_in()) || $_SERVER["HTTP_HOST"] == 'localhost') {
                $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
                    curl_setopt($ch, CURLOPT_POST, 1);

                     curl_setopt($ch, CURLOPT_POSTFIELDS, 
                              http_build_query(array(
                                  'response' => $aFields['g-recaptcha-response'],
                                  'secret' => '6Ld-GBATAAAAAIvB5kbSL3qzIxuWgp3j9E9PKzx7'
                                  )));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = json_decode(curl_exec ($ch));

                    curl_close ($ch);

                    if (!$server_output->success) {
                        $aResult['success'] = false;
                        $aResult['error'] = "Wrong captcha";
                        return $aResult;
                    }   
            }
        
            $oQuery = new EntityFieldQuery();
            $oQuery->entityCondition('entity_type', 'taxonomy_term')
                    ->entityCondition('bundle', 'member')
                    ->fieldCondition('field_member_email', 'value', $aFields['email']);
            $aResultQuery = $oQuery->execute();
            if ($aResultQuery) {
                $aResult['success'] = false;
                $aResult['error'] = "This email is already used";
                return $aResult;
            }
            if (strlen($aFields['password']) < 6) {
                $aResult['success'] = false;
                $aResult['error'] = "Password must be at least 6 characters long";
                return $aResult;
            }
            if ($aFields['password'] != $aFields['password_confirm']) {
                $aResult['success'] = false;
                $aResult['error'] = "Confirmation password is different";
                return $aResult;
            }
            $oTerm = new stdClass();
            $oTerm->name = $aFields['first_name'].' '.$aFields['last_name'];
            $oTerm->vid = taxonomy_vocabulary_machine_name_load('member')->vid;
            $oTerm->language = 'und';
            $oTerm->field_membrer_registration_date['und'][0]['value'] = date("Y-m-d");
            $oTerm->field_country['und'][0]['iso2'] = $aFields['country'];
            $oTerm->field_password['und'][0]['value'] = md5(md5($aFields['password']).substr($oTerm->field_membrer_registration_date['und'][0]['value'], 0, 10));
            $oTerm->field_password_clear['und'][0]['value'] = $aFields['password'];
            $oTerm->field_member_first_name['und'][0]['value'] = $aFields['first_name'];
            $oTerm->field_member_last_name['und'][0]['value'] = $aFields['last_name'];
            $oTerm->field_member_email['und'][0]['value'] = $aFields['email'];
            $oTerm->field_member_company_name['und'][0]['value'] = $aFields['company_name'];
            $oTerm->field_member_address['und'][0]['value'] = $aFields['company_address'];
            $oTerm->field_member_phone['und'][0]['value'] = $aFields['company_phone'];
            $oTerm->field_member_website['und'][0]['value'] = $aFields['company_website'];
            $oTerm->field_accept_promo['und'][0]['value'] = ($aFields['accept_promo'] == 'on' ? true : false);
            if (isset($aFields['company_type']) && $aFields['company_type']) {
                $oTerm->field_member_company_type['und'][0]['tid'] = $aFields['company_type']; 
            }
            // Pending status
            $oTerm->field_member_status['und'][0]['tid'] = '682';            
            
            // IP country
            $ip = '';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            if ($_SERVER["HTTP_HOST"] == 'localhost') {
                $ip = "61.220.251.250";
            }
            
            $url = "http://ip2c.org/" . $ip;
            set_time_limit(10);
            $data = file_get_contents($url);
            $reply = explode(';',$data);
            
            $oTerm->field_member_country_ip['und'][0]['iso2'] = $reply[1];
            
            taxonomy_term_save($oTerm);
            $aResult['success'] = true;
            return $aResult;
    } else {
        $aResult['success'] = false;
        $aResult['error'] = "Information missing";
        return $aResult;
    }
}

function verifyMemberConnection() {
    if (isset($_GET['logout'])) {
        disconnectUser();
        return;
    }
    if (isset($_SESSION['user']) && $_SESSION['user']) {
        $oUser = $_SESSION['user'];
        $oQuery = new EntityFieldQuery();
        $oQuery->entityCondition('entity_type', 'taxonomy_term')
                ->entityCondition('bundle', 'member')
                ->propertyCondition('tid', $oUser->tid, '=')
                ->fieldCondition('field_member_status', 'tid', 684);
        $aResult = $oQuery->execute();
        if (!$aResult) {
            disconnectUser();
        }
    }
}
function disconnectUser() {
    global $base_url;
    unset($_SESSION['user']);
    header('Location: '.$base_url);
}

function connectMember($aFields) {
    $aReturn = [];
    if (isset($aFields['password'], $aFields['email']) && $aFields['password'] && $aFields['email']) {
        $sEmail = $aFields['email'];
        $sPassword = $aFields['password'];
        $oQuery = new EntityFieldQuery();
        $oQuery->entityCondition('entity_type', 'taxonomy_term')
                ->entityCondition('bundle', 'member')
                ->fieldCondition('field_member_email', 'value', $sEmail);
        $aResult = $oQuery->execute();
        $oUser = taxonomy_term_load(array_keys($aResult['taxonomy_term'])[0]);
        if ($oUser) {
            if ($oUser->field_member_status['und'][0]['tid'] == 684) {
                if ($oUser->field_password['und'][0]['value'] == md5(md5($sPassword).substr($oUser->field_membrer_registration_date['und'][0]['value'], 0, 10))) {
                    $_SESSION['user'] = $oUser;
                    $aReturn['success'] = true;
                    return $aReturn;
                } else {
                    $aReturn['success'] = false;
                    $aReturn['error'] = 'Wrong password';
                    return $aReturn;
                }
            } else {
                $aReturn['success'] = false;
                $aReturn['error'] = 'Your account has not been validated yet';
                return $aReturn;
            }
        } else {
            $aReturn['success'] = false;
            $aReturn['error'] = 'Wrong email';
            return $aReturn;
        }
    } else {
        $aReturn['success'] = false;
        $aReturn['error'] = 'Information missing';
        return $aReturn;
    }
}

function getCompanyType () {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'member_company_type');
    $aResult = $oQuery->execute();
    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
}

function displaySocialMediaLogo() { ?>
    <div class="block-social-network">
        <div class="social-network"><a href="https://www.facebook.com/pages/QCS-ASIA/182231511328?fref=ts"><span class="icomoon-facebook2"></span></a></div>
        <div class="social-network"><a href="https://plus.google.com/105432120660907122700/posts?hl=fr&partnerid=gplp0" rel="publisher"><span class="icomoon-google-plus2"></span></a></div>
        <div class="social-network"><a href="http://www.linkedin.com/company/qcs-asia-co.-ltd"><span class="icomoon-linkedin"></span></a></div>
<!--        <div class="social-network"><a href=""><span class="icomoon-twitter"></span></a></div>
        <div class="social-network"><a href=""><span class="icomoon-pinterest"></span></a></div>-->
    </div><?php
}

function retrieveByTermName($sTermName) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', $sTermName);
    $aResult = $oQuery->execute();
    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
}
function retrieveCategories($iStart = null, $iLength = null, $bRetrieveAll = false) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'category');
    if (!$bRetrieveAll) {
        $oQuery->range(($iStart ? : 0), ($iLength ? : 6));
    }

    $aResult = $oQuery->execute();
    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
}

//function displayCategories($iStart = null, $iLength = null) {
//    $aCategories = retrieveCategories($iStart = null, $iLength = null);
//    include 'categories_list.tpl.php';
//}
//
//function retrieveProducts($oTerm = null, $iStart = null, $iLength = null) {
//    $oQuery = new EntityFieldQuery();
//    $oQuery->entityCondition('entity_type', 'taxonomy_term')
//            ->entityCondition('bundle', 'product')
//            ->range(($iStart ? : 0), ($iLength ? : 5));
//    if ($oTerm) {
//        $oQuery->fieldCondition('field_category', 'tid', $oTerm->tid);
//    }
//    $aResult = $oQuery->execute();
//
//    return taxonomy_term_load_multiple(array_keys($aResult['taxonomy_term']));
//}

//function displayProducts($oTerm = null, $iStart = null, $iLength = null) {
//    $aProducts = retrieveProducts($oTerm, $iStart = null, $iLength = null);
//    include 'products_list.tpl.php';
//}

function qcsasia_links__system_menu_top($variables) {
    if ($variables['links']) { ?>
        <nav class="navbar navbar-default navbar-top">
            <div class="container-fluid padding-md-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-menu-top" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <div class="visible-xs visible-sm pull-left margin-left-xs-20 margin-top-10"><?= displaySocialMediaLogo() ?></div>
                </div>
                <div class="navbar-collapse collapse padding-lg-0" id="navbar-collapse-menu-top" aria-expanded="false">
                    <ul class="menu-list menu-list pull-right"><?php
                        if (isset($_SESSION['wishlist']['id']) && $_SESSION['wishlist']['id']) { ?>
                            <li class="wishlist-link">
                                <a href="<?= url('wishlist/'.$_SESSION['wishlist']['id']) ?>" >
                                <span class="glyphicon glyphicon-floppy-disk font-size-15"></span>
                                    Wishlist <span class="count badge"><?= count($_SESSION['wishlist']['product_ids']) ?></span>
                                </a>
                            </li><?php
                        }
                        foreach ($variables['links'] as $link) { ?>
                            <li>
                                <a href="<?= url($link['link']['link_path']) ?>" >
                                    <?= $link['link']['link_title'] ?>
                                </a>
                            </li><?php 
                        } ?>
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
        displaySubMenuProducts(); ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid padding-md-0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-main-menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand visible-xs">Menu</span>
                </div>
                <div class="navbar-collapse collapse padding-lg-0" id="navbar-collapse-main-menu" aria-expanded="false">
                    <ul class="nav navbar-nav padding-xs padding-lg-0"><?php 
                        foreach ($variables['links'] as $link) { ?>
                            <li class="<?= ($link['below'] ? 'dropdown' : '') ?> menu-item <?= (($_SERVER["REQUEST_URI"] === url($link['link']['link_path']) && $link['link']['href'] != '<front>') ? ' active' : '') ?>" data-menu-item="<?= ($link['link']['href'] == 'node/13' ? 'products' : ($link['link']['href'] == 'node/33' ? 'gifts' : '')) ?>">
                                <a <?= ($link['below'] ? 'role="button" aria-haspopup="true" aria-expanded="false"' : '') ?> class="text-uppercase" href="<?= url($link['link']['link_path']) ?>" >
                                    <?= $link['link']['link_title'] ?>
                                </a><?php 
                                if ($link['below']) {
                                    $bIsConnected = isset($_SESSION['user']) && $_SESSION['user'];
                                    if (($link['link']['link_path'] == 'node/38' && $bIsConnected) || $link['link']['link_path'] != 'node/38') { ?>
                                        <ul class="dropdown-menu hidden-xs"><?php
                                            foreach ($link['below'] as $below) {
                                                if (isset($below['link'])) { ?>
                                                    <li>
                                                        <a href="<?= url($below['link']['href'], ['query' => (isset($below['link']['localized_options']['query']) ? $below['link']['localized_options']['query'] : '')]) ?>"><?= $below['link']['link_title'] ?></a>
                                                    </li><?php
                                                }
                                            } ?>
                                        </ul><?php 
                                    }
                                } ?>
                            </li><?php 
                        } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right search-form-content">
                        <li><form action="<?= url('node/13') ?>" method="get"><input class="margin-right-xs-10 col-xs-8" placeholder="Search Products" name="keyword" type="text" autocomplete="off" /><button class="btn btn-primary" type="submit">Search</button></form></li>
                    </ul>
                </div>
            </div>
        </nav><?php
    }
}
function displaySubMenuProducts() { ?>
    <div class="dropdown-menu hidden-xs sub-menu sub-menu-products col-xs-12">
        <div class="col-xs-4 border-right">
            <div class="filter-group-title" data-group-title="criteria"><span class="glyphicon glyphicon-chevron-down"></span> Criteria</div>
            <div class="block-filter-group group-criteria">
                <a href="<?= url('node/13', ['query' => ['new' => null]]) ?>" class="padding-5 col-xs-12">New Product</a>
                <a href="<?= url('node/13', ['query' => ['patented' => null]]) ?>" class="padding-5 col-xs-12">Patented Product</a>
                <a href="<?= url('node/13', ['query' => ['cheap' => null]]) ?>" class="padding-5 col-xs-12">Very cheap product</a>
                <a href="<?= url('node/13', ['query' => ['rush' => null]]) ?>" class="padding-5 col-xs-12">Rush service products</a>
            </div>
            <div class="filter-group-title" data-group-title="material"><span class="glyphicon glyphicon-chevron-down"></span> Material</div>
            <div class="block-filter-group group-material">
                <a href="<?= url('node/13', ['query' => ['category' => 'aluminium']]) ?>" class="padding-5 col-xs-12">Aluminium</a>
                <a href="<?= url('node/13', ['query' => ['category' => 'metal-enamel']]) ?>" class="padding-5 col-xs-12">Metal</a>
                <a href="<?= url('node/13', ['query' => ['category' => 'plastic-injection']]) ?>" class="padding-5 col-xs-12">Plastic</a>
                <a href="<?= url('node/13', ['query' => ['category' => 'soft-pvc-cloisonne']]) ?>" class="padding-5 col-xs-12">PVC cloisonné/rubber</a>
            </div>
        </div>
        <div class="col-xs-4 border-right">
            <div class="filter-group-title" data-group-title="function"><span class="glyphicon glyphicon-chevron-down"></span> Function</div>
            <div class="block-filter-group group-function">
                <a href="<?= url('node/13', ['query' => ['function' => 'keychain']]) ?>" class="padding-5 col-xs-12">Keychain</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'bar-accessory']]) ?>" class="padding-5 col-xs-12">Bar accessory</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'trolley-token']]) ?>" class="padding-5 col-xs-12">Coin keychain</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'wearable']]) ?>" class="padding-5 col-xs-12">Wearable</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'canister-container']]) ?>" class="padding-5 col-xs-12">Canisters & containers</a>
                <a href="<?= url('node/13', ['query' => ['function' => '3c-accessory']]) ?>" class="padding-5 col-xs-12">3C accessory</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'tools']]) ?>" class="padding-5 col-xs-12">Tools</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'office']]) ?>" class="padding-5 col-xs-12">Office</a>
                <a href="<?= url('node/13', ['query' => ['function' => 'stickers-and-magnets']]) ?>" class="padding-5 col-xs-12">Stickers & magnets</a>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="filter-group-title" data-group-title="logo-process"><span class="glyphicon glyphicon-chevron-down"></span> Logo process</div>
            <div class="block-filter-group group-logo-process">
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'doming']]) ?>" class="padding-5 col-xs-12">Doming</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'digital-printing']]) ?>" class="padding-5 col-xs-12">Digital printing</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'silk-screen-printing']]) ?>" class="padding-5 col-xs-12">Silk screen printing</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'laser-engraving']]) ?>" class="padding-5 col-xs-12">Laser engraving</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'offset-printing']]) ?>" class="padding-5 col-xs-12">Offset printing</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => 'enamel']]) ?>" class="padding-5 col-xs-12">Enamel</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => '2d-pvc']]) ?>" class="padding-5 col-xs-12">2D PVC cloisonné</a>
                <a href="<?= url('node/13', ['query' => ['logo-process' => '3d-pvc']]) ?>" class="padding-5 col-xs-12">3D PVC cloisonné</a>
            </div>
        </div>
    </div>
    <div class="dropdown-menu hidden-xs sub-menu sub-menu-gifts col-xs-12">
        <div class="col-xs-12"><?php
            $aThemes = taxonomy_term_load_multiple(array_keys(getThemes())); ?>
            <div class="block-filter-group group-criteria padding-5"><?php
                $count = 1;
                foreach ($aThemes as $oTheme) { 
                    if ($count == 1) { ?>
                        <div class="col-md-3 border-right"><?php
                    } ?>
                    <a href="<?= url('taxonomy/term/'.$oTheme->tid) ?>" title="<?= $oTheme->field_theme_title['und'][0]['value'] ?>" class="padding-5 col-xs-12"><?= $oTheme->field_theme_title['und'][0]['value'] ?></a><?php
                    if (in_array($count, [6, 12, 18])) { ?>
                        </div>
                        <div class="col-md-3 <?= ($count != 18 ? 'border-right' : '') ?>"><?php
                    } 
                    if ($count == count($aThemes)) { ?>
                        </div><?php
                    }
                    $count++;
                } ?>
            </div>
        </div>
    </div><?php
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
                            $breadcrumb[] = '<a href="' . url('node/13', ['query' => ['category' => $oCategoryParent->field_reference['und'][0]['value']]]) . '">' . $oCategoryParent->field_category_title['und'][0]['value'] . '</a>';
                        }
                        $breadcrumb[] = '<a href="' . url('node/13', ['query' => ['line' => $oCategory->field_reference['und'][0]['value']]]) . '">' . $oCategory->field_category_title['und'][0]['value'] . ' ' . $oCategory->field_category_reference['und'][0]['value'] . '</a>';
                    } else {
                        $breadcrumb[] = '<a href="' . url('node/13', ['query' => ['category' => $oCategory->field_reference['und'][0]['value']]]) . '">' . $oCategory->field_category_title['und'][0]['value'] . ' ' . $oCategory->field_category_reference['und'][0]['value'] . '</a>';
                    }
                    break;
                case 'category':
                    $breadcrumb[] = '<a href="' . url('node/13') . '">Promotional products</a>';
                    break;
                case 'theme':
                    $breadcrumb[] = '<a href="' . url('node/33') . '">Themes</a>';
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
        if ($oTerm->vocabulary_machine_name == 'wishlist') {
            $title = 'Wishlist '.$title;
        }
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
        case 'confirm_email' :
            // confirmation email
            if (isset(drupal_get_query_parameters()['email']) && drupal_get_query_parameters()['email']) {
                $vars['bIsConfirmed'] = confirmEmail(drupal_get_query_parameters()['email']);
            } else {
                $vars['bIsConfirmed'] = false;
            }
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
                if (!isset($aCurrentFilters[$sKey]) || (is_array($aCurrentFilters[$sKey]) && !in_array($sValue, $aCurrentFilters[$sKey]))) {
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
            ->propertyOrderBy('weight', 'ASC');

    $aResult = $oQuery->execute();
    $aGifts = $aResult['taxonomy_term'];

    if ($aQueryParameters) {
        reset($aQueryParameters);
        switch (key($aQueryParameters)) {
            case 'theme':
                // retrieve theme
                $oTheme = array_values(getTermByRef($aQueryParameters['theme'], 'theme')[0]);
                break;
            case 'display':
                $oDisplay = array_values(getTermByRef($aQueryParameters['display'], 'display')[0]);
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

function getThemes($aQueryParameters = null) {
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

function getTopCategoryReferenceByProduct($oProduct) {
    $sCategoryParent = taxonomy_get_parents($oProduct->field_category['und'][0]['tid']);
    if ($sCategoryParent) {
        return array_shift(array_values($sCategoryParent))->field_reference['und'][0]['value'];
    } else {
        return taxonomy_term_load($oProduct->field_category['und'][0]['tid'])->field_reference['und'][0]['value'];
    }
}

function getProducts($aQueryParameters, $bCount = false) {
    // retrieve products
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
            ->entityCondition('bundle', 'product')
            ->propertyOrderBy('weight', 'ASC');
    if ($aQueryParameters) {
        foreach ($aQueryParameters as $sKey => $mValue) {
            switch ($sKey) {
                case 'keyword':
//                    $aKeyword = explode(" ", $mValue);
//                        $oQuery->propertyCondition('name', $sKeyword, 'CONTAINS');
//                        $oQuery->propertyCondition('name', $sKeyword, 'CONTAINS');
//                    preg_match('/(#[a-zA-Z0-9]+)/', $sKeyword, $matches);
//                    if ($matches) {
//                        $oQuery->fieldCondition('field_product_ref', 'value', $sKeyword, 'CONTAINS');
//                    } else {
//                        $oQuery->fieldCondition('field_product_name', 'value', $sKeyword, 'CONTAINS');
//                    }
                    $mValue = explode(' ', $mValue);
                    foreach ($mValue as $sKeyword) {
                        $sKeyword = rtrim($sKeyword);
                        preg_match('/(#[a-zA-Z0-9]+)/', $sKeyword, $matches);
                        if ($matches) {
                            $oQuery->fieldCondition('field_product_ref', 'value', $sKeyword, 'CONTAINS');
                        } else {
                            $oQuery->propertyCondition('name', $sKeyword, 'CONTAINS');
//                            $oQuery->fieldCondition('field_product_name', 'value', $sKeyword, 'CONTAINS');
                        }
                    }
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
                case 'line':
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
                    break;
                case 'document_center':
                    $oQuery->fieldCondition('field_group_document', 'value', '', '<>');
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

function confirmEmail($sAddressEmail) {
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', 'member')
        ->fieldCondition('field_member_email', 'value', $sAddressEmail)
        ->fieldCondition('field_member_status', 'tid', '682');
    $aResult = $oQuery->execute();
    if ($aResult) {
        $oMember = taxonomy_term_load(array_keys($aResult['taxonomy_term'])[0]);
        $oMember->field_member_status['und'][0]['tid'] = '683';
        taxonomy_term_save($oMember);
        return true;
    } else {
        return false;
    }
}

function qcsasia_preprocess_html(&$vars) {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
        $vars['oUser'] = $_SESSION['user'];
    }
    switch ($vars['theme_hook_suggestions'][0]) {
        case 'html__sitemap' :
            header('HTTP/1.1 200 OK');
            unset($vars);
            break;
        case 'html__products_ajax' :
            header('HTTP/1.1 200 OK');
            $aProducts = getProducts(drupal_get_query_parameters());
            $vars['aProducts'] = taxonomy_term_load_multiple(array_keys($aProducts));
            break;
        case 'html__themes_ajax' :
            header('HTTP/1.1 200 OK');
            $aThemes = getThemes(drupal_get_query_parameters());
            $vars['aThemes'] = taxonomy_term_load_multiple(array_keys($aThemes));
            break;
        case 'html__products_number_ajax' :
            header('HTTP/1.1 200 OK');
            $vars['aFilterNumProducts'] = getPotentialNumberForFilters();
            break;
        case 'html__products_line_ajax' :
        case 'html__member_area_register' :
        case 'html__member_area_login' :
        case 'html__add_to_wishlist' :
        case 'html__rss_news' :
            header('HTTP/1.1 200 OK');
            break;
    }
    
    // page search products change meta regarding to filters
    if ($node = menu_get_object()) {
        $aQueryParameters = drupal_get_query_parameters();
        $iNumberFilter = count($aQueryParameters);
        if ($node->nid == '13' && $iNumberFilter >= 1 
                && !($iNumberFilter == 1 && (isset($aQueryParameters['keyword']) || isset($aQueryParameters['line'])))) {
            $vars['head_title'] = '';
            $sDescriptionFilter = '';
            for ($i = 1; $i <= 2; $i++) {
                $aKeys{$i} = array_keys($aQueryParameters)[$i - 1];
                $aValues{$i} = array_values($aQueryParameters)[$i - 1];

                // get taxonomy term type
                $sTaxonomyTermType{$i} = $aKeys{$i};

                // retrieve the taxonomy term
                $sReference{$i} = array_shift($aValues{$i});

                if (!$sReference{$i}) {
                    $sReference{$i} = $sTaxonomyTermType{$i};
                }
                        
                $oTermFilter{$i} = getTermByReference(($sTaxonomyTermType{$i} == 'logo-process' ? 'logo_process' : $sTaxonomyTermType{$i} ), $sReference{$i});
                $aMetaFilter{$i} = metatags_get_entity_metatags($oTermFilter{$i}->tid, 'taxonomy_term');
                $sTitleFilter{$i} = $aMetaFilter{$i}['title']['#attached']['metatag_set_preprocess_variable'][0][2];
                $sDescriptionFilter .= ($sDescriptionFilter ? ' ' : '').$aMetaFilter{$i}['description']['#attached']['drupal_add_html_head'][0][0]['#value'];
                
                // modify the title meta tag in the header
                $vars['head_title'] .= ($vars['head_title'] ? ' ' : '') . $sTitleFilter{$i};
            }

            // change page title
            $vars['head_title'] .= ' - ' . variable_get('site_name');

            // modify the description meta tag in the header
            $meta_description = array(
                '#type' => 'html_tag',
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'description',
                    'content' => $sDescriptionFilter,
                ),
            );
            drupal_add_html_head($meta_description, 'metatag_description_0');
        }
    }
}

function getTermByReference ($sTaxonomyTermType, $sReference) {
    
    $oQuery = new EntityFieldQuery();
    $oQuery->entityCondition('entity_type', 'taxonomy_term')
        ->entityCondition('bundle', $sTaxonomyTermType)
        ->fieldCondition('field_reference', 'value', $sReference);

    $aValuesResult = array_values($oQuery->execute()['taxonomy_term']);

    $aResult = array_shift($aValuesResult);
    
    return taxonomy_term_load($aResult->tid);
}

function displayDocumentCenter($term) {
    $iCounter = 1;
    $aIdDocumentsGroupsEntities = [];
    foreach ($term->field_group_document['und'] as $aGroupDocument) {
        $aIdDocumentsGroupsEntities[] = $aGroupDocument['value'];
    }
    $oFieldDocumentsGroups = entity_load('field_collection_item', $aIdDocumentsGroupsEntities);
    foreach ($oFieldDocumentsGroups as $oFieldDocumentsGroup) {
        if (count($term->field_group_document['und']) > 2 && $iCounter == 1) { ?>
            <div class="col-sm-6 border-sm-right"><?php 
        } ?>
        <div class="list-title" data-id-doc="1"><span class="glyphicon glyphicon-<?= (strpos(strtolower($oFieldDocumentsGroup->field_group_document_title['und'][0]['value']), 'picture') !== false ? 'picture' : 'file') ?>"></span> <?= $oFieldDocumentsGroup->field_group_document_title['und'][0]['value'] ?></div><?php
        $aIdDocumentsEntities = [];
        foreach ($oFieldDocumentsGroup->field_document['und'] as $aDocument) {
            $aIdDocumentsEntities[] = $aDocument['value'];
        }
        $oFieldDocuments = entity_load('field_collection_item', $aIdDocumentsEntities);
        $bIsConnected = isset($_SESSION['user']) && $_SESSION['user'];
        if ($oFieldDocuments) { ?>
            <ul class="list-doc"><?php 
                foreach ($oFieldDocuments as $oFieldDocument) { ?>
                        <li>
                            <a target="blank" <?= (!$bIsConnected ? 'class="disabled_link"' : '') ?> href="<?= (!$bIsConnected ? url('member-area') : str_replace("www", "dl", $oFieldDocument->field_document_link['und'][0]['value'])) ?>">
                                <span class="glyphicon glyphicon-<?= (strpos(strtolower($oFieldDocument->field_document_title['und'][0]['value']), 'picture') !== false ? 'picture' : 'download-alt') ?>"></span> <?= getNameFromDocument($oFieldDocument->field_document_link['und'][0]['value']) ?></a>
                        </li><?php 
                } ?>
            </ul><?php
        }
        if ($iCounter == 2 && count($term->field_group_document['und'])> 2) { ?>
            </div>
            <div class="col-sm-6"><?php
        }
        if (count($term->field_group_document['und'])> 2 && (count($term->field_group_document['und']) == $iCounter)) { ?>
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
    $aImageOptionEntity = array_values(entity_load('field_collection_item', [$aImageOption['value']]))[0]; ?>
    <div class="col-sm-3 margin-bottom-10 block-option">
        <div class="thumbnail margin-bottom-0">
            <img src="<?= file_create_url($aImageOptionEntity->field_image_option_img['und'][0]['uri']) ?>" alt="<?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?>" title="<?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?>" />
            <div class="subtitle-pic"><?= $aImageOptionEntity->field_image_option_title['und'][0]['value'] ?></div>
        </div>
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
        displayLogoProcessBlock(($bIssetDoming ? $aLogoProcesses['doming'] : array_values($aLogoProcesses)[0])); 
        $count = 1;
        foreach ($aLogoProcesses as $key => $aLogoProcess) {
            if ($key && (($bIssetDoming && $key != 'doming') || (!$bIssetDoming && $count > 1 ))) { 
                displayLogoProcessBlock($aLogoProcess); 
            }
            $count++;
        } ?>
    </div><?php
}

function displayLogoProcessBlock($aLogoProcess) {
    $oLogoProcess = taxonomy_term_load($aLogoProcess['id']);
    $bComplicatedDisplay = $aLogoProcess['thumbnail'];
    $bLargePicture = $aLogoProcess['large']; ?>
    <div class="col-md-12"><?php
        if ($bComplicatedDisplay) { ?>
            <div class="col-sm-3 margin-top-20 <?= ($bLargePicture ? 'pointer event-enlarge' : '') ?>">
                <div class="col-xs-12 thumbnail border-none">
                    <img class="border" src="<?= file_create_url($aLogoProcess['thumbnail']) ?>" <?= ($bLargePicture ? 'data-large-picture="'.file_create_url($aLogoProcess['large']).'"' : '') ?> alt="<?= $oLogoProcess->name ?>" title="<?= $oLogoProcess->name ?>" /><?php
                    if ($bLargePicture) { ?>
                        <img class="hidden" src="<?= file_create_url($aLogoProcess['large']) ?>" alt="<?= $oLogoProcess->name ?>" title="<?= $oLogoProcess->name ?>" /><?php
                    } ?>
                </div>
            </div><?php 
        } ?>
        <div class="<?= $bComplicatedDisplay ? 'col-sm-9' : 'col-sm-12' ?> padding-xs-0">
            <div class="clearfix"></div>
            <h3 class=""><?= $oLogoProcess->name ?></h3>
            <div class="col-md-7 margin-bottom-sm-10">
                <?= $oLogoProcess->field_logo_process_description['und'][0]['value'] ?>
            </div>
            <div class="col-md-5">
                <?= $oLogoProcess->field_youtube_video['und'][0]['value'] ?>
            </div>
        </div>
    </div><?php
}
function displayProductCheckbox($aProducts){
    $mProductParameter = isset(drupal_get_query_parameters()['product']) ? drupal_get_query_parameters()['product'] : '';
    $aProductParameters = is_array($mProductParameter) ? $mProductParameter : [$mProductParameter];
    foreach ($aProducts as $sId => $aProductOption) { 
        $oProduct = taxonomy_term_load($sId);
        $sProductTitle = $oProduct->field_product_name['und'][0]['value']." ".$oProduct->field_product_ref['und'][0]['value']; ?>
            <div class="col-xs-6 col-sm-2" id="<?= $sId ?>">
                <div class="col-xs-12 thumbnail thumbnail-hover padding-0"><?php
                    $aLogoProcesses = getLogoProcesses($oProduct);
                    $sLogoProcessUri = (!$aLogoProcesses 
                            ? $oProduct->field_main_photo['und'][0]['uri']
                            : (isset($aLogoProcesses['doming']) && $aLogoProcesses['doming']['thumbnail']
                                ? $aLogoProcesses['doming']['thumbnail'] 
                                : (isset(array_values($aLogoProcesses)[0]['thumbnail']) && array_values($aLogoProcesses)[0]['thumbnail']
                                    ? array_values($aLogoProcesses)[0]['thumbnail'] 
                                    : $oProduct->field_main_photo['und'][0]['uri']))); ?>
                    <a href="<?= url('taxonomy/term/'.$oProduct->tid) ?>" target="_blank" title="<?= $oProduct->field_product_name['und'][0]['value'] ?>">
                        <img src="<?= file_create_url($sLogoProcessUri) ?>" title="<?= $oProduct->field_product_name['und'][0]['value'] ?>" alt="<?= $oProduct->field_product_name['und'][0]['value'] ?>" />
                        <div class="col-xs-12 subtitle-pic"><?= (isset($oProduct->field_product_ref['und'][0]['value']) ? $oProduct->field_product_ref['und'][0]['value'] : '')?></div>
                    </a><?php
                    $bCheck = false;
                    foreach ($aProductParameters as $aProductParameter) {
                        if (in_array($sId, [$aProductParameter.'L', $aProductParameter.'B'])) {
                            $bCheck = true;
                        }
                    }
                    if (isset($aProductOption[$sId.'L'])) { ?>
                        <div class="col-xs-12 padding-0 margin-bottom-0 border-bottom">
                            <div class="border-right padding-0 col-xs-2 background-grey text-center">
                                <input class="checkbox-sample" data-id="<?= $sId ?>" data-type="L" data-product-title="<?= $sProductTitle ?>" type="checkbox" name="submitted[product][]" value="<?= $sId.'L' ?>" id="logotyped_<?= $oProduct->field_product_ref['und'][0]['value'] ?>" aria-label="..." <?= ($bCheck ? 'checked' : '')  ?>>
                            </div>
                            <div class="col-xs-10">
                                <label for="logotyped_<?= $oProduct->field_product_ref['und'][0]['value'] ?>" class="margin-bottom-0 cursor-pointer">Logotyped</label>
                            </div>
                        </div><?php
                    }
                    if (isset($aProductOption[$sId.'B'])) { ?>
                        <div class="col-xs-12 padding-0 margin-bottom-0">
                            <div class="border-right padding-0 col-xs-2 background-grey text-center">
                                <input class="checkbox-sample" data-id="<?= $sId ?>" data-type="B" data-product-title="<?= $sProductTitle ?>" type="checkbox" name="submitted[product][]" value="<?= $sId.'B' ?>" id="blank_<?= $oProduct->field_product_ref['und'][0]['value'] ?>" aria-label="..." <?= ($bCheck ? 'checked' : '')  ?>>
                            </div>
                            <div class="col-xs-10">
                                <label for="blank_<?= $oProduct->field_product_ref['und'][0]['value'] ?>" class="margin-bottom-0 cursor-pointer">Blank no logo</label>
                            </div>
                        </div><?php
                    } ?>
                </div>
            </div>
        <?php
    }
}
function displayCheckboxes ($aData, $sName) {
    foreach ($aData as $sKey => $sValue) { ?>
        <div class="input-group">
            <span class="input-group-addon">
                <input type="checkbox" id="<?= $sKey ?>" name="<?= $sName ?>[]" value="<?= $sKey ?>" />
            </span>
            <label class="border padding-5 width-100-percent margin-bottom-0 cursor-pointer" for="<?= $sKey ?>"><?= $sValue ?></label>
        </div><?php
    } 
}
function displaySelect($aData, $sLabel, $sName, $bIsRequired){ ?>
    <div class="input-group">
        <span class="input-group-addon"><?= $sLabel.($bIsRequired ? '*' : '') ?></span>
        <select class="form-control <?= ($bIsRequired ? 'required' : '') ?>" name="<?= $sName ?>" ><?php
            foreach ($aData as $sKey => $sName) { ?>
                <option value="<?= $sKey ?>"><?= $sName ?></option><?php
            } ?>
        </select>
    </div><?php
}

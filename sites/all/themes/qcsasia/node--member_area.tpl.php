<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2 class="margin-top-0">Member area</h3><?php
    $bIsConnected = isset($_SESSION['user']) && $_SESSION['user'];
    if (!$bIsConnected) { ?>
        <div class="registration-login-area">
            <div class="col-sm-7">
                <h3 class="title-orange">Register</h3>
                    <form class="form member-area-register">
                        <div class="alert alert-success success-message">Success ! Connection...</div>
                        <div class="alert alert-danger error-message error-message-custom"></div>
                        <div class="alert alert-danger error-message error-message-password">Confirmation password different</div>
                        <div class="alert alert-danger error-message error-message-password-length">Password must be at least 6 characters long</div>
                        <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                        <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div>
                        <div class="col-md-6 padding-left-lg-0">
                            <div class="input-group">
                                <span class="input-group-addon">Firstname*</span>
                                <input class="form-control required" type="text" name="first_name" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Lastname*</span>
                                <input class="form-control required" type="text" name="last_name" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Company name*</span>
                                <input class="form-control required" type="text" name="company_name" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Company address*</span>
                                <input class="form-control required" type="text" name="company_address" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Country*</span>
                                <select class="form-control required" name="country">
                                    <option></option><?php
                                    foreach(country_get_list() as $key => $aCountry) { ?>
                                        <option value="<?= $key ?>"><?= $aCountry ?></option><?php
                                    } ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Company phone*</span>
                                <input class="form-control required" type="text" name="company_phone" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Company website*</span>
                                <input class="form-control required" type="text" name="company_website" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6 padding-right-lg-0">
                            <div class="input-group">
                                <span class="input-group-addon">Company type</span>
                                <select class="form-control" name="company_type">
                                    <option></option><?php
                                    foreach(getCompanyType() as $oCompanyType) { ?>
                                        <option value="<?= $oCompanyType->tid ?>"><?= $oCompanyType->name ?></option><?php
                                    } ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Email*</span>
                                <input class="form-control email required" type="email" name="email" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Password*</span>
                                <input class="form-control password required" type="password" name="password" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Confirm password*</span>
                                <input class="form-control password_confirm required" type="password" name="password_confirm" autocomplete="off"/>
                            </div>
                            <div class="input-group">
                                <label class="cursor-pointer"><input class="margin-bottom-20" type="checkbox" name="accept_promo" checked/>By contacting QCS Asia, I accept to receive latest product updates</label>
                            </div><?php
                            if (!user_is_logged_in()) { ?>
                                <div class="input-group">
                                    <div class="g-recaptcha" data-sitekey="6Ld-GBATAAAAAExjGxG_83RXLJR-v8mxlHrIvJiQ"></div>
                                </div><?php
                            } ?>
                        </div>
                        <input type="button" class="btn btn-primary pull-right btn-submit" data-form="member-area-login" value="Submit"/>
                    </form>
                </div>
            <div class="col-sm-5">
                <h3 class="title-blue">Login</h3>
                <form class="form member-area-login">
                    <div class="alert alert-danger error-message error-message-custom"></div>
                    <div class="alert alert-danger error-message error-message-empty-field">Please inform fields marked in red</div>
                    <div class="alert alert-danger error-message error-message-email">Please enter a valid email address</div>
                    <div class="input-group">
                        <span class="input-group-addon">Email</span>
                        <input class="form-control email required" type="email" name="email" autocomplete="off"/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Password</span>
                        <input class="form-control required" type="password" name="password" autocomplete="off"/>
                    </div>
                    <input type="button" class="btn btn-primary pull-right btn-submit" data-form="member-area-login" value="Login"/>
                </form>
                <div class="clearfix"></div>
                <div class="well col-md-12 margin-top-10 padding-10">
                    <p><strong>By registering on our member area, you will get full access to:</strong></p>
                    <div class="col-md-12 padding-0">
                        <div class="col-md-2">
                            <span class="font-size-40 glyphicon glyphicon-file"></span>
                        </div>
                        <div class="col-md-10">
                            <p><strong>Our document center</strong> (High definition pictures, price lists, certification, logo standard, digital drawing...)</p>
                        </div>
                    </div>
                    <div class="col-md-12 padding-0 margin-top-10">
                        <div class="col-md-2">
                            <span class="font-size-44 icomoon icomoon-truck"></span>
                        </div>
                        <div class="col-md-10">
                            <p><strong>Our Rush Service</strong> offering great advantages for more flexibility and efficiency of the sales process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
            formValidators('member-area-login');
            formValidators('member-area-register');
            $('.member-area-login .btn-submit').on('click', function () {
                if (formSubmitValidator('member-area-login')) {
                    submitAjax('member-area-login', 'member_area_login');
                }
            });
            $('.member-area-register .btn-submit').on('click', function () {
                if (formSubmitValidator('member-area-register')) {
                    submitAjax('member-area-register', 'member_area_register');
                }
            });
            function submitAjax(form, url) {
                var query = '';
                console.log($( '.'+form ).serialize());
                $.ajax(baseUrl + url, {
                    dataType: 'json',
                    type: "POST",
                    data: $( '.'+form ).serialize(),
                    beforeSend: function () {
                        var text = (form === 'member-area-login' ? 'Connection...' : 'Registration...');
                        $.magnificPopup.open({
                            items: [{
                                src: $('<div class="white-popup">\n\
                                            <div class="col-md-12 text-center">\n\
                                                <div class="alert alert-success success-message">Success ! Redirect...</div>\n\
                                                <div class="col-xs-12 bold font-size-18">'+text+'</div>\n\
                                                <img src="<?= url(path_to_theme() . "/images/template/loader.gif") ?>" />\n\
                                            </div>\n\
                                            <div class="clearfix"></div>\n\
                                        </div>'),
                                type: 'inline'
                            }]
                        });
                    },
                    success: function (data) {
                        if (!data.success) {
                            $('.'+form+' .error-message-custom').html(data.error).slideDown();
                            $( '.g-recaptcha iframe' ).attr( 'src', function ( i, val ) { return val; });
                        } else {
                            if (form === 'member-area-login') {
                                $('.white-popup .success-message').html(data.error).slideDown();
                                window.location.replace(baseUrl+'member-area');
                            } else {
                            $('.registration-login-area').html('\
                                    <div class="text-center thumbnail border-none">\n\
                                        <img src="<?= url(path_to_theme() . "/images/registration/registration-step-2.jpg") ?>" title="Scheme" alt="Scheme" />\n\
                                        <div class="well margin-top-20">\n\
                                            <h4>Application form is completed.</h4>\n\
                                            <p>You will receive shortly an e-mail with a link to click to confirm your e-mail address.</p>\n\
                                        </div>\n\
                                    </div>');
                            }
                        }
                        $.magnificPopup.close();
                    }
                });
            }
        </script><?php
    } else {
        $oUser = $_SESSION['user']; ?> 
        <div class="col-xs-12 padding-0">
            <div class="alert alert-success" role="alert">
                <strong>Hello <?= $oUser->name ?> !</strong> Welcome to your member area
                <a  class="bold pull-right" href="<?= url('', ['query' => ['logout' => null]]) ?>" >Logout <span class="glyphicon glyphicon-log-out"></span></a>
                <div class="clearfix"></div>
            </div>
            <a href="<?= url('node/13', ['query' => ['document_center' => null]]) ?>">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Document center</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-2 text-center">
                                <span class="glyphicon glyphicon glyphicon-list-alt font-size-150 color-dark-grey"></span>
                                <!--<img src="<?= url(path_to_theme() . "/images/member/document-center.png") ?>" alt="Document center" title="Document center" />-->
                            </div>
                            <div class="col-sm-10">
                                <p>In this area, you can download our standard documents in editable high definition to use as sales tools :</p>
                                <ul>
                                    <li style="padding:1px;">Product picture high definition (.psd/photoshop)</li>
                                    <li style="padding:1px;">Price list (.ai/Illustrator)</li>
                                    <li style="padding:1px;">Digital drawing (.cdr/corel draw)</li>
                                    <li style="padding:1px;">Certification (.pdf)</li>
                                    <li style="padding:1px;">Patent (.pdf)</li>
                                    <li style="padding:1px;">Logo standard (.crd/corel draw)</li>
                                </ul>
                            </div>
                        </div>
                </div>
            </a>
        </div><?php
    } ?>
</div>
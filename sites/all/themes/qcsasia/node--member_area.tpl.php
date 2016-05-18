<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>><?php
$bIsConnected = isset($_SESSION['user']) && $_SESSION['user'];
if (!$bIsConnected) { ?>
        <h2 class="margin-top-0">Member area</h3>
            <div class="col-sm-7">
                <h3>Register</h3>
                <form class="form member-area-register">
                    <div class="error-message error-message-custom"></div>
                    <div class="success-message">Success ! Connection...</div>
                    <div class="error-message error-message-empty-field">Please inform fields marked in red</div>
                    <div class="error-message error-message-email">Please enter a valid email address</div>
                    
                    <div class="col-sm-6 padding-left-0">
                        <div class="input-group">
                            <span class="input-group-addon">Firstname</span>
                            <input class="form-control required" type="text" name="firstname" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-right-0">
                        <div class="input-group">
                            <span class="input-group-addon">Lastname</span>
                            <input class="form-control required" type="text" name="lastname" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-left-0">
                        <div class="input-group">
                            <span class="input-group-addon">Company name</span>
                            <input class="form-control required" type="text" name="company_name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-right-0">
                        <div class="input-group">
                            <span class="input-group-addon">Company address</span>
                            <input class="form-control required" type="text" name="company_address" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-left-0">
                        <div class="input-group">
                            <span class="input-group-addon">Country</span>
                            <select class="form-control" name="country">
                                <option></option><?php
                                foreach(country_get_list() as $key => $aCountry) { ?>
                                    <option value="<?= $key ?>"><?= $aCountry ?></option><?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-right-0">
                        <div class="input-group">
                            <span class="input-group-addon">Company phone</span>
                            <input class="form-control required" type="text" name="company_phone" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-left-0">
                        <div class="input-group">
                            <span class="input-group-addon">Company website</span>
                            <input class="form-control required" type="text" name="company_website" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-right-0">
                        <div class="input-group">
                            <span class="input-group-addon">Company type</span>
                            <select class="form-control" name="company_type">
                                <option></option><?php
                                foreach(getCompanyType() as $oCompanyType) { ?>
                                    <option value="<?= $oCompanyType->field_reference['und'][0]['value'] ?>"><?= $oCompanyType->name ?></option><?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 padding-left-0">
                        <div class="input-group">
                            <span class="input-group-addon">Email</span>
                            <input class="form-control email required" type="email" name="email" autocomplete="off"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-5">
                <h3>Login</h3>
                <form class="form member-area-login">
                    <div class="error-message error-message-custom"></div>
                    <div class="success-message">Success ! Connection...</div>
                    <div class="error-message error-message-empty-field">Please inform fields marked in red</div>
                    <div class="error-message error-message-email">Please enter a valid email address</div>
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
            </div>
    </div>
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
            $.ajax(baseUrl + '/' + url + '?' + $( '.'+form ).serialize(), {
                dataType: 'json',
                success: function (data) {
                    if (!data.success) {
                        $('.'+form+' .error-message-custom').html(data.error).slideDown();
                    } else {
                        $('.'+form+' .success-message').html(data.error).slideDown();
                        window.location.replace(baseUrl+'/member-area');
                    }
                }
            });
        }
    </script><?php
} else { ?> 
    <a class="bold" href="<?= $baseUrl ?>?logout" >Logout <span class="glyphicon glyphicon-log-out"></span></a><?php
} ?>
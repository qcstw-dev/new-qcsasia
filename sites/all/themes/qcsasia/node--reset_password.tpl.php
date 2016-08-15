<?php
if (isset($_POST['email'], $_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] && $_POST['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);

     curl_setopt($ch, CURLOPT_POSTFIELDS, 
              http_build_query(array(
                  'response' => $_POST['g-recaptcha-response'],
                  'secret' => '6Ld-GBATAAAAAIvB5kbSL3qzIxuWgp3j9E9PKzx7'
                  )));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = json_decode(curl_exec ($ch));

    curl_close ($ch);
    var_dump($server_output);
    if (!$server_output->success) { ?>
        <div class="alert alert-info">Wrong Captcha</div><?php
    } else {
        $oTermMember = getMemberByEmail($_POST['email']);
        if ($oTermMember) {
            $sRandomString = generateRandomString();
            $oTermMember->field_password_clear['und'][0]['value'] = $sRandomString;
            $oTermMember->field_password['und'][0]['value'] = md5(md5($sRandomString).substr($oTermMember->field_membrer_registration_date['und'][0]['value'], 0, 10));
            taxonomy_term_save($oTermMember); ?>
            <div class="alert alert-info">We have sent your new password at your address <b><?= $_POST['email'] ?></b></div><?php
        } else { ?>
            <div class="alert alert-info">Unable to find the user, please contact us.</div><?php
        }
    }   
    //retrieve member
} else { ?>
    <h2>Reset your password</h2>
    <div class="col-xs-12 margin-top-50">
        <form action="" method="post">
            <div class="col-md-offset-3 col-md-4">
                <div class="input-group">
                    <span class="input-group-addon">Your email*</span>
                    <input class="form-control required" type="email" name="email" autocomplete="off">
                </div>
                <div class="input-group">
                    <div class="g-recaptcha" data-sitekey="6Ld-GBATAAAAAExjGxG_83RXLJR-v8mxlHrIvJiQ"></div>
                    <input type="submit" class="btn btn-primary margin-top-20" value="Reset"/>
                </div>
            </div>
        </form>
    </div><?php
}
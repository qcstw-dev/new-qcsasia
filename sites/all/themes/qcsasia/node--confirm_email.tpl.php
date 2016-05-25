<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>><?php
    if ($bIsConfirmed) { ?>
        <div class="col-xs-12 thumbnail border-none">
            <img src="<?= url(path_to_theme() . "/images/registration/registration-step-3.jpg") ?>" title="step validation member account" alt="step validation member account" />
        </div>
        <div class="well col-xs-12">
            <h4>Your e-mail is now confirmed.</h4>
            <p>We will contact you shortly, usually under 24H, to validate your account.</p>
            <p><strong>Your full access to the member area will be granted after validation from our team.</strong></p>
            <p>Thanks QCS Asia team</p>
        </div><?php
    } else { ?>
    <div class="well col-xs-12 text-center">
        <p>A problem occured with your registration process. Please contact us for more information</p>
        <a class="btn btn-primary" href="<?= url('contact-us') ?>" title="" >Contact us</a> 
    </div><?php
    } ?>
</div>
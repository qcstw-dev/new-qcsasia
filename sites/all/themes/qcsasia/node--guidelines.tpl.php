<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2 class="margin-top-0">Guidelines</h3>
    <div class="col-xs-12 col-sm-offset-1 padding-0">
        <div class="col-sm-5">
            <a href="<?= url('logo-processes') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/guidelines/logo-process.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Logo processes</div>
                </div>
            </a>
        </div>
        <div class="col-sm-5">
            <a href="<?= url('colors-and-finishes-metal') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/guidelines/finishes.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Plating on metal</div>
                </div>
            </a>
        </div>
    </div>
</div>
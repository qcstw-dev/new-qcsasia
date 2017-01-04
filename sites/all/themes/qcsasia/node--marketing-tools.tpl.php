<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <h2 class="margin-top-0"><?= $title ?></h3>
    <div class="col-xs-12 col-sm-offset-1 padding-0">
        <div class="col-sm-5">
            <a href="<?= url('catalog') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/marketing-tools/catalog-2016.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Catalog 2017</div>
                </div>
            </a>
        </div>
        <div class="col-sm-5">
            <a href="<?= url('samples-and-prototypes') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/marketing-tools/samples-and-prototype.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Samples and prototypes</div>
                </div>
            </a>
        </div>
        <div class="col-sm-5">
            <a href="<?= url('toolkit') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/marketing-tools/toolkit.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Toolkit</div>
                </div>
            </a>
        </div>
        <div class="col-sm-5">
            <a href="<?= url('newsletters') ?>">
                <div class="thumbnail thumbnail-hover">
                    <img src="<?= url(path_to_theme() . "/images/marketing-tools/newsletter.jpg") ?>" />
                    <div class="subtitle-pic font-size-24">Newsletter</div>
                </div>
            </a>
        </div>
    </div>
</div>
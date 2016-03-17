<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>><?php
    //
    //echo "<ul>";
    //foreach ($aProducts as $oProduct) {
    //    echo '<li><a href="' . url(entity_uri('taxonomy_term', $oProduct)['path']) . '" title="'.$oProduct->name.'">' . $oProduct->name . '</li>';
    //}
    //echo "</ul>"; 
    ?>
    <div class="block-filter col-md-3 thumbnail padding">
        <h4>Filter by:</h4>
        <div class="block-filter-group visible">
            <div><label><input type="checkbox" name="filter" value="new_product" />New Product (50)</label></div>
            <div><label><input type="checkbox" name="filter" value="patented" />Patented Product (15)</label></div>
            <div><label><input type="checkbox" name="filter" value="cheap" />Very cheap product (69)</label></div>
            <div><label><input type="checkbox" name="filter" value="rush" />Rush service product (32)</label></div>
        </div>
        <div class="filter-group-title" data-group-title="material"><span class="glyphicon glyphicon-chevron-down"></span> Material</div>
        <div class="block-filter-group group-material">
            <div><label><input type="checkbox" name="filter" value="plastic_injection" />Plastic injection (24)</label></div>
            <div><label><input type="checkbox" name="filter" value="metal_enamel" />Metal enamel (64)</label></div>
            <div><label><input type="checkbox" name="filter" value="aluminium" />Aluminium (71)</label></div>
            <div><label><input type="checkbox" name="filter" value="soft_pvc" />Soft PVC (39)</label></div>
        </div>
        <div class="filter-group-title" data-group-title="function"><span class="glyphicon glyphicon-chevron-down"></span> Function</div>
        <div class="block-filter-group group-function">
            <div><label><input type="checkbox" name="filter" value="keychain" />Keychain (52)</label></div>
            <div><label><input type="checkbox" name="filter" value="bar_accessory" />Bar accessory (79)</label></div>
            <div><label><input type="checkbox" name="filter" value="trolley_token" />Trolley token (5)</label></div>
            <div><label><input type="checkbox" name="filter" value="wearable" />Wearable (9)</label></div>
            <div><label><input type="checkbox" name="filter" value="canister_container" />Canister & container (50)</label></div>
            <div><label><input type="checkbox" name="filter" value="3c_accessory" />3C accessory (10)</label></div>
            <div><label><input type="checkbox" name="filter" value="tool" />Tools (14)</label></div>
            <div><label><input type="checkbox" name="filter" value="sticker_doming" />Sticker / Doming (75)</label></div>
        </div>
        <div class="filter-group-title" data-group-title="logo_process"><span class="glyphicon glyphicon-chevron-down"></span> Function</div>
        <div class="block-filter-group group-logo_process">
            <div><label><input type="checkbox" name="filter" value="doming" />Doming (20)</label></div>
            <div><label><input type="checkbox" name="filter" value="digital_printing" />Digital printing (31)</label></div>
            <div><label><input type="checkbox" name="filter" value="silk_screen_print" />Silk screen print (56)</label></div>
            <div><label><input type="checkbox" name="filter" value="laser_engrave" />Laser engrave (84)</label></div>
            <div><label><input type="checkbox" name="filter" value="offset_printing" />Offset printing (13)</label></div>
            <div><label><input type="checkbox" name="filter" value="enamel" />Enamel (9)</label></div>
            <div><label><input type="checkbox" name="filter" value="pvc_cloisonne" />PVC cloisonne (14)</label></div>
        </div>
    </div>
    <div class="col-md-9 padding-0 block-list-products">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div><!-- /input-group -->
        </div>
        <div class="col-md-12 padding-0">
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger Plastic key</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
            <div class="block-product col-md-3">
                <div class="thumbnail">
                    <a href="#" title="">
                        <img src="<?= url(path_to_theme() . "/images/products/pkm/main/pkm-main.jpg") ?>" alt="" title="" />
                        <div class="ref-product">#PHM203</div>
                        <div class="title-product">Plastic key hanger</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.filter-group-title').on('click', function () {
        if ($(this).find('span').hasClass('glyphicon-chevron-right')) {
            $(this).find('span').removeClass('glyphicon-chevron-right');
            $(this).find('span').addClass('glyphicon-chevron-down');
        } else {
            $(this).find('span').removeClass('glyphicon-chevron-down');
            $(this).find('span').addClass('glyphicon-chevron-right');
        }
        $('.group-' + $(this).data('group-title')).slideToggle();
    });
    $(window).scroll(function() {
        if (($(window).scrollTop() - $('.block-list-products').offset().top) > 0 ) {
            $('.block-filter').addClass('fixed');
        } else {
            $('.block-filter').removeClass('fixed');
        }
    });
</script>
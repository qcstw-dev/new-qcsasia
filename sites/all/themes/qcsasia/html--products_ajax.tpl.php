<?php
//var_dump($aProducts);
if ($aProducts) {
    $i = 4;
    foreach ($aProducts as $oProduct) {
        if ($i % 4 == 0) { ?>
            <div class = "col-md-12 padding-0"><?php 
        } ?>
        <div class = "block-product col-md-3">
            <div class = "thumbnail">
                <a href = "<?= url('taxonomy/term/'.$oProduct->tid) ?>" title = "">
                    <img src = "<?= file_create_url($oProduct->field_thumbnail['und'][0]['uri']) ?>" alt = "" title = "" />
                    <div class = "ref-product"><?= $oProduct->name ?></div>
                    <div class = "title-product"></div>
                </a>
            </div>
        </div><?php
        $i++;
        if ($i % 4 == 0) { ?>
            </div><?php
        }
    }
}
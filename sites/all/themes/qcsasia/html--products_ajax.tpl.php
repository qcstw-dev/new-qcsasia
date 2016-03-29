<?php if ($aProducts) { ?>
    <div class="col-md-12 margin-bottom-10"><strong>Products: <?= count($aProducts) ?></strong></div><?php
    $i = 4;
    foreach ($aProducts as $oProduct) {
        $sName = $oProduct->field_product_name['und'][0]['value'];
        $sRef = $oProduct->field_product_ref['und'][0]['value'];
        if ($i % 4 == 0) {
            ?>
            <div class = "col-md-12 padding-0"><?php }
        ?>
            <div class = "block-product col-md-3">
                <div class = "thumbnail">
                    <a href = "<?= url('taxonomy/term/' . $oProduct->tid) ?>" title = "">
                        <img src = "<?= file_create_url($oProduct->field_thumbnail['und'][0]['uri']) ?>" alt = "" title = "" />
                        <div class = "ref-product"><?= ($sRef ? : '') ?></div>
                        <div class = "title-product"><?= $sName ?></div>
                    </a>
                </div>
            </div><?php
            $i++;
            if ($i % 4 == 0) {
                ?>
            </div><?php
        }
    }
} else {
    ?>
    <div class="alert alert-warning" role="alert"><strong>Oops!..</strong> There is currently no products that match with your criteria</div><?php
}
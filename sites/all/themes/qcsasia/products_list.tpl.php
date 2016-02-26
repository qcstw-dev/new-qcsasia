<?php
echo "<ul>";
foreach ($aProducts as $oProduct) {
    echo '<li><a href="' . url(entity_uri('taxonomy_term', $oProduct)['path']) . '" title="'.$oProduct->name.'">' . $oProduct->name . '</li>';
}
echo "</ul>";
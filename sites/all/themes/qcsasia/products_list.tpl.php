<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


echo "<ul>";
foreach ($aProducts as $oProduct) {
    echo '<li><a href="' . drupal_get_path_alias(entity_uri('taxonomy_term', $oProduct)['path']) . '" >' . $oProduct->name . '</li>';
}
echo "</ul>";

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


echo "<ul>";
foreach ($aAllProducts as $oProduct) {
    echo '<li><a href="' . url('taxonomy/term/' . $oProduct->tid) . '" >' . $oProduct->name . '</li>';
}
echo "</ul>"; 
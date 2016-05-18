<?php
if (isset($_GET['password'], $_GET['email']) && $_GET['password'] && $_GET['email']) {
    $aUser = connectMember($_GET['email'], $_GET['password']);
    echo json_encode($aUser);
} 
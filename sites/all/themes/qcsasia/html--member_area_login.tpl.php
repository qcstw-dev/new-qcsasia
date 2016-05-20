<?php
$aUser = connectMember($_POST);
echo json_encode($aUser);
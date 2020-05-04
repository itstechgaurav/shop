<?php

include "../includes/global.php";
global $_noti;
if(isLoggedIn()) {
    $user = $_SESSION['user'];
    unset($_SESSION['user']);
    $_noti->set("primary", "I will Miss You $user->name");
}

redirector("../index.php");

?>
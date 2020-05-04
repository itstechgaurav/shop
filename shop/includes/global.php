<?php
include "db.php";
include "function.php";
include "Query.php";
include "Pagination.php";
include "Notification.php";
ob_start();
session_start();

// Global initialization

$_noti = new Notification();
global $_noti;
?>
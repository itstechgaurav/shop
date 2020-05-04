<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "cms");

$_LINK = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$_LINK) die("Error in LINK");

function emptyFunction($args) { return $args; }

function query($qry, $function = 'emptyFunction') {
    global $_LINK;
    try {
        $result = mysqli_query($_LINK, $qry);
        if($result === false) throw new Exception(mysqli_error($_LINK));
        return $function($result);
    } catch (Exception $e) {
        echo "<pre>Query Faild: ['$qry']<br>";
    }
}

?>
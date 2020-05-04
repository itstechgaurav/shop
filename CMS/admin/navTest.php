<?php
$allQueryStrings = [];
function initQueryString() {
    global $allQueryStrings;
    $lQueryStrings = $_SERVER['QUERY_STRING'];
    $lQueryStrings = explode("&", $lQueryStrings);
    foreach ($lQueryStrings As $one) {
        $lOne = explode("=", $one);
        $allQueryStrings[$lOne[0]] = $lOne[1];
    }
}
function updateQueryStrings($key, $value) {
    global $allQueryStrings;
    $allQueryStrings[$key] = $value;
}
function getQueryString() {
    global $allQueryStrings;
    $lStr = "?";
    foreach ($allQueryStrings AS $key=>$value) {
        $lStr .= "$key=$value";
        if(end($allQueryStrings) != $value) $lStr .= "&";
    }
    return $lStr;
}
initQueryString();
updateQueryStrings("page", 8);
print_r(getQueryString());

<?php
    $_link = mysqli_connect(
        "localhost",
        "root",
        "",
        "tests"
    );

    function query($qry) {
        global $_link;
        return mysqli_query($_link, $qry);
    }

    include("bcrypt.php");
?>
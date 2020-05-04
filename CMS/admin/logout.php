<?php include __DIR__ . '\..\includes\global.php'; ?>

<?php
if(isset($_SESSION['user'])) {
    $_SESSION = array();
}
return header("Location: ../index.php");
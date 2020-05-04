<?php

include "includes/global.php";
include "includes/notificationAlerts.php";
global $notifications;

$user = new Query('users');
$user->selectWhere(['email' => $_POST['email']]);
if(checkPassword(trim($_POST['password']), $user->password)) {
    if($user->id > 0) {
        $_SESSION['user'] = Objecter::__classObjToObj($user);
        $notifications->set('info', "Welcome back, " . $user->name);
        redirector("admin/" . ($user->role == 'admin' ? 'index.php' : 'posts.php'));
    }
    $notifications->set('danger', "wrong credentials");
    redirector("index.php");
}
$notifications->set('danger', "wrong credentials");
redirector("index.php");

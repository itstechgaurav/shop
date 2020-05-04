<?php include "includes/global.php"; ?>
<?php
global $_noti;

if(isAdmin()) redirector("admin/index.php");
else if(isLoggedIn() && !isAdmin()) {
    $_noti->set("warning", "Only Admins Are Allowed");
    redirector("index.php");
};

if(isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $user = new Query('users');
    $user->selectWhere(['email' => $email]);
    if($user->email == $email) {
        if(password_verify($password, $user->password)) {
            $_SESSION['user'] = Objecter::__classObjToObj($user);
            $_noti->set("success", "Hi, $user->name <br> Nice to See You Again :)");
            if(isAdmin()) redirector("admin/index.php");
            else redirector("index.php");
        } else {
            $_noti->set("danger", "Wrong Credentials");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MYSHOP - Login</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-12">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0 row">
                    <!-- Nested Row within Card Body -->
                    <div class="row w-100">
                        <div class="col-12">
                            <form action="" method="post" class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form action="" method="post" class="user">
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <div name="password" class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                    </div>
<!--                                    <div class="form-group">-->
<!--                                        <div class="custom-control custom-checkbox small">-->
<!--                                            <input type="checkbox" class="custom-control-input" id="customCheck">-->
<!--                                            <label class="custom-control-label" for="customCheck">Remember Me</label>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <button name="login" href="" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register.php">Create an Account!</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>
<script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="admin/js/sb-admin-2.min.js"></script>

<?php
include "includes/notificationAlerts.php";
?>

</body>

</html>

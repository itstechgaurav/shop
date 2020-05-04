<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

<?php
    if(isset($_SESSION['user'])) {
        $notifications->set('danger', 'Logout First');
        redirector('index.php');
    }

?>


<?php
    if(isset($_POST['register'])) {
        $user = new Query('users');
        $user->selectWhere(['email' => $_POST['email']]);
        if($user->email == $_POST['email']) {
            $notifications->set('danger', 'User already exist');
            redirector("index.php");
        }
        $user->setdata($_POST);
        $user->role = 'subscriber';
        $user->image = 'default-logo.png';
        $user->password = encryptPassword(trim($_POST['password']));
        $user->insert();
        global $notifications;
        $notifications->set('info', 'User created');
        redirector("index.php");
    }

?>


    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <section id="login">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="form-wrap">
                                <h1>Register</h1>
                                <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                    <div class="form-group">
                                        <label for="username" class="sr-only">username</label>
                                        <input type="text" name="name" id="username" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email: xyz@abc.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="sr-only">Password</label>
                                        <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    </div>

                                    <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                                </form>

                            </div>
                        </div> <!-- /.col-xs-12 -->
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </section>
        </div>

    </div>
        <!-- /.row -->
<?php include "includes/footer.php";?>
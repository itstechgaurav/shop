<?php

if(isset($_POST['edit-user'])) {
    global $_noti;
    $user = new Query("users", $_GET['id']);
    $oldPass = $user->password;
    $_POST['password'] = trim($_POST['password']);
    $_POST['email'] = trim($_POST['email']);
    $user->setdata($_POST);
    if((strlen($_POST['password']) < 4) && $_POST['password'] != "") { // New Password But length < 4
        $_noti->set("warning", "Password: Should be more then 4 characters");
        redirector();
    } else if($_POST['password'] != "") { // New password Length > 4
        $user->password = encryptPassword($_POST['password']);
    } else { // old password
        $user->password = $oldPass;
    }
    $user->update();
    $_noti->set("primary", "User Updated");
    redirector("?");
}
?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit User</h1>
        </div>
        <div class="user">
            <?php
                $user = new Query('users', $_GET['id']);
                echo  template($user,
                    '
                        <div class="form-group">
                            <label for="">User Name</label>
                            <input name="name" type="text" class="form-control form-control-user" placeholder="" value="{{name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">User Email</label>
                            <input name="email" type="email" class="form-control form-control-user" placeholder="" value="{{email}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">User Password</label>
                            <input name="password" type="password" class="form-control form-control-user" placeholder="" value="">
                        </div>
                        <button class="btn btn-primary btn-user btn-block" name="edit-user">
                            Edit User
                        </button>
                    '
                );
            ?>
        </div>
    </div>
</form>
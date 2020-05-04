<?php

if(isset($_POST['addUser'])) {
    $user = new Query('users');
    $data = new Objecter($_FILES['image']);
    $user->setdata($_POST);
    $user->setdata(['image' => time() . "-Profile-" . $data->name]);
    move_uploaded_file($data->tmp_name, realpath('./../images/') . "/" . $user->image);
    $user->insert();
    header("Location: ?");
}

?>


<div class="row">
    <?php topHeader('Users', 'add user'); ?>
    <div class="col-lg-12 box">
        <h2 class="tac">
            Add User
        </h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Name</label>
                <input name="name" type="text" class="form-control" placeholder="(divya pancholi)">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input name="email" type="text" class="form-control" placeholder="ninja@gmail.com">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input name="password" type="text" class="form-control" placeholder="xxxxxxx">
            </div>
            <div class="form-group">
                <label for="">Role</label>
                <select name="role" id="" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="subscriber">Subscriber</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Image</label>
                <input name="image" type="file" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-info" type="submit" name="addUser">Add User</button>
            </div>
        </form>
    </div>
</div>
<?php



if(isset($_POST['editUser'])) {
    updateUser($_GET['id']->id);
}



?>


<div class="row">
    <?php topHeader('Users', 'edit user'); ?>
    <div class="col-lg-12 box">
        <h2 class="tac">
            Edit User
        </h2>
        <form action="" method="post" enctype="multipart/form-data">
            <?php
                $id = $_GET['id'];
                $selected = "";
                templateFunction("SELECT * FROM users WHERE id = '$id'", function($res) use ($selected) {
                    $selected = $res->role;
                    return '
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control" placeholder="(divya pancholi)" value="{{name}}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="ninja@gmail.com" value="{{email}}">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="xxxxxxx" value="{{password}}">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input name="image" type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit" name="editUser">Edit User</button>
                        </div>
                        ';
                });
            ?>
        </form>
    </div>
</div>
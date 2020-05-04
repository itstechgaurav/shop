<?php

if(isset($_POST['add-user'])) {
    registerUser('admin');
}

?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Add User</h1>
        </div>
        <div class="user">
            <div class="form-group">
                <label for="">User Name</label>
                <input name="name" type="text" class="form-control form-control-user" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">User Email</label>
                <input name="email" type="email" class="form-control form-control-user" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">User Password</label>
                <input name="password" type="password" class="form-control form-control-user" placeholder="" required>
            </div>
            <button class="btn btn-primary btn-user btn-block" name="add-user">
                Add User
            </button>
        </div>
    </div>
</form>
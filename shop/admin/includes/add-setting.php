<?php
global $_noti;
if(isset($_POST['add-setting'])) {
    $setting = new Query('settings');
    $setting->setdata($_POST);
    $setting->insert();
    $_noti->set("success", "Setting Added");
    redirector("?");
}

?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Add Setting</h1>
        </div>
        <div class="user">
            <div class="form-group">
                <label for="">Setting Name</label>
                <input name="name" type="text" class="form-control form-control-user" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">Setting Value</label>
                <input name="value" type="text" class="form-control form-control-user" placeholder="" required>
            </div>
            <button class="btn btn-primary btn-user btn-block" name="add-setting">
                Add Setting
            </button>
        </div>
    </div>
</form>
<?php
global $_noti;
if(isset($_POST['edit-setting'])) {
    $setting = new Query('settings', $_GET['id']);
    $setting->setdata($_POST);
    $setting->update();
    $_noti->set("success", "Setting Updated");
    redirector("?");
}

?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit Setting</h1>
        </div>
        <div class="user">
            <?php
                $setting = new Query('settings', $_GET['id']);

                echo template($setting, '
                    <div class="form-group">
                        <label for="">Setting Name</label>
                        <input name="name" type="text" class="form-control form-control-user" placeholder="" value="{{name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">Setting Value</label>
                        <input name="value" type="text" class="form-control form-control-user" placeholder="" value="{{value}}" required>
                    </div>
                ');
            ?>
            <button class="btn btn-primary btn-user btn-block" name="edit-setting">
                Edit Setting
            </button>
        </div>
    </div>
</form>
<?php

if(isset($_POST['add-cat'])) {
    $category = new Query("categories");;
    $category->setdata($_POST);

    $image = new Objecter($_FILES['image']);
    $category->image = time() . "-category-" . $image->name;
    move_uploaded_file($image->tmp_name, realpath('./../uploads/') . "/" . $category->image);
    $category->insert();
    redirector("?");
}
?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Add category</h1>
        </div>
        <div class="user">
            <div class="form-group">
                <label for="">Category Name</label>
                <input name="name" type="text" class="form-control form-control-user" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">Category Image</label>
                <input name="image" type="file" class="form-control" placeholder="Category image" required>
            </div>
            <button class="btn btn-primary btn-user btn-block" name="add-cat">
                Add Category
            </button>
        </div>
    </div>
</form>
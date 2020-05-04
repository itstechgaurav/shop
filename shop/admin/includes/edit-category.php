<?php

if(isset($_POST['edit-cat'])) {
    $category = new Query("categories", $_GET['id']);
    $category->setdata($_POST);
    $image = new Objecter($_FILES['image']);
    if(is_uploaded_file($image->tmp_name) && file_exists($image->tmp_name)) {
        delImage($category->image);
        $category->image = time() . "-category-" . $image->name;
        move_uploaded_file($image->tmp_name, realpath('./../uploads/') . "/" . $category->image);
    }
    $category->update();
    redirector("?source=all");
}
?>

<form method="post" action="" enctype="multipart/form-data" class="col-lg-6 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit category</h1>
        </div>
        <div class="user">
            <?php
                $category = new Query('categories', $_GET['id']);
                echo template($category,
                    '
                        <div class="form-group">
                            <label for="">Category Name</label>
                            <input name="name" type="text" class="form-control form-control-user" placeholder="" value="{{name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Category Image</label>
                            <br>
                                <img src="../uploads/{{image}}" class="w-100 rounded mb-3" alt="">
                            <input name="image" type="file" class="form-control" placeholder="Category image">
                        </div>
                        <button class="btn btn-primary btn-user btn-block" name="edit-cat">
                            Edit Category
                        </button>
                    '
                );
            ?>
        </div>
    </div>
</form>
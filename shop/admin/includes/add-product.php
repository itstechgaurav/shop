<?php

if(isset($_POST['add-product'])) {
    global $_noti;
    $product = new Query('products');
    $product->setdata($_POST);
    $product->status = 'active';
    $product->user_id = $_SESSION['user']->id;
    $image = new Objecter($_FILES['image']);
    $product->image = time() . "-product-main-image-" . $image->name;
    move_uploaded_file($image->tmp_name, realpath('./../uploads/') . "/$product->image");
    $product->insert();

    // insert images

    $_img = new Query('images');
    $_img->product_id = $product->getLastInsertedId();
    $_img->image = $product->image;
    $_img->insert();

    // insert categories

    if(isset($_POST['categories_id'])) {
        foreach ($_POST['categories_id'] AS $cat_id) {
            $product_categories = new Query('product_categories');
            $product_categories->product_id = $product->getLastInsertedId();
            $product_categories->category_id = $cat_id;
            $product_categories->insert();
        }
    }
    $_noti->set("primary", "Product added");
    redirector("?source=all");
}

?>

<form method="post" action="" enctype="multipart/form-data" class="col-10 col-sm-11 col-xs-12 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
        </div>
        <div class="user">
            <div class="form-group">
                <label for="">Product Name</label>
                <input name="name" type="text" class="form-control form-control-user" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">Add Some Categories</label>
                <div>
                    <?php
                        $categories = new Query('categories');
                        $categories->preSelect('SELECT *')->get();
                        echo '<div class="row w-100">';
                        echo templateIterator($categories->rows,
                            function() {
                                return '
                                    <label class="col-xl-4 col-lg-5 col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" class="form-control-sm" name="categories_id[]" value="{{id}}" id="">
                                         <img src="../uploads/{{image}}" class="rounded-circle" width="50" height="50" alt="">
                                        <br><span class="w-100 badge badge-pill badge-secondary ">{{name}}</span>
                                    </label>
                                ';
                            }
                        );
                        echo '</div>';
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="">Product Tags</label>
                <input name="tags" type="text" class="form-control" placeholder="tag-1, tag-2, tag-n , ...." required>
            </div>
            <div class="form-group">
                <label for="">Product Brief Description</label>
                <input name="brief" type="text" class="form-control" placeholder="A brief intro about Product" required>
            </div>
            <div class="form-group">
                <label for="">Product Image</label>
                <input name="image" type="file" class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="">Product Content</label>
                <textarea name="content" class="form-control" id="summernote" cols="30" rows="10"></textarea>
            </div>
            <button class="btn btn-primary btn-user btn-block" name="add-product">
                Add Product
            </button>
        </div>
    </div>
</form>

<!-- Summernote WYSIWYG -->

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
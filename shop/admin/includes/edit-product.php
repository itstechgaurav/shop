<?php
global $_noti;
if(isset($_POST['edit-product'])) {
    $product = new Query('products', $_GET['id']);
    $product->setdata($_POST);
    $image = new Objecter($_FILES['image']);
    if(is_uploaded_file($image->tmp_name) && file_exists($image->tmp_name)) {
        delImage($product->image);
        $product->image = time() . "-product-main-image-" . $image->name;
        move_uploaded_file($image->tmp_name, realpath('./../uploads/') . "/" . $product->image);
    }
    $product->update();
    $product_categories = new Query('product_categories');
    $product_categories->selectWhere(['product_id' => $product->id]);
    foreach ($product_categories->rows AS $_PC) {
        $_PC->delete();
    }
    if(isset($_POST['categories_id'])) {
        foreach ($_POST['categories_id'] AS $cat_id) {
            $product_categories = new Query('product_categories');
            $product_categories->product_id = $product->id;
            $product_categories->category_id = $cat_id;
            $product_categories->insert();
        }
    }
    $_noti->set("primary", "Product: Updated");
    redirector("?");
}

?>

<form method="post" action="" enctype="multipart/form-data" class="col-10 col-sm-11 col-xs-12 card o-hidden border-0 shadow-lg my-5 mx-auto">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
        </div>
        <div class="user">
            <?php
                $product = new Query('products', $_GET['id']);
            ?>
                <div class="form-group">
                    <label for="">Product Name</label>
                    <input name="name" type="text" class="form-control form-control-user" placeholder="" value="<?php echo $product->name; ?>" required>
                </div>
                <?php
                    function checkIsAvailable($array, $id) {
                        $found = false;
                        foreach ($array As $itm) {
                            $found = $itm->category_id == $id;
                            if($found) break;
                        }
                        return $found;
                    }
                    $categories = new Query('categories');
                    $categories->preSelect('SELECT *')->get();
                    $product_categories = new Query('product_categories');
                    $product_categories->selectWhere(['product_id' => $product->id]);
                    echo '<div class="row w-100">';
                    echo templateIterator($categories->rows,
                        function($res) use($product_categories) {
                            $res->checked = checkIsAvailable($product_categories->rows, $res->id) ? "checked" : "";
                            return '
                                <label class="col-xl-4 col-lg-5 col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" class="form-control-sm" name="categories_id[]" value="{{id}}" id="" {{checked}}>
                                     <img src="../uploads/{{image}}" class="rounded-circle" width="50" height="50" alt="">
                                    <br><span class="w-100 badge badge-pill badge-secondary ">{{name}}</span>
                                </label>
                            ';
                        }
                    );
                    echo '</div>';
                ?>
                <div class="form-group">
                    <label for="">Product Tags</label>
                    <input name="tags" type="text" class="form-control" placeholder="tag-1, tag-2, tag-n , ...." required value="<?php echo $product->tags; ?>">
                </div>
                <div class="form-group">
                    <label for="">Product Brief Description</label>
                    <input name="brief" type="text" class="form-control" placeholder="A brief intro about Product" required value="<?php echo $product->brief; ?>">
                </div>
                <div class="form-group">
                    <label for="">Product Image</label>
                    <img src="../uploads/<?php echo $product->image; ?>" class="w-100 rounded" alt="">
                    <input name="image" type="file" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Product Content</label>
                    <textarea name="content" class="form-control" id="summernote" cols="30" rows="10" required><?php echo $product->content; ?></textarea>
                </div>
                <button class="btn btn-primary btn-user btn-block" name="edit-product">
                    Edit Product
                </button>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
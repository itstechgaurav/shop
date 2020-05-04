<?php include "includes/header.php"; ?>


<?php
global $_noti;
if(!isset($_GET['product_id'])) redirector();

if(isset($_FILES['images'])) {
    foreach ($_FILES['images']['name'] AS $index=>$value) {
        $image = new Query('images');
        $image->product_id = $_GET['product_id'];
        $image->image = time() . "-product-images-" . $value;
        move_uploaded_file($_FILES['images']['tmp_name'][$index], "../uploads/" . $image->image);
        $image->insert();
    }
    $count = count($_FILES['images']['name']);
    $msg = $count . " File" . ($count > 1 ? "s" : "") . " Uploaded";
    $_noti->set("success", $msg);
    redirector("");
}

// Delete Images

if(isset($_POST['del-product-image'])) {
    $image = new Query('images', $_POST['del-product-image']);
    $image->delete();
    $_noti->set("success", "Image: Deleted");
    redirector();
}

?>

    <!-- Page Heading -->

<?php topHeader("Images"); ?>

    <!-- Content Row -->

    <div class="row">
        <?php

        if (isset($_POST['del-product-image'])) {
            $image = new Query('images', $_POST['del-product-image']);
            $image->delete();
            redirector();
        }

        ?>

        <div class="card shadow mb-4 mx-auto w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <?php
                        $product = new Query('products', $_GET['product_id']);
                        echo "Product: $product->name";
                    ?>
                </h6>
                <form class="form-inline float-right" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control-sm" type="file" name="images[]" multiple required placeholder="Select">
                        <button class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $images = new Query("images");
                        $images->selectWhere(['product_id' => $_GET['product_id']]);
                        echo templateIterator($images->rows, function () {
                            return '
                                <tr>
                                    <td>{{id}}</td>
                                    <td>
                                        <img class="rounded" src="../uploads/{{image}}" style="max-height: 100px; max-width: 100%" alt="">
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <button name="del-product-image" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i> Delete</button>                                  
                                        </form>                  
                                    </td>
                                </tr>
                            ';
                        })
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <!--Footer -->
<?php include "includes/footer.php"; ?>
<?php

if(isset($_POST['del-product'])) {
    global $_noti;
    $product = new Query('products', $_POST['del-product']);
    $product->delete();
    $product_categories = new Query('product_categories');
    $product_categories->selectWhere(['product_id' => $product->id]);
    foreach ($product_categories->rows AS $_PC) {
        $_PC->delete();
    }
    delImage($product->image);
    $_noti->set("primary", "Product Deleted");
    redirector("?");
}

if(isset($_POST['update-status'])) {
    global $_noti;
    $product = new Query('products', $_POST['update-status']);
    $product->status = $product->status == 'active' ? 'draft' : 'active';
    $product->update();
    $_noti->set("primary", "Product Status Set To: $product->status");
    redirector();
}

?>

<div class="card shadow mb-4 mx-auto w-100">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Images</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $product = new Query("products");
                    $product->preSelect("SELECT *, 
                                                    DATE_FORMAT(created_at, '%D %M %Y') AS date,
                                                    DATE_FORMAT(updated_at, '%D %M %Y') AS updated_on")
                        ->paginate(10)
                        ->get();
                    echo templateIterator($product->rows, function($category) {

                        return '
                            <tr>
                                <td>{{id}}</td>
                                <td>{{name}}</td>
                                <td>
                                    <img src="../uploads/{{image}}" width="60" height="60" class="rounded" alt="">
                                </td>
                                <td class="text-center">{{views}}</td>
                                <td data-toggle="tooltip" data-placement="top" title="Updated ON: {{updated_on}}">{{date}}</td>                       
                                <td>
                                    <a href="productImages.php?product_id={{id}}" class="btn btn-sm btn-primary"> <i class="fas fa-fw fa-plane"></i> View</a>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <button name="update-status" class="btn btn-sm btn-success" value="{{id}}"> <i class="fas fa-fw fa-redo"></i> {{status}}</button>    
                                    </form>
                                </td>
                                <td>
                                    <a href="?source=edit&id={{id}}" class="btn btn-sm btn-info"> <i class="fas fa-fw fa-pen"> </i> Edit</a>                            
                                </td>
                                <td>
                                    <form action="" method="post">
                                      <button name="del-product" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i> Delete</button>                                  
                                    </form>                  
                                </td>
                            </tr>
                        ';
                    })
                ?>
                </tbody>
            </table>
            <?php
                $pagination = new Pagination('products');
                $pagination->render();
            ?>
        </div>
    </div>
</div>
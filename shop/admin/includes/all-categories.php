<?php

if(isset($_POST['del-cat'])) {
    $category = new Query('categories', $_POST['del-cat']);
    $category->delete();
    $product_categories = new Query('product_categories');
    $product_categories->selectWhere(['category_id' => $category->id]);
    foreach ($product_categories->rows AS $row) {
        $row->delete();
    }
    delImage($category->image);
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
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $categories = new Query("categories");
                    $categories->preSelect("SELECT *, 
                                                    DATE_FORMAT(created_at, '%D %M %Y') AS date,
                                                    DATE_FORMAT(updated_at, '%D %M %Y') AS updated_on")
                        ->paginate(10)
                        ->get();

                    echo templateIterator($categories->rows, function($category) {

                        return '
                            <tr>
                                <td>{{id}}</td>
                                <td>{{name}}</td>
                                <td>
                                    <img class="rounded" src="../uploads/{{image}}" style="max-height: 100px; max-width: 100%" alt="">
                                </td>
                                <td data-toggle="tooltip" data-placement="top" title="Updated ON: {{updated_on}}">{{date}}</td>                       
                                <td>
                                    <a href="?source=edit&id={{id}}" class="btn btn-sm btn-info"> <i class="fas fa-fw fa-pen"> </i> Edit</a>                            
                                </td>
                                <td>
                                    <form action="" method="post">
                                      <button name="del-cat" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i> Delete</button>                                  
                                    </form>                  
                                </td>
                            </tr>
                        ';
                    })
                ?>
                </tbody>
            </table>
            <?php
                $pagination = new Pagination('categories');
                $pagination->render();
            ?>
        </div>
    </div>
</div>
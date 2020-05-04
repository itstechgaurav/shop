<?php

if(isset($_POST['del-setting'])) {
    global $_noti;
    $setting = new Query('settings', $_POST['del-setting']);
    $setting->delete();
    $_noti->set("primary", "Setting Deleted");
    redirector("?");
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
                    <th>Value</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $users = new Query("settings");
                    $users->preSelect("SELECT *")
                        ->paginate(10)
                        ->get();
                    echo templateIterator($users->rows, function($category) {

                        return '
                            <tr>
                                <td>{{id}}</td>
                                <td>{{name}}</td>
                                <td>{{value}}</td>
                                <td>
                                    <a href="?source=edit&id={{id}}" class="btn btn-sm btn-info"> <i class="fas fa-fw fa-pen"> </i> Edit</a>                            
                                </td>
                                <td>
                                    <form action="" method="post">
                                      <button name="del-setting" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i> Delete</button>                                  
                                    </form>                  
                                </td>
                            </tr>
                        ';
                    })
                ?>
                </tbody>
            </table>
            <?php
                $pagination = new Pagination('settings');
                $pagination->render();
            ?>
        </div>
    </div>
</div>
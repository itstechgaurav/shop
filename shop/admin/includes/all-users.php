<?php

if(isset($_POST['del-user'])) {
    global $_noti;
    $user = new Query('users', $_POST['del-user']);
    $user->delete();
    $_noti->set("primary", "User Deleted");
    redirector("?");
}

if(isset($_POST['update-role'])) {
    global $_noti;
    $user = new Query('users', $_POST['update-role']);
    $user->role = $user->role == 'admin' ? 'local' : 'admin';
    $user->update();
    $_noti->set("primary", "User Role Set To: $user->role");
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
                    <th>Email</th>
                    <th>Date</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $users = new Query("users");
                    $users->preSelect("SELECT *, 
                                                    DATE_FORMAT(created_at, '%D %M %Y') AS date,
                                                    DATE_FORMAT(updated_at, '%D %M %Y') AS updated_on")
                        ->paginate(10)
                        ->get();
                    echo templateIterator($users->rows, function($category) {

                        return '
                            <tr>
                                <td>{{id}}</td>
                                <td>{{name}}</td>
                                <td>{{email}}</td>
                                <td data-toggle="tooltip" data-placement="top" title="Updated ON: {{updated_on}}">{{date}}</td>                       
                                <td>
                                    <form action="" method="post">
                                        <button name="update-role" class="btn btn-sm btn-success" value="{{id}}"> <i class="fas fa-fw fa-redo"></i> {{role}}</button>    
                                    </form>
                                </td>
                                <td>
                                    <a href="?source=edit&id={{id}}" class="btn btn-sm btn-info"> <i class="fas fa-fw fa-pen"> </i> Edit</a>                            
                                </td>
                                <td>
                                    <form action="" method="post">
                                      <button name="del-user" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i> Delete</button>                                  
                                    </form>                  
                                </td>
                            </tr>
                        ';
                    })
                ?>
                </tbody>
            </table>
            <?php
                $pagination = new Pagination('users');
                $pagination->render();
            ?>
        </div>
    </div>
</div>
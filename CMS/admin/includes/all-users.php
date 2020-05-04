<?php

if(isset($_POST['user_delete_id'])) {
    $user = new Query('users', $_POST['user_delete_id']);
    $user->delete();
    header("Location: users.php");
}

if(isset($_GET['role_id'])) {
    $user = new Query('users', $_GET['role_id']);
    $user->role = $user->role == 'admin' ? 'subscriber' : 'admin';
    $user->update();
}

?>



<div class="row">
    <?php topHeader('users', 'all users'); ?>
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Image</th>
                <th scope="col">Role</th>
                <th scope="col">Date</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $users = new Query("users");
                $users->preSelect("SELECT * ")
                    ->paginate(10)
                    ->get();
                echo templateIterator($users->rows, function() {
                    return '
                        <tr>
                            <td scope="row">{{name}}</td>
                            <td scope="row">{{email}}</td>
                            <td scope="row" style="text-align: center">
                                <img width="30" height="30" style="border-radius: 50%;" src="../images/{{image}}" alt="">
                            </td>
                            <td scope="row">
                                <a href="?role_id={{id}}" class="btn btn-sm btn-info">
                                    <span class="glyphicon glyphicon-refresh"></span> &nbsp;{{role}}
                                </a>                  
                            </td>
                            <td scope="row">{{created_at}}</td>
                            <td>
                                <a href="?source=edit&id={{id}}" class="btn btn-sm btn-warning">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <button name="user_delete_id" type="submit" value="{{id}}" class="btn btn-sm btn-danger">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    ';
                });
            ?>
            </tbody>
        </table>
        <?php
            $pagination = new Pagination('users');
            $pagination->render();
        ?>
    </div>
</div>
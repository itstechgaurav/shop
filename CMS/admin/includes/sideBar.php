<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <?php  // only admin access
        if($_SESSION['user']->role == 'admin') {
            echo  '
                <li>
                    <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="users" class="collapse">
                        <li>
                            <a href="users.php?source=add">Add User</a>
                        </li>
                        <li>
                            <a href="users.php">Show All</a>
                        </li>
                    </ul>
                </li>
            ';
        }
        ?>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-newspaper-o"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="posts" class="collapse">
                <li>
                    <a href="posts.php?source=add">Add Post</a>
                </li>
                <li>
                    <a href="posts.php">Show All</a>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
        </li>
    </ul>
</div>
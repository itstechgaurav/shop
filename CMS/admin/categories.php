
<?php include "includes/header.php"; ?>
<?php onlyAdmins(); ?>
<?php
$msg = "Add";
$cat_name = '';
if(isset($_POST['cat_name_updated'])) {
    $cat = new Query('categories', $_GET['edit_id']);
    $cat->name = $_POST['cat_name_updated'];
    $cat->update();
    $notifications->set("info", "Updated to: " . $cat->name);
    redirector("?");
} else if(isset($_GET['edit_id'])) {
    $cat = new Query('categories', $_GET['edit_id']);
    $msg = "Edit";
    $cat_name = $cat->name;
} else if(isset($_POST['cat_name'])) {
    $cat = new Query('categories');
    $cat->name = $_POST['cat_name'];
    if(strlen(trim($cat->name))) {
        $cat->insert();
        $notifications->set("info", "created new one: " . $cat->name);
        redirector();
    }
    else {
        $notifications->set("danger", "Fields Should Not Be Empty");
        redirector();
    };
} elseif (isset($_POST['cat_delete'])) {
    $cat = new Query('categories');
    $cat->id = $_POST['cat_delete'];
    $cat->delete();
    $notifications->set("info", "Category deleted");
    redirector();
}

?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <?php include "includes/nav.php"; ?>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <?php include "includes/sideBar.php"; ?>
    <!-- /.navbar-collapse -->

</nav>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Categories
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-wrench"></i>  <a href="categories.php">Categories</a>
                    </li>
                </ol>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="well">
                            <h4><?php echo $msg; ?> Category</h4>
                            <form method="post" action="" class="input-group">
                                <input name="<?php echo ($msg == 'Add') ? 'cat_name' : 'cat_name_updated' ?>" type="text" class="form-control" value="<?php echo $cat_name; ?>">
                                <span class="input-group-btn">
                                        <button class="btn btn-default btn-primary" type="submit">
                                                <span class="glyphicon glyphicon-<?php echo ($msg == 'Add' ? 'plus' : 'check') ?>"></span>
                                        </button>
                                </span>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $categories = new Query('categories');
                                    $categories->preSelect("SELECT * ")
                                        ->paginate()
                                        ->get();
                                    echo templateIterator($categories->rows, function () {
                                        return '
                                            <tr>
                                                <th scope="row">{{id}}</th>
                                                <td>{{name}}</td>
                                                <td>
                                                    <a href="?edit_id={{id}}" class="btn btn-sm btn-warning">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="" method="post">
                                                        <button name="cat_delete" type="submit" value="{{id}}" class="btn btn-sm btn-danger">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>
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
        </div>
        <!-- /.row -->
        <div class="row">

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
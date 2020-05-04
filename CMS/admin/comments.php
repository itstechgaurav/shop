<?php include "includes/header.php"; ?>

<?php
    global $notifications;

    if(isset($_GET['comment_status'])) {
        $comment = new Query('comments', $_GET['comment_status']);
        if($comment->status == 'approved') $comment->status = 'not approved';
        else $comment->status = 'approved';
        $comment->update();
        $notifications->set("info", "Comment Flag: " . $comment->status);
        redirector();
    }

    if(isset($_POST['comment_delete_id'])) {
        $comment = new Query('comments', $_POST['comment_delete_id']);
        $comment->delete();
        $notifications->set("info", "Comment Deleted");
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
            <div class="content-fluid">

                <div class="row">

                    <?php
                        $name = "all";
                        if(isset($_GET['post_id'])) {
                            $post = new Query('posts', $_GET['post_id']);
                            $name = $post->title;
                        }
                        topHeader('comments', $name);
                    ?>
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Post Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $comments = new Query('comments');
                            $comments->preSelect("SELECT comments.*, users.name, posts.title")
                                ->postSelect(" INNER JOIN users ON comments.user_id = users.id")
                                ->postSelect(" INNER JOIN posts ON comments.post_id = posts.id");
                                if(isset($_GET['post_id'])) {
                                    $comments->postSelect("WHERE post_id = " . $_GET['post_id']);
                                    if(!isAdmin()) {
                                        $comments->postSelect("AND comments.user_id = " . $_SESSION['user']->id);
                                    }
                                } else if(!isAdmin()) {
                                    $comments->postSelect("WHERE comments.user_id = " . $_SESSION['user']->id);
                                }
                                $comments->postSelect("ORDER BY id DESC")
                                    ->paginate()
                                    ->get();
                            echo templateIterator($comments->rows, function() {
                                return '
                                <tr>
                                    <td scope="row">
                                        <a href="?post_id={{post_id}}">{{title}}</a>
                                    </td>
                                    <td scope="row">{{name}}</td>
                                    <td scope="row">
                                        <a href="?comment_status={{id}}" class="btn btn-sm btn-info">
                                            <span class="glyphicon glyphicon-refresh"></span> &nbsp;{{status}}
                                        </a>
                                    </td>
                                    <td scope="row">{{created_at}}</td>
                                    <td>
                                        <form action="" method="post">
                                            <button name="comment_delete_id" type="submit" value="{{id}}" class="btn btn-sm btn-danger">
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
                        $pagination = new Pagination('comments');
                        if(!isAdmin()) $pagination->condition("WHERE comments.user_id = " . $_SESSION['user']->id);
                        if(isset($_GET['post_id'])) $pagination->condition("AND post_id = " . $_GET['post_id']);
                        $pagination->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
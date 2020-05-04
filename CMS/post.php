<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
                if($logedIn) {
                    $post = new Query("posts", $_GET['id']);
                    if($_SESSION['user']->role == 'admin' || $post->user_id == $_SESSION['user']->id) {
                        $id = $_GET['id'];
                        echo "<a href='admin/posts.php?id=$id&source=edit' class='btn btn-primary'>Edit</a>";
                    }
                }
            ?>
            <?php
                $id = $_GET['id'];
                templateAuto("SELECT posts.*, users.name AS user_name FROM posts
                                    INNER JOIN users ON posts.user_id = users.id
                                    WHERE posts.id = '$id'",'
                    <h1>{{title}}</h1>
        
                    <!-- Author -->
                    <p class="lead">
                        by <a href="#">{{user_name}}</a>
                    </p>
        
                    <hr>
        
                    <!-- Date/Time -->
                    <p><span class="glyphicon glyphicon-time"></span> Posted on {{created_at}}</p>
        
                    <hr>
        
                    <!-- Preview Image -->
                    <img class="img-responsive" src="images/{{image}}" alt="">
        
                    <hr>
        
                    <!-- Post Content -->
                    <p class="lead">
                        {{content}}
                    </p>
                ');
            ?>
            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->

            <?php
                if($logedIn) include "includes/commentMaker.php";
                else echo "<h4 style='color: coral; border: 1px solid coral; text-align: center; padding: 20px 0;'>please login to post comments</h4>";
            ?>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->



            <!-- Comment -->
            <?php
                $pid = $_GET['id'];
                templateFunction("SELECT comments.*, users.name, users.image FROM comments
                                      INNER JOIN users ON comments.user_id = users.id
                                      WHERE comments.post_id = '$pid'
                                            AND
                                            comments.status = 'approved'",
                    function($res) {
                        return '
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img width="64" height="64" style="border-radius: 50%;" class="media-object" src="images/{{image}}" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{name}}
                                        <small>{{created_at}}</small>
                                    </h4>
                                    {{content}}
                                </div>
                            </div>
                            <hr>
                        ';
                    }
                );

            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
            <?php include "includes/sideBar.php";?>
        </div>

    </div>
    <!-- /.row -->
    <?php include "includes/footer.php";?>

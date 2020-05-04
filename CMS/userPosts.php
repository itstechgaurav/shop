<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <?php
            $user = new Query('users', $_GET['id']);
        ?>
        <div class="jumbotron">
            <h2 class="text-center">All Posts By , <?php echo explode(" ", $user->name)[0] ?></h2>
        </div>
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
                $id = $_GET['id'];
                templateAuto("SELECT posts.*, users.name AS user_name FROM posts
                                  INNER JOIN users ON posts.user_id = users.id
                                   WHERE user_id = '$id'", '
                    <h2>
                        <a href="post.php?id={{id}}">{{title}}</a>
                    </h2>
                    <p class="lead">by Master {{user_name}}</p>
                    <p><span class="glyphicon glyphicon-time"></span> {{created_at}}</p>
                    <hr>
                    <img class="img-responsive" src="images/{{image}}" alt="">
                    <hr>
                    <a class="btn btn-primary" href="post.php?id={{id}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                ');
            ?>
            <hr>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
            <?php include "includes/sideBar.php";?>
        </div>

    </div>
    <!-- /.row -->
    <?php include "includes/footer.php";?>

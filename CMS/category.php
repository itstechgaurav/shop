<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
                $id = $_GET['id'];
                templateAuto("SELECT * FROM posts WHERE category_id = '$id'", '
                    <h2>
                        <a href="post.php?id={{id}}">{{title}}</a>
                    </h2>
                    <p class="lead">by <a href="index.php">{{user_id}}</a></p>
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

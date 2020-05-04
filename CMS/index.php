<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <?php
                if($logedIn && !isset($_GET['page'])) include "includes/jumbotron.php";
            ?>
            <div class="col-md-8">
                <?php
                    $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
                    if($page < 0 || !is_numeric($page)) redirector("?");
                    $page = $page * 5;
                    $posts = new Query('posts');
                    $posts->preSelect("SELECT posts.*, users.name AS user_name ")
                    ->postSelect(" INNER JOIN users ON posts.user_id = users.id");
                    if(!isAdmin()) $posts->postSelect("WHERE posts.status = 'active'");
                    $posts->postSelect("ORDER by RAND()");
                    $posts->postSelect(" LIMIT $page, 5")
                    ->get();
                    foreach($posts->rows AS $post) {
                        echo  template($post, '
                           <h2>
                                <a href="post.php?id={{id}}">{{title}}</a>
                            </h2>
                            <p class="lead">by <a href="userPosts.php?id={{user_id}}">{{user_name}}</a></p>
                            <p><span class="glyphicon glyphicon-time"></span> {{created_at}}</p>
                            <hr>
                            <a href="post.php?id={{id}}"><img class="img-responsive" src="images/{{image}}" alt=""></a>

                            <hr>
                            <a class="btn btn-primary" href="post.php?id={{id}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>
                        ');
                    }
                ?>

                <?php
                    $total = new Query('posts');
                    $total->preSelect("SELECT count(id) AS total");
                    if(!isAdmin()) $total->postSelect("WHERE status = 'active'");
                    $total->get();
                    $total = ceil($total->total / 5);
                    echo "<ul class='pager'>";
                    for($i = 1; $i <= $total; $i++) {
                        if(!isset($_GET['page'])) $_GET['page'] = 1;
                        $is = $i == $_GET['page'] ? 'active' : '';
                        echo "<li class='page-item $is'><a class='page-link' href='?page=$i'>$i</a> </li>";
                    }
                    echo "</ul>";
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <?php include "includes/sideBar.php";?>
            </div>

        </div>
        <!-- /.row -->
<?php include "includes/footer.php";?>
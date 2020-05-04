<?php include "includes/header.php";?>
<?php include "includes/nav.php";?>

<?php
function showSearchResult()
{

    $search_query = null;
    if (isset($_GET['s'])) $search_query = $_GET['s'];
    if ($search_query) {
        query("SELECT * FROM posts WHERE title LIKE '%$search_query%' OR tags LIKE '%$search_query%'", function ($res) {
            global $_LINK;
            if (mysqli_affected_rows($_LINK)) {
                while ($ob = mysqli_fetch_object($res)) {
                    echo template($ob,
                        '<h2>
                            <a href="#">{{title}}</a>
                        </h2>
                            <p class="lead">by <a href="index.php">Start Bootstrap</a></p>
                            <p><span class="glyphicon glyphicon-time"></span>{{created_at}}</p>
                            <hr>
                            <img class="img-responsive" src="images/{{image}}" alt="">
                            <hr>
                            <p>{{content}}</p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>'
                    );
                }
            } else {
                echo "<h3 class='text-muted'>No Record Found</h3>";
            }
        });
    }else {
        echo "<h3 class='text-muted'>No Search Request Found</h3>";
    }
}

    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->

                <?php showSearchResult(); ?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <?php include "includes/sideBar.php"; ?>
            </div>

        </div>
        <!-- /.row -->
<?php include "includes/footer.php"; ?>
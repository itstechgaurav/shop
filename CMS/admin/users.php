<?php include "includes/header.php"; ?>

<?php onlyAdmins(); ?>

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
            <?php
            includer('user');
            ?>
        </div>
    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
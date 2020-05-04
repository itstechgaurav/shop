<?php include "includes/header.php"; ?>
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


            if(isset($_POST['editUser'])) {
                updateUser($_SESSION['user']->id);
            }



            ?>


            <div class="row">
                <?php topHeader('Users', 'profile'); ?>
                <div class="col-lg-12 box">
                    <h2 class="tac">
                        Profile
                    </h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php
                        $id = $_SESSION['user']->id;
                        $selected = "";
                        templateFunction("SELECT * FROM users WHERE id = '$id'", function($res) use ($selected) {
                            $selected = $res->role;
                            return '
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control" placeholder="(divya pancholi)" value="{{name}}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="ninja@gmail.com" value="{{email}}">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input name="password" type="password" class="form-control" value="" placeholder="new password if u want to change it">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <img width="50" src="../images/{{image}}" alt="">
                            <input name="image" type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit" name="editUser">Update Profile</button>
                        </div>
                        ';
                        });
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>
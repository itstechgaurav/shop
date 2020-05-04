<?php
    $_user = new Objecter($_SESSION['user']);
?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.html">SB Admin</a>
</div>
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li>
        <a href="../">HOME</a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img width="20" height="20" style="border-radius: 50%; border: 2px solid dodgerblue; margin-right: 10px;" src="../images/<?php echo $_user->image; ?>" alt="">
            <?php echo $_user->name; ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>
</ul>
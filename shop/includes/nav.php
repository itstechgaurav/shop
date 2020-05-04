
<header class="header trans_300">

    <!-- Top Navigation -->


    <div class="top_nav">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="top_nav_left">free shipping on all orders over 1000rs</div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Navigation -->

    <div class="main_nav_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="logo_container">
                        <?php
                            $siteName = new Query('settings');
                            $siteName->selectWhere(['name' => 'siteName']);
                        ?>
                        <a href="index.php"><?php echo $siteName->rows[0]->value; ?><span><?php echo $siteName->rows[1]->value; ?></span></a>
                    </div>
                    <nav class="navbar">
                        <ul class="navbar_menu">
                            <li><a href="index.php">home</a></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a href="products.php?type=new">New</a></li>
                            <li><a href="products.php?type=best">Best</a></li>
                            <li><a href="contact.php">contact</a></li>
                        </ul>
                        <ul class="navbar_user">
                            <li><a href="search.php"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                            <li><a href="login.php"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="hamburger_container">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</header>

<div class="fs_menu_overlay"></div>

<!-- Hamburger Menu -->

<div class="hamburger_menu">
    <div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="hamburger_menu_content text-right">
        <ul class="menu_top_nav">
            <li class="menu_item"><a href="index.php">home</a></li>
            <li class="menu_item"><a href="categories.php">Categories</a></li>
            <li class="menu_item"><a href="products.php?type=new">New</a></li>
            <li class="menu_item"><a href="products.php?type=best">Best</a></li>
            <li class="menu_item"><a href="contact.php">contact</a></li>
        </ul>
    </div>
</div>

<?php
$products = new Query('products');
$users = new Query('users');
$categories = new Query('categories');
$comments = new Query('comments');

$products->preSelect("SELECT count(id) AS total")->get();
$users->preSelect("SELECT count(id) AS total")->get();
$categories->preSelect("SELECT count(id) AS total")->get();
$comments->preSelect("SELECT count(id) AS total")->get();

?>


<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Products</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $products->total; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-hockey-puck fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $users->total; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Categories</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $categories->total; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-city fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Comments</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $comments->total; ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comment-dots fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
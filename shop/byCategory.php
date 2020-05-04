<?php include "includes/header.php"?>
	<!-- Header -->

<!--	TOP Nav -->

<?php include "includes/nav.php"; ?>

<?php
global $_noti;
if(!isset($_GET['cat_id'])) {
    $_noti->set("warning", "No category Selected");
    redirector();
}
$product_categories = new Query('product_categories');
$product_categories->selectWhere(['category_id' => $_GET['cat_id']]);
$ids = getIds($product_categories->rows, 'product_id');

$products = new Query('products');
$products->preSelect('SELECT *');
$products->postSelect("WHERE status = 'active'");

if(count($product_categories->rows) > 0) {
    $products->postSelect("AND id IN ($ids)");
}
    $products->postSelect("ORDER BY id DESC")
    ->get();

$category = new Query('categories', $_GET['cat_id']);
?>



	<div class="container product_section_container">
		<div class="row">
			<div class="col product_section clearfix">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="categories.php">Categories</a></li>
						<li class="active"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $category->name; ?></a></li>
					</ul>
				</div>

				<!-- Sidebar -->

				<!-- Main Content -->

				<div class="main_content" style="width: 100%">

					<!-- Products -->

					<div class="products_iso">
						<div class="row">
							<div class="col">

								<!-- Product Grid -->

								<div class="product-grid">

									<!-- Product 1 -->

                                    <?php
                                    if(count($product_categories->rows) > 0) {
                                        echo templateIterator($products->rows, function() {
                                            return file_get_contents("includes/productTemplate.php");
                                        });
                                    } else {
                                        echo "<h1 class='text-center text-muted'>No product Found</h1>";
                                    }

                                    ?>

							</div>
                            <div class="col mt-5">
                                <?php
                                if(count($product_categories->rows) > 0) {
                                    $pagination = new Pagination('products');
                                    $pagination->condition("WHERE status = 'active'")
                                        ->condition("AND id IN ($ids)")
                                        ->render();
                                }

                                ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Benefit -->

    <?php include "includes/benifits.php"; ?>

	<!-- Newsletter -->

<!--    --><?php //include "includes/newsletter.php"; ?>

	<!-- Footer -->

<?php include "includes/footer.php"; ?>
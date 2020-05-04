<?php include "includes/header.php"?>
	<!-- Header -->

<!--	TOP Nav -->

<?php include "includes/nav.php"; ?>


<?php

$products = new Query('products');

$products->preSelect("SELECT * ")
    ->postSelect("WHERE status = 'active'");

if($_GET['type'] == 'new') {
    $products->postSelect("ORDER BY id DESC");
}

if($_GET['type'] == 'best') {
    $products->postSelect("ORDER BY views DESC");
}

$products->paginate()->get();

?>



	<div class="container product_section_container">
		<div class="row">
			<div class="col product_section clearfix">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="products.php">Products</a></li>
						<li class="active"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo isset($_GET['type']) ? $_GET['type'] : 'all'; ?></a></li>
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
                                        echo templateIterator($products->rows, function() {
                                            return file_get_contents("includes/productTemplate.php");
                                        });
                                    ?>

							</div>
                            <div class="col mt-5">
                                <?php
                                    $pagination = new Pagination('products');
                                    $pagination->condition("WHERE status = 'active'");
                                    $pagination->render();
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
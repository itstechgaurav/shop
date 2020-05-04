<?php include "includes/header.php"?>
	<!-- Header -->

<!--	TOP Nav -->

<?php include "includes/nav.php"; ?>

	<div class="container product_section_container">
		<div class="row">
			<div class="col product_section clearfix">

				<!-- Breadcrumbs -->

                <form action="" class="mb-5" method="get">
                    <div class="form-group input-group-lg">
                        <input type="search" name="q" class="form-control" placeholder="Search products">
                    </div>
                </form>

				<!-- Sidebar -->

				<!-- Main Content -->

				<div class="main_content" style="width: 100%">

					<!-- Products -->

					<div class="products_iso">
                        <div class="row">
                            <div class="col">
                                <?php
                                    if(isset($_GET['q'])) {
                                        $searching = $_GET['q'];
                                        echo "<h3>Searching: \"<span class='text-primary'>$searching</span>\"</h3>";
                                    }

                                ?>
                            </div>
                        </div>
						<div class="row">
							<div class="col">
								<!-- Product Grid -->

								<div class="product-grid">

									<!-- Product 1 -->

                                    <?php
                                        if(isset($_GET['q'])) {
                                            $qry = $_GET['q'];
                                            $products = new Query('products');
                                            $products->preSelect("SELECT *")
                                                ->postSelect("WHERE tags LIKE '%$qry%'")
                                                ->postSelect("OR name LIKE '%$qry%'")
                                                ->paginate()
                                                ->get();

                                            echo templateIterator($products->rows, function() {
                                                return file_get_contents("includes/productTemplate.php");
                                            });
                                        }
                                    ?>
                                </div>
							</div>
						</div>
                        <div class="row">
                            <div class="col">
                                <?php
                                    if(isset($_GET['q'])) {
                                        $pagination = new Pagination('products');
                                        $pagination->condition("WHERE tags LIKE '%$searching%'")
                                            ->condition("OR name LIKE '%$searching%'")
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
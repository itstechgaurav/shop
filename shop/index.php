<?php include "includes/header.php"; ?>
	<!-- Header -->
    <!-- Nav Menu   -->
    <?php include "includes/nav.php"; ?>

<?php include "includes/carousel.php"; ?>

	<!-- Banner -->
    <div class="row">
        <div class="col text-center">
            <div class="section_title new_arrivals_title mb-5">
                <h2>Top Categories</h2>
            </div>
        </div>
    </div>
	<div class="banner">
		<div class="container">
			<div class="row">
                <?php
                    $categories = new Query('categories');
                    $categories->preSelect("SELECT *")
                            ->paginate(3)
                            ->get();

                    echo templateIterator($categories->rows, function() {
                       return '
                           <div class="col-md-4">
                                <div class="banner_item align-items-center" style="background-image:url(uploads/{{image}})">
                                    <div class="banner_category">
                                        <a href="byCategory.php?cat_id={{id}}">{{name}}</a>
                                    </div>
                                </div>
                            </div>
                       ';
                    });
                ?>
			</div>
		</div>
	</div>

	<!-- New Arrivals -->

	<div class="new_arrivals">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="section_title new_arrivals_title">
						<h2>New Arrivals</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>

						<!-- Product 1 -->

                        <?php
                            $products = new Query('products');
                            $products->preSelect("SELECT *")->paginate(8)->get();

                            echo templateIterator($products->rows, function() {
                                return '
                                    <div class="product-item" style="height: initial !important; overflow: hidden !important">
                                        <a href="product.php?product_id={{id}}" class="product discount product_filter">
                                            <div href="" class="product_image">
                                                <img src="uploads/{{image}}" alt="">
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_name">{{name}}</h6>
                                            </div>
                                        </a>
                                        <div class="red_button add_to_cart_button ml-0 mt-3"><a href="product.php?product_id={{id}}">View</a></div>
                                    </div>  
                                ';
                            })
                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Deal of the week -->

	<!-- Best Sellers -->

	<div class="best_sellers">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="section_title new_arrivals_title">
						<h2>Best Sellers</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="product_slider_container">
						<div class="owl-carousel owl-theme product_slider">

							<!-- Slide 1 -->

                            <?php
                                $products = new Query('products');
                                $products->preSelect("SELECT *")->postSelect("ORDER BY views DESC")->paginate(8)->get();
                                echo templateIterator($products->rows, function() {
                                    return '
                                        <div class="owl-item product_slider_item">
                                            <a href="product.php?product_id={{id}}" class="product-item">
                                                <div class="product discount">
                                                    <div class="product_image">
                                                        <img width="278" height="278" src="uploads/{{image}}" alt="">
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_name"><a href="product.php?product_id={{id}}">{{name}}</a></h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    ';
                                })
                            ?>

						</div>

						<!-- Slider Navigation -->

						<div class="product_slider_nav_left product_slider_nav d-flex align-items-center justify-content-center flex-column">
							<i class="fa fa-chevron-left" aria-hidden="true"></i>
						</div>
						<div class="product_slider_nav_right product_slider_nav d-flex align-items-center justify-content-center flex-column">
							<i class="fa fa-chevron-right" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Benefit -->

	<?php include "includes/benifits.php"; ?>

	<!-- Footer -->
<?php include "includes/footer.php"; ?>
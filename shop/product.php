<?php include "includes/header.php"; ?>
	<!-- Header -->

<?php include "includes/nav.php"; ?>

<?php
    $product = new Query('products', $_GET['product_id']);
    $product->images = [];
    $images = new Query('images');
    $images->selectWhere(['product_id' => $product->id]);
    $product->images = $images->rows;

    $category = new Query('product_categories');
    $category->selectWhere(['product_id' => $product->id]);
    $category = new Query('categories', $category->category_id);

    $product->views = $product->views + 1;
    $product->update();
?>

	<div class="container single_product_container">
		<div class="row">
			<div class="col">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="byCategory.php?cat_id=<?php echo $category->id; ?>"><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $category->name; ?></a></li>
						<li class="active"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $product->name; ?></a></li>
					</ul>
				</div>

			</div>
		</div>

		<div class="row">


			<div class="col-lg-7">
				<div class="single_product_pics">
					<div class="row">
						<div class="col-lg-3 thumbnails_col order-lg-1 order-2">
							<div class="single_product_thumbnails">
								<ul>
                                    <?php
                                        echo templateIterator($product->images, function($res) use ($product) {
                                           $res->activeClass = $res->id == $product->images[0]->id ? "active" : "";
                                            return '
                                                <li class="{{activeClass}}" style="height: initial !important"><img src="uploads/{{image}}" alt="" data-image="uploads/{{image}}"></li>
                                            ';
                                        });
                                    ?>
                                </ul>
							</div>
						</div>
						<div class="col-lg-9 image_col order-lg-2 order-1">
							<div class="single_product_image">
								<div class="single_product_image_background" style="background-image:url(uploads/<?php echo $product->images[0]->image; ?>)"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="product_details">
					<div class="product_details_title">
						<h2 style="text-transform: capitalize"><?php echo strtolower($product->name); ?></h2>
                        <p>
                            <?php echo strtolower($product->brief); ?>
                        </p>
                        <?php
                            $mobile = new Query('settings');
                            $mobile->selectWhere(['name' => 'mobileNumber']);

                            $email = new Query('settings');
                            $email->selectWhere(['name' => 'emailId']);
                        ?>
                        <h3>
                            <a href="tel:<?php echo $mobile->value; ?>"><i class="fa fa-phone-square"> </i> <small class="text-info"><?php echo $mobile->value; ?></small></a>
                        </h3>
                        <h3>
                            <a href="mailto:<?php echo $email->value; ?>"><i class="fa fa-envelope-square"> </i> <small class="text-info"><?php echo $email->value; ?></small></a>
                        </h3>
					</div>
					<div class="free_delivery d-flex flex-row align-items-center justify-content-center">
						<span class="ti-truck"></span><span>free delivery</span>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- Tabs -->

	<div class="tabs_section_container">

		<div class="container">
			<div class="row">
				<div class="col">
					<div class="tabs_container">
						<ul class="tabs d-flex flex-sm-row flex-column align-items-left align-items-md-center justify-content-center">
							<li class="tab active" data-active-tab="tab_1"><span>Description</span></li>
							<li class="tab" data-active-tab="tab_2"><span>Comments</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">

					<!-- Tab Description -->

					<div id="tab_1" class="tab_container active">
                        <div class="tab_title">
                            <h4>Description</h4>
                        </div>
						<div class="row">
							<div class="col-lg-5 desc_col">
								<?php echo $product->content; ?>
							</div>
						</div>
					</div>

					<!-- Tab Reviews -->

					<div id="tab_2" class="tab_container">
						<div class="row">

							<!-- User Reviews -->

							<div class="col-lg-6 reviews_col">
								<div class="tab_title reviews_title">
									<h4>Comments</h4>
								</div>

								<!-- User Review -->

                                <?php
                                    $comments = new Query('comments');
                                    $comments->preSelect("SELECT comments.*, users.name, users.image, DATE_FORMAT(comments.created_at, '%d %M %Y') AS date")
                                             ->postSelect("INNER JOIN users ON comments.user_id = users.id")
                                             ->postSelect("WHERE comments.approved = 'yes'")
                                             ->postSelect("AND comments.product_id = $product->id")
                                             ->postSelect("ORDER BY comments.id DESC")->get();
                                    echo templateIterator($comments->rows, function() {
                                        return '
                                            <div class="user_review_container d-flex flex-column flex-sm-row">
                                                <div class="user">
                                                    <img src="uploads/{{image}}" class="user_pic">
                                                </div>
                                                <div class="review">
                                                    <div class="review_date">{{date}}</div>
                                                    <div class="user_name">{{name}}</div>
                                                    <p>{{content}}</p>
                                                </div>
                                            </div>
                                        ';
                                    })
                                ?>
							</div>

							<!-- Add Review -->

							<div class="col-lg-6 add_review_col">

								<div class="add_review">
									<?php
                                        if(isLoggedIn()) {
                                            include "includes/commentMaker.php";
                                        } else {
                                            echo '<div class="alert alert-info">Please Login To Make Comment</div>';
                                        }
                                     ?>
								</div>

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

<?php //include "includes/newsletter.php"; ?>

	<!-- Footer -->
<?php include "includes/footer.php"; ?>
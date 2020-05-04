<?php include "includes/header.php"; ?>
	<!-- Header -->
    <!-- Nav Menu   -->
    <?php include "includes/nav.php"; ?>
	<!-- Slider -->

    <div style="margin-top: 200px"></div>


    <div class="row">
        <div class="col text-center">
            <div class="section_title new_arrivals_title mb-5">
                <h2>Categories</h2>
            </div>
        </div>
    </div>

	<div class="banner">
		<div class="container">
			<div class="row">
                <?php
                    $categories = new Query('categories');
                    $categories->preSelect("SELECT *")
                            ->get();

                    echo templateIterator($categories->rows, function() {
                       return '
                           <div class="col-md-4 mb-4">
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

	<?php include "includes/benifits.php"; ?>

	<!-- Footer -->
<?php include "includes/footer.php"; ?>
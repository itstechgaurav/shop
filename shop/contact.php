<?php include "includes/header.php" ?>
	<!-- Header -->

    <!--	NAv -->

<?php
    include "includes/nav.php"
?>

	<div class="container contact_container">
		<div class="row">
			<div class="col">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Contact</a></li>
					</ul>
				</div>

			</div>
		</div>

		<!-- Map Container -->
		<!-- Contact Us -->

		<div class="row">

			<div class="col-lg-6 contact_col">
				<div class="contact_contents">
					<h1>Contact Us</h1>
					<p>There are many ways to contact us. You may drop us a line, give us a call or send an email, choose what suits you the most.</p>
					<div>
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
					<div>
						<p>Open hours: 8.00-18.00 Mon-Fri</p>
						<p>Sunday: Closed</p>
					</div>
				</div>

				<!-- Follow Us -->

			</div>

		</div>
	</div>

	<!-- Newsletter -->


	<!-- Footer -->
<?php include "includes/footer.php" ?>
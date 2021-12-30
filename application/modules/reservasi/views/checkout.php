		<!-- Banner -->
		<div class="banner agileits w3layouts">
			<img src="<?php echo base_url('assets/images/banner_booking.jpg');?>" alt="Agileits W3layouts">
			<h1 class="wow agileits w3layouts fadeInDown">RESERVATION FORM</h1>
		</div>
		<!-- //Banner -->

	</div>
	<!-- //Header -->

	<!-- room selected -->
	<?php
		if (empty($_SESSION['cart'])) {
			
		} else {
	?>
	<div class="location agileits w3layouts">
		<div class="container">
			
			<div class="col-md-12 col-sm-12 agileits w3layouts location-grids location-grids-1 wow slideInLeft">
				
				<div class="">
					<h4>Your Room </h4>
					<div class="table-responsive">
					<table class="table agileits w3layouts table-hover">
					
						<thead>
							<tr>
								<th>No</th>
								<th>Room</th>
								<th>Sub Total</th>
								<th>Act</th>
							</tr>
						</thead>
						<tbody>
							<?php $total_all = 0;?>
							<?php $no = 1; foreach($_SESSION['cart'] as $key => $cart):?>
							<tr>
								<td><?php echo $no++;?></td>
								<td><?php echo $cart['nama_room'];?></td>
								<td><?php echo "Rp.", number_format($cart['total'],0, ".", ".");?></td>
								<td>
									<a href="#" class="delete" key-sess="<?php echo $key;?>"><i class="fa fa-trash fa-2x"></i></a>
								</td>
							</tr>
							<?php $total_all += $cart['total'];?>
							<?php endforeach;?>
						</tbody>
					<?php if (empty($_SESSION['cart'])):?>

					<?php else:?>
						<p><b>Total : <?php echo "Rp.", number_format($total_all, 0, ".", ".");?></b></p>
					<?php endif;?>	
					</table>
					<br>
				</div>
				
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- end room selected -->

	<!-- Booking -->
	<div class="reg agileits w3layouts">
		<div class="container">

			<div class="register agileits w3layouts">
			<form action="" method="POST" name="reservasi">
				<h2>Please complete the form below</h2>
				
				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>ID Reservation</h4>
						<input type="hidden" name="date_now" value="<?php echo $date_now;?>">
						<input type="text" name="id_reservasi" value="<?php echo $noauto;?>"  class="dropdown" disabled>
					</div>
				</div>
				
				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Name</h4>
						<input type="text" value="" name="guest_name" class="dropdown" required>
					</div>
				</div>

				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Email</h4>
						<input type="email" value="" name="email" class="dropdown" required>
					</div>
				</div>

				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Phone</h4>
						<input type="number" value="" name="telp" class="dropdown" required>
					</div>
				</div>
				
				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Province</h4>
						<input type="text" value="" name="province" class="dropdown" >
					</div>
				</div>

				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Country</h4>
						<input type="text" value="" name="country" class="dropdown">
					</div>
				</div>

				<div class="place wow  agileits w3layoutsslideInLeft">
					<div class="dropdown-button agileits w3layouts">
						<h4>Company</h4>
						<input type="text" value="" name="company" class="dropdown">
					</div>
				</div>

				<div class="submit wow agileits w3layouts slideInLeft">
					<input type="submit" class="order" value="SEND">
				</div>
			</form>
			</div>

		</div>
	</div>
	<!-- //Booking -->



	<!-- Contact -->
	<div class="contact agileits w3layouts">
		<div class="container">

			<h2 class="wow agileits w3layouts slideInLeft">KEEP IN TOUCH WITH US</h2>
			<p class="contact-p wow agileits w3layouts slideInLeft">Your feedback is highly valued. Get in touch with Pod House Manado and share your comments with us. We are ready to answer your questions.</p>

			<div class="contact-grids agileits w3layouts">

				<div class="col-md-6 col-sm-6 agileits w3layouts contact-grid contact-grid-1">
					<div class="address wow agileits w3layouts slideInLeft">
						<h4>Address</h4>
						<address>
							<ul>
								<li><span class="glyphicon agileits w3layouts glyphicon-map-marker" aria-hidden="true"></span> Jalan Temboan No.11, Winangun Dua Malalayang</li>
								<li><span class="glyphicon agileits w3layouts glyphicon-map-marker" aria-hidden="true"></span> 95115</li>
								<li><span class="glyphicon agileits w3layouts glyphicon-map-marker" aria-hidden="true"></span> Manado</li>
								<li><span class="glyphicon agileits w3layouts glyphicon-map-marker" aria-hidden="true"></span> North Sulawesi, Indonesia</li>
							</ul>
						</address>
					</div>
					<div class="phone wow agileits w3layouts slideInLeft">
						<h4>Phone</h4>
						<p><span class="glyphicon agileits w3layouts glyphicon-earphone" aria-hidden="true"></span> <a href="tel:+628117331191"> +62 811 7331191</a></p>
					</div>
					<div class="email wow agileits w3layouts slideInLeft">
						<h4>Email</h4>
						<p><span class="glyphicon agileits w3layouts glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:mail@example.com"> info@manadopodhouse.com</a></p>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="col-md-6 col-sm-6 agileits w3layouts contact-grid contact-grid-2 wow slideInLeft">
					<form name="contact" action="#" method="POST">
						<input type="text" class="text wow agileits w3layouts slideInLeft" name="nama_contact" placeholder="Name" required="">
						<input type="email" class="text wow agileits w3layouts slideInLeft" name="email_contact" placeholder="Email" required="">
						<input type="number" class="text wow agileits w3layouts slideInLeft" name="telp_contact" placeholder="Phone" required="">
						<textarea name="pesan_contact" class="wow agileits w3layouts slideInLeft" placeholder="Message" required=""></textarea>
						<input type="submit" class="more_btn wow agileits w3layouts slideInLeft" value="Send Message">
					</form>
				</div>
				<div class="clearfix"></div>
				
			</div>

		</div>
	</div>
	<!-- //Contact -->



	<!-- Map-iFrame -->
	<div class="map wow agileits w3layouts slideInUp" id="map">
		<div class="map-hover agileits w3layouts">
			<div style="text-align:center;margin:0 auto;width:100%;"><div style="position:relative;padding-bottom:31.25%;height:0;overflow:hidden;margin:0;"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d880.2249179920775!2d124.83153728741142!3d1.449003099929034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32877490f5e52ced%3A0x605a6ef4a1a1c4e6!2sPod+House+Manado!5e1!3m2!1sid!2sid!4v1517278326497" style="border:0;position:absolute;top:0;left:0;width:100%;height:100%;" allowfullscreen></iframe></div></div>
			<div class="map-hover-1 agileits w3layouts"></div>
		</div>
	</div>
	<!-- //Map-iFrame -->
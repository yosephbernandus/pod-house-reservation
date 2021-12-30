		<!-- Banner -->
		<div class="banner agileits w3layouts">
			<img src="<?php echo base_url('assets/images/banner_booking.jpg');?>" alt="Agileits W3layouts">
			<h1 style="color: black;" class="wow agileits w3layouts fadeInDown">BOOKING & CONTACT</h1>
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
					<?php if (empty($_SESSION['cart'])):?>
					
					<?php else:?>
					<a type="button" href="<?php echo site_url('reservasi/checkout');?>" class="order">Checkout</i></a>
					<br>
					<?php endif;?>
				</div>
				
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- end room selected -->

	<!-- Location -->
	<?php foreach ($room as $row):?>
	<div id="booking">
	<div class="location agileits w3layouts">
		<div class="container">
			
			<form name="validate-date" method="POST" action="">

			<div class="col-md-4 col-sm-4 agileits w3layouts location-grids location-grids-1 wow slideInLeft">
				<div class="reservasi-box">
				<h2 style="font-size: 20px;">Select Your Date</h2>
				<br>
				<div class="book-pag-frm1 agileits wow slideInLeft">
					<label>Check In</label>
					<input style="background-color: #dddddd;" class="date agileits w3layouts" id="datepicker1" name="check_in" value="<?php echo $check_in;?>" type="text" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" required="">
				</div>
				<div class="book-pag-frm2 wow agileits slideInLeft">
					<label>Check Out</label>
					<input style="background-color: #dddddd;" class="date agileits w3layouts" id="datepicker2" value="<?php echo $check_out;?>" name="check_out" type="text" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" required="">
				</div>
				<div class="clearfix"></div>

				<div class="members wow agileits slideInLeft">
					<div class="adult agileits w3layouts">
						<label>Room Amount</label>
						<div class="dropdown-button agileits w3layouts">
							<select  style="background-color: #dddddd;" name="room" class="dropdown agileits w3layouts" tabindex="10" data-settings='{"wrapperClass":"flat"}'>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="submit wow agileits w3layouts slideInLeft">
					<input type="submit" class="order" value="APPLY">
				</div>
				</div>
			</div>
			</form>


			<div class="col-md-8 col-sm-8 agileits w3layouts location-grids location-grids-2 wow slideInRight">
				<div style="padding: 20px;">
					
				
				<form name="checkout" action="<?php echo site_url('reservasi/add');?>" method="POST">
					<h3><?php echo $row->nama_room;?></h3>
					<p><?php echo substr($row->keterangan, 0, 150). '...';?></p>
					<p>Breakfast : <?php echo $row->breakfast;?></p>
					<p>Price : <?php echo "Rp.", number_format($row->harga, 0, ".", ".");?></p>
					<p><b>Total : <?php $total = ($row->harga*$jumlah_room)*$selisih;
					echo "Rp.", number_format($total, 0, ".", ".");?></b></p>
					<p><b><?php echo $selisih;?> Night(s)
					<?php echo $jumlah_room;?> Room(s)</b>
					<input type="hidden" name="selisih" value="<?php echo $selisih;?>">
					<input type="hidden" name="jumlah_room" value="<?php echo $jumlah_room;?>">
					<input type="hidden" name="id_room" value="<?php echo $row->id;?>">
					<input type="hidden" name="nama_room" value="<?php echo $row->nama_room;?>">
					<input type="hidden" name="total" value="<?php echo $total;?>">
					<input type="hidden" name="check_in" value="<?php echo $check_in;?>">
					<input type="hidden" name="check_out" value="<?php echo $check_out;?>">
					<?php if ($row->jumlah_room == 0): ?>
						<button type="submit" class="order-disable"  disabled="true">ROOM FULL</button>
					<?php else :?>
						<button type="submit" class="order">BOOK <i class="fa fa-cart-plus"></i></button>
					<?php endif ;?>
				</form>
				</div>
			</div>
			<div class="clearfix"></div>
			
		</div>
	</div>
	</div>
	<?php endforeach;?>
	<!-- //Location -->


	<!-- Testimoni -->
	<div style="background-color: #eeeeee;" class="contact agileits w3layouts">
		<div class="container">

			<h2 class="wow agileits w3layouts slideInLeft">WRITE YOUR TESTIMONY</h2>
			<p class="contact-p wow agileits w3layouts slideInLeft">Write your testimony and give us a rating for our service here. before sending your testimonials, please make sure you have a reservation and check out first. Thank you.</p>

			<div class="contact-grids agileits w3layouts">
				<div class="col-md-12 col-sm-12 agileits w3layouts contact-grid contact-grid-2 wow slideInLeft">
					<form name="testimoni" action="" method="POST">
						<center>
						<input type="text" class="text wow agileits w3layouts slideInLeft" name="id_booking" placeholder="Booking ID" required="">
						<textarea name="pesan_testimoni" class="wow agileits w3layouts slideInLeft" placeholder="Message" required=""></textarea>
						
						<p class="contact-p wow agileits w3layouts slideInLeft"><b>Rating For Us</b></p>
						<select name="rating" class="wow agileits w3layouts slideInLeft" id="rating">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
						<br>
						<input type="submit" class="more_btn wow agileits w3layouts slideInLeft" value="Send Message">
						</center>
					</form>
				</div>
				<div class="clearfix"></div>
				
			</div>

		</div>
	</div>



	<!-- Contact -->
	<div class="contact agileits w3layouts">
		<div class="container">

			<h2 class="wow agileits w3layouts slideInLeft">KEEP IN TOUCH WITH US</h2>
			<p class="contact-p wow agileits w3layouts slideInLeft"> Your feedback is highly valued. Get in touch with Pod House Manado and share your comments with us. We are ready to answer your questions.</p>

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
						<p><span class="glyphicon agileits w3layouts glyphicon-earphone" aria-hidden="true"></span><a href="tel:+628117331191"> +62 811 7331191</a></p>
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
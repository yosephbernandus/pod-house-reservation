<!-- Slider1 -->
		<div class="slider agileits w3layouts">
			<div class="slider-1 agileits w3layouts">
				<ul class="rslides agileits w3layouts" id="slider1">
				<li>
					<img src="<?php echo base_url('assets/images/banner_home.jpg');?>" alt="Agileits W3layouts">
					<div class="layer agileits w3layouts"></div>
					<div class="caption agileits w3layouts">
						<h3>Welcome To <span>POD HOUSE MANADO</span></h3>
					</div>
				</li>
			</ul>
			</div>
		</div>
		<!-- //Slider1 -->
		<div class="clearfix"></div>

	</div>
	<!-- //Header -->



	<!-- Projects -->
	<div class="projects agileits w3layouts">
		<div class="container">

			<div class="col-md-8 col-sm-8 projects-grid agileits w3layouts projects-grid1 wow slideInLeft">
				<!-- Slider2 -->
				<div class="slider-2 agileits w3layouts">
					<ul class="rslides agileits w3layouts" id="slider2">
						<li>
							<img src="<?php echo base_url('assets/img/Bunaken1.jpg');?>" alt="Agileits W3layouts">
						</li>
						<li>
							<img src="<?php echo base_url('assets/img/1-home.jpg');?>" alt="Agileits W3layouts">
						</li>
					</ul>
				</div>
				<!-- //Slider2 -->

				<!-- Slider3 -->
				<div class="slider-3 agileits w3layouts">
					<ul class="rslides agileits w3layouts" id="slider3">
						<li>
							<img src="<?php echo base_url('assets/img/malalayang.jpg');?>" alt="Agileits W3layouts">
						</li>
						<li>
							<img src="<?php echo base_url('assets/img/2-home.jpg');?>" alt="Agileits W3layouts">
						</li>
					</ul>
				</div>
				<!-- //Slider3 -->
			</div>

			<div class="col-md-4 col-sm-4 projects-grid agileits w3layouts projects-grid2 wow slideInRight">
				<h1>About</h1>
				<h4>Pod House Manado</h4>
				<div class="h4-underline agileits w3layouts wow slideInLeft"></div>
				<p>POD/House is indonesian's first boutique POD catering to discerning travellers who desire fuss-free and convenient living. With 38 cozy PODS inspired by modern and minimalistic living, you can look forward to convenience at your fingertips without compromising on comfort, quality or style. Enjoy complimentary high-speed Wi-Fi access and more. A complete set of amenities ensures effortless living right at the centre of Manado.</p>
			</div>
			
		</div>
	</div>
	<!-- //Projects -->

	<!-- Details -->
	<div class="details agileits w3layouts">
		<div class="container">

			<h3>Facilities</h3>

			<div class="details-grids agileits w3layouts">
				<div class="col-md-4 col-sm-4 details-grid agileits w3layouts details-grid-1 wow slideInUp">
					<div class=" details-grid1 agileits w3layouts">
						<div class="details-grid-info agileits w3layouts">
							
							<p style="font-size: 20px;"><b>POD</b></p>
							<p>
								<i class="fa fa-check"> Fits one comfortably</i><br>
								<i class="fa fa-check"> 2 Pillows</i><br>
								<i class="fa fa-check"> Mattress</i><br>
								<i class="fa fa-check"> Electric Plugs</i><br>
								<i class="fa fa-check"> Curtain</i><br>
							</p>
							
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 details-grid details-grid-2 wow agileits w3layouts slideInUp">
					<div class="details-grid2 agileits w3layouts">
						<div class="details-grid-info agileits w3layouts">
							
							<p style="font-size: 20px;"><b>Bathroom</b></p>
							<p>
								A shared private bathroom is provided on each floor equiped with complimentary soap and shampoo, use of hair dryer.
								Self-contained toilets and water closet separated from shower room.
							</p>
							
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 details-grid agileits w3layouts details-grid-3 wow slideInUp">
					<div class="details-grid3 agileits w3layouts">
						<div class="details-grid-info agileits w3layouts">
							
							<p style="font-size: 20px;"><b>Complimentary</b></p>
							<p>
								<i class="fa fa-check"> Soft Towel</i><br>
								<i class="fa fa-check"> High Speed Internet</i><br>
								<i class="fa fa-check"> Personal Locker</i><br>
								<i class="fa fa-check"> Soap & Shampoo</i><br>
								<i class="fa fa-check"> Mineral Water</i><br>
							</p>
							
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			
		</div>
	</div>
	<!-- //Details -->


	<!-- Testimonials -->
	<div class="custom-testimonial testimonials-container section-container section-container-image-bg wow slideInLeft">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 testimonials section-description">
				<h2 class="testimoni">Our Testimonials</h2>
					<p class="testimoni medium-paragraph">Take a look below to learn what our clients are saying about us:</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 testimonial-list">
					<div role="tabpanel">
						<!-- Tab panes -->
						<div class="tab-content">
							<?php foreach ($testimoni as $k => $row):?>
							<div role="tabpanel" class="tab-pane fade <?php echo $k == 0 ? 'in active' : ''; ?>" id="<?php echo $row->id;?>">
								<div class="testimonial-image">
									<img class="testimoni" src="<?php echo base_url('assets/img/user.jpg');?>" alt="t1">
								</div>
								<div class="testimonial-text">
									<p>
										"<?php echo $row->pesan;?>"<br>
										<?php echo $row->nama;?>, <?php echo $row->company;?>
									</p>
								</div>
							</div>
							<?php endforeach;?>
						</div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<?php foreach ($testimoni as $k => $row):?>
							<li role="presentation" class="<?php echo $k == 0 ? 'active' : ''; ?>">
								<a href="#<?php echo $row->id;?>" aria-controls="<?php echo $row->id
								;?>" role="tab" data-toggle="tab" ></a>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
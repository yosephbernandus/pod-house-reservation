		<!-- Banner -->
		<div class="banner agileits w3layouts">
			<img src="<?php echo base_url('assets/images/banner_room.jpg');?>" alt="Agileits W3layouts">
			<h1 style="color: black;" class="wow agileits w3layouts fadeInDown">POD</h1>
		</div>
		<!-- //Banner -->

	</div>
	<!-- //Header -->



	<!-- Cuisines -->
	<div class="cuisines agileits w3layouts">
		<?php foreach ($room as $row):?>
		<div class="container">
			<div class="col-md-6 col-sm-6 cuisines-grids agileits w3layouts cuisines-grids-1 wow slideInLeft">
				<h2><?php echo $row->nama_room;?></h2>
				<p><?php echo $row->keterangan;?></p>
				<p><b>Count :</b> <?php echo $row->jumlah_room;?></p>
				<p><b>Max Adults :</b> 1</p>
				<p><b>Availability : </b><?php if ($row->jumlah_room != 0):?>
					Available
				<?php else :?>
					Full
				<?php endif;?></p>
			</div>

			<div class="col-md-6 col-sm-6 cuisines-grids agileits w3layouts cuisines-grids-2 wow slideInRight">
				<img class="img-responsive" src="<?php echo base_url('admin/assets/img/room/'.$row->image);?>" alt="Agileits W3layouts">
			</div>
			<div class="clearfix"></div>
		</div>
		<?php endforeach;?>
	</div>
	<!-- //Cuisines -->



	<!-- Specials -->
	<div class="specials agileits w3layouts">

		<h3>Pod Images</h3>

		<div class="specials-grids agileits w3layouts">
			<div class="special-grid agileits w3layouts special-grid-1 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/1-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/1-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid special-grid-2 agileits w3layouts wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/2-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/2-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid agileits w3layouts special-grid-3 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/3-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/3-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid special-grid-5 agileits w3layouts wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/5-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/5-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid special-grid-6 agileits w3layouts wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/6-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/6-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid agileits w3layouts special-grid-7 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/7-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/7-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid agileits w3layouts special-grid-8 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/8-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/8-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid special-grid-9 agileits w3layouts wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/9-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/9-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid agileits w3layouts special-grid-10 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/10-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/10-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="special-grid agileits w3layouts special-grid-11 wow zoomIn">
				<a class="example-image-link agileits w3layouts" href="<?php echo base_url('assets/img/room/11-800x800.jpg');?>" data-lightbox="example-set" data-title="">
					<div class="grid agileits w3layouts">
						<figure class="effect-apollo agileits w3layouts">
							<img src="<?php echo base_url('assets/img/room/11-800x800.jpg');?>" alt="Agileits W3layouts">
								<figcaption></figcaption>
						</figure>
					</div>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<!-- //Specials -->



	<!--menu-->
	<div class="menu">
		<div class="container">
			<div class="menu-tag">
				<h3 class="title">Facilities</h3>
			</div>
			<div class="load_more">
				<ul id="myList">
					<li>
						<div class="l_g">
							<div class="l_g_r g_r">
								<div class="col-md-6 col-sm-6 menu-grids">
									<div class="menu-text wow fadeInLeft">
										<div class="menu-text-left">
											<h4>Bathroom</h4>
											<h6 style="text-align: justify;">
												A shared private bathroom is provided on each floor equiped with complimentary soap and shampoo, use of hair dryer.

												Self-contained toilets and water closet separated from shower room.
											</h6>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="menu-text wow fadeInLeft">
										<div class="menu-text-left">
											<h4>Locker</h4>
											<h6 style="text-align: justify;">
												Personal Lockers under PODs with convenience key access.
											</h6>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 menu-grids">
									<div class="menu-text wow fadeInRight">
										<div class="menu-text-left">
											<h4>Mattress & Pilow</h4>
											<h6 style="text-align: justify;">
												Every Pod equiped with 2 soft pillow and International standard single mattress. The PODs pillow & Mattrass is custom designed to the Pod House exact specification bring the POD HOUSE Guest to experience restful sleep every night. 
											</h6>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="menu-text wow fadeInRight">
										<div class="menu-text-left">
											<h4>Complimentary</h4>
											<h6 style="text-align: justify;">
												<i class="fa fa-check"> Soft Towel</i><br>
												<i class="fa fa-check"> High Speed Internet</i><br>
												<i class="fa fa-check"> Soap & Shampoo</i><br>
												<i class="fa fa-check"> Personal Locker</i><br>
											</h6>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div> 
						</div>
					</li>
				</ul>
				
			</div>
		</div>
	</div>
	<!--//menu-->
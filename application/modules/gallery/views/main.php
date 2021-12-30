
	<style>
		.galleria{ width: 100%; height: 400px; background: #ffffff }
	</style>
		<!-- Banner -->
		<div class="banner agileits w3layouts">
			<img src="<?php echo base_url('assets/images/banner_gallery.jpg');?>" alt="Agileits W3layouts">
			<h1 style="color: black;" class="wow agileits w3layouts fadeInDown">GALLERY</h1>
		</div>
		<!-- //Banner -->

	</div>
	<!-- //Header -->


	<!-- Portfolio -->
	<!-- <div class="rooms agileits w3layouts">
		<div class="container">

		<h2>Our Gallery</h2>
		<div class="ga-top agileits w3layouts"> -->
				
				<!-- <div class="galleria">
				<?php foreach ($gallery as $row):?>
					<a href="<?php echo base_url('admin/assets/img/gallery/'.$row->nama_foto);?>" data-toggle="lightbox"> 
					<img src="<?php echo base_url('admin/assets/img/gallery/thumbnails/'.$row->nama_foto);?>" alt="Agileits W3layouts">
					</a>
					<?php endforeach;?>
				</div> -->
			<!-- <div class="col-md-3 col-sm-3 agileits w3layouts portfolio-top">

				<div class="portfolio-item agileits w3layouts wow zoomIn">
					<a class="example-image-link agileits w3layouts" href="<?php echo base_url('admin/assets/img/gallery/'.$row->nama_foto);?>" data-lightbox="example-set" data-title="">
						<div class="grid agileits w3layouts">
							<figure class="effect-apollo agileits w3layouts">
								<div class="col-md-12">
									<img src="<?php echo base_url('admin/assets/img/gallery/thumbnails/'.$row->nama_foto);?>" alt="Agileits W3layouts">
									<figcaption></figcaption>
								</div>
								
							</figure>
						</div>
					</a>
				</div>
				<div class="clearfix"></div>

			</div> -->
			

			

<!-- 			<div class="clearfix"></div>
		</div>
		</div> 

	</div> -->

	<div class="rooms agileits w3layouts">
		<div class="container">

		<h2>Our Gallery</h2>
		<div class="row agileits w3layouts">
			<?php foreach ($gallery as $row):?>
			<div class="column agileits w3layouts portfolio-top">

				<div class="portfolio-item agileits w3layouts wow zoomIn">
					<a class="example-image-link agileits w3layouts" href="<?php echo base_url('admin/assets/img/gallery/'.$row->nama_foto);?>" data-lightbox="example-set" data-title="">
						<div class="grid agileits w3layouts">
							<figure class="effect-apollo agileits w3layouts">
								<img src="<?php echo base_url('admin/assets/img/gallery/'.$row->nama_foto);?>" alt="Agileits W3layouts">
								<!-- <img src="<?php echo base_url('admin/assets/img/gallery/'.$row->nama_foto);?>" alt="Agileits W3layouts">
									<figcaption></figcaption> -->
							</figure>
						</div>
					</a>
				</div>
				<div class="clearfix"></div>

			</div>
			<?php endforeach;?>

			

			<div class="clearfix"></div>
		</div>
		</div> 

	</div>
	<!-- //Portfolio -->
	<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/galleria/galleria-1.4.7.min.js');?>"></script> -->
<script type="text/javascript">
	// (function() {
 //        Galleria.loadTheme('assets/plugins/galleria/themes/folio/galleria.folio.min.js');         
 //        Galleria.run('.galleria');
 //    }());

</script>




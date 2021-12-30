<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<head>

    <title><?php echo isset($page_title) ? $page_title : ' Untitled Page';?> | Pod House Manado</title>

<!-- Meta-Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="pod house manado, hostel, pod house, penginapan, penginapan nyaman manado, backpacker, penginapan untuk backpacker, penginapan murah, hostel murah, hostel bersih, penginapan bersih, hostel aman dan nyaman">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<?php
    if(isset($assets_footer))
    {
        foreach($assets_header as $header)
        {
            if($header['type'] == 'css')
            {
                echo '<link href="' . $header['href'] . '" rel="stylesheet" type="text/css" />';
            }
            elseif($header['type'] == 'js')
            {
                echo '<script type="text/javascript" src="' . $header['href'] . '"></script>';
            }
        }
    }
?>
<!-- //Head -->

<script type="text/javascript">
    var site_url = '<?php echo site_url();?>';
</script>

<!-- Body -->
<body>
<div id="preloader" style="display: block;">
    <div id="statusLoading">&nbsp;</div>
</div>
    <!-- Header -->
    <div class="header agileits w3layouts" id="home">

        <!-- Navbar -->
        <nav class="navbar navbar-default w3l aits wow bounceInUp agileits w3layouts">
            <div class="container">

                <div class="navbar-header agileits w3layouts">
                    <button type="button" class="navbar-toggle agileits w3layouts collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                        <span class="sr-only agileits w3layouts">Toggle navigation</span>
                        <span class="icon-bar w3l"></span>
                        <span class="icon-bar aits"></span>
                        <span class="icon-bar w3laits"></span>
                    </button>
                    <a class="navbar-brand agileits w3layouts" href="<?php echo site_url('home');?>">Manado Pod House</a>
                </div>

                <div id="navbar" class="navbar-collapse agileits w3layouts navbar-right collapse">
                    <ul class="nav agileits w3layouts navbar-nav">
                        <li><a href="<?php echo site_url('home');?>">HOME</a></li>
                        <li><a href="<?php echo site_url('room');?>">POD</a></li>
                        <li><a href="<?php echo site_url('gallery');?>">GALLERY</a></li>
                        <li><a href="<?php echo site_url('reservasi');?>">BOOKING</a></li>
                    </ul>
                </div>

            </div>
        </nav>
        <!-- //Navbar -->

    



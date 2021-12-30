    <!-- Footer -->
    <div class="footer agileits w3layouts">
        <div class="container">
        <center>
            

            <div class="col-md-12 col-sm-12 footer-grids agileits w3layouts social wow fadeInUp">
                <ul class="social-icons">
                    <li class="agileits w3layouts"><a href="#" class="facebook agileits w3layouts" title="Go to Our Facebook Page"></a></li>
                    <li class="agileits w3layouts"><a href="#" class="twitter agileits w3layouts" title="Go to Our Twitter Account"></a></li>
                    <li class="agileits w3layouts"><a href="#" class="googleplus agileits w3layouts" title="Go to Our Google Plus Account"></a></li>
                    <li class="agileits w3layouts"><a href="#" class="instagram agileits w3layouts" title="Go to Our Instagram Account"></a></li>
                    <li class="agileits w3layouts"><a href="#" class="youtube agileits w3layouts" title="Go to Our Youtube Channel"></a></li>
                </ul>
            </div>

            <div class="col-md-12 col-sm-12 footer-grids agileits w3layouts copyright wow fadeInUp">
                <p>&copy; 2018 Pod House Manado. All Rights Reserved | Design by <a href="https://www.karyampat.com/" target="_blank"> Karyampat </a></p>
            </div>
            <div class="clearfix"></div>
        </center>
        </div>
    </div>
    <!-- //Footer -->

    <?php
    if(isset($assets_footer))
    {
        foreach($assets_footer as $footer)
        {
            if($footer['type'] == 'css')
            {
                echo '<link href="' . $footer['href'] . '" rel="stylesheet" type="text/css" />';
            }
            elseif($footer['type'] == 'js')
            {
                echo '<script type="text/javascript" src="' . $footer['href'] . '"></script>';
            }
        }
    }
    ?>
</body>
<!-- //Body -->
</html>
        
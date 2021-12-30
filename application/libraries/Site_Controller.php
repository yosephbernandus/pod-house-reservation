<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_Controller extends MX_Controller
{
	
	function __construct() {
		parent::__construct();

		date_default_timezone_set('UTC');
		
		$this->load->library('session');
		$this->load->database();
	}




	public function load_site_view($data_assets = array())
	{

		if(isset($data_assets['page']))
		{
			$page = $data_assets['page'];
		}
		else
		{
			if($this->router->fetch_method() == 'add' || $this->router->fetch_method() == 'edit')
			{
				$page = 'add';
			}
			else
			{
				$page = 'main';
			}
		}

		$data = $this->_set_data_assets($data_assets);
		
		$this_class = $this->router->fetch_class();

		$this->load->view('include/header', $data);
		$this->load->view($this_class . '/' . $page);
		$this->load->view('include/footer');
	}

	public function _var_dump($a)
	{
		echo '<pre>';
		var_dump($a);
		echo '</pre>';
	}




	private function _set_data_assets($data = array())
	{
		$data_assets = $data;
		
		$data['assets_header'] = array(
			array(
				'href' => 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800',
				'type' => 'css'
			),
			array(
				'href' => 'https://fonts.googleapis.com/css?family=Cinzel+Decorative:400,900,700',
				'type' => 'css'
			),
			array(
				'href' => 'https://fonts.googleapis.com/css?family=Montserrat:400,700',
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/plugins/bootstrap/css/bootstrap.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/plugins/preloader/preloader.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/style.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/jquery-ui.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/chocolat.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/animate.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/custom.css'),
				'type' => 'css'
			),
			array(
				'href' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/sweetalert2.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bar-ratings/fontawesome-stars.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/lightresponsive/jquery.lightbox.min.css'),
				'type' => 'css'
			)
		);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/js/jquery-2.1.4.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/plugins/preloader/preloader.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/bootstrap.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/sweetalert2.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/wow.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/modernizr.custom.97074.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/jquery.chocolat.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/responsiveslides.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/jquery.magnific-popup.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/move-top.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/easing.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bar-ratings/jquery.barrating.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/jquery-ui.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/lightresponsive/jquery.lightbox.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/lightresponsive/jquery.lightbox.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/js/jquery.backstretch.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/javascript/template.js'),
				'type' => 'js'
			),
		);

		$assets_header_temp = array(
			// array(
			// 	'href' => base_url('assets/css/style.css'),
			// 	'type' => 'css'
			// )
		);

		$assets_footer_temp = array(
			// array(
			// 	'href' => base_url('assets/js/script.js'),
			// 	'type' => 'js'
			// )
		);

		if(isset($data_assets['assets_header']))
		{
			foreach($data_assets['assets_header'] as $k => $asset_header)
			{
				array_push($data['assets_header'], $data_assets['assets_header'][$k]);
			}
		}

		if(isset($assets_header_temp) && count($assets_header_temp) > 0)
		{
			foreach($assets_header_temp as $k => $temp)
			{
				array_push($data['assets_header'], $assets_header_temp[$k]);
			}
		}

		if(isset($data_assets['assets_footer']))
		{
			foreach($data_assets['assets_footer'] as $k => $asset_footer)
			{
				array_push($data['assets_footer'], $data_assets['assets_footer'][$k]);
			}
		}

		if(isset($assets_footer_temp) && count($assets_footer_temp) > 0)
		{
			foreach($assets_footer_temp as $k => $temp)
			{
				array_push($data['assets_footer'], $assets_footer_temp[$k]);
			}
		}

		return $data;
	}




	function formatBytes($size, $precision = 2) { 
		$base = log($size, 1024);
		$suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

		return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
}

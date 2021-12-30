<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MX_Controller
{
	
	function __construct() {
		parent::__construct();

		date_default_timezone_set('UTC');
		
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->library('Pdf');
		$this->load->library('Ssp');
		$this->load->helper('url');
		$this->load->database();
	}




	public function load_admin_view($data_assets = array())
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
		$data['message'] = $this->db->select('*')->from('bukutamu')->where('read_status', 0)->order_by('id','desc')->get();
		$data['reservasi_notif'] = $this->db->select('*')->from('reservasi')->where('read_status', 0)->order_by('id','desc')->get();
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
				'href' => base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/Ionicons/css/ionicons.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/dist/css/AdminLTE.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/dist/css/skins/_all-skins.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/morris.js/morris.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/jvectormap/jquery-jvectormap.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'),
				'type' => 'css'
			),
			array(
				'href' => site_url('assets/dropzone/css/dropzone.min.css'),
				'type' => 'css'
			),
			array(
				'href' => site_url('assets/plugins/iCheck/all.css'),
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/plugins/preloader/preloader.css'),
				'type' => 'css'
			),
			array(
				'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/bower_components/jquery/dist/jquery.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('../node_modules/socket.io/node_modules/socket.io-client/socket.io.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/javascript/notifikasi.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/plugins/preloader/preloader.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/dropzone/js/dropzone.min.js'),
				'type' => 'js'
			),
		);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/bower_components/jquery-ui/jquery-ui.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'),
				'type' => 'js'
			),
			array(
				'href' =>  base_url('assets/bower_components/raphael/raphael.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/morris.js/morris.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/moment/min/moment.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/plugins/iCheck/icheck.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/bower_components/fastclick/lib/fastclick.js'),
				'type' => 'js'
			),
			array(
				'href' => base_url('assets/dist/js/adminlte.min.js'),
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

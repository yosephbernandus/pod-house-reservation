<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Admin_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Customer';
		$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
			);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/customer.js'),
				'type' => 'js'
				)
			);
		$this->load_admin_view($data);
	}

	public function data(){
		$table = 'reservasi';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array('db' => 'guest_name', 'dt' => 'guest_name'),
			array('db' => 'province', 'dt' => 'province'),
			array('db' => 'country', 'dt' => 'country'),
			array('db' => 'company', 'dt' => 'company'),
			array('db' => 'telp', 'dt' => 'telp'),
			array('db' => 'email', 'dt' => 'email'),
			array('db' => 'status', 'dt' => 'status'),
			array('db' => 'input_date', 'dt' => 'input_date'),
		);
		$sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
		);

		$where = "status ='checkout'";
		echo json_encode(
            // SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where)
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
        );
	}
}
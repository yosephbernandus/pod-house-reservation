<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Site_Controller {

	public function index()
	{
		$data = array();
		$data['page_title'] = 'Home';
		$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
		);

		$data['assets_footer'] = array(
			// array(
			// 	'href' => base_url('assets/js/home.js'),
			// 	'type' => 'js'
			// )
		);
		$data['testimoni'] = $this->_getTestimoni()->result();
		$this->load_site_view($data);

	}

	private function _getTestimoni(){

		$status = "accepted";

		$this->db->select('*');
		$this->db->limit(5);
		$this->db->where('status', $status);
		$this->db->order_by('id', 'desc');
		return $this->db->get('testimoni');
	}
}

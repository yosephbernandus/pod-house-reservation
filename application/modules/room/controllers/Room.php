<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends Site_Controller {

	public function index()
	{
		$data = array();
		$data['page_title'] = 'POD';
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
		$data['room'] = $this->db->get('room')->result();
		$this->load_site_view($data);

	}
}

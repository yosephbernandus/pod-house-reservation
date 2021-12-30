<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Site_Controller {

	public function index()
	{
		$data = array();
		$data['page_title'] = 'Gallery';
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
		$data['gallery'] = $this->db->get('gallery')->result();
		$this->load_site_view($data);

	}
}

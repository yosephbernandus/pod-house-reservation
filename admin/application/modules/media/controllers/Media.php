<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Admin_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('media');
	}

	public function index(){
		$data['page_title'] = 'Media';
		$data['menu'] = 'Media';
		$data['page_mode'] = 'list';

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/media.js'),
				'type' => 'js'
			)
		);

		$this->load_admin_view($data);
	}

	public function add($type = '') {
		if ($type == 'youtube') {
			$data['page'] = 'add_youtube';
			$data['form_id'] = 'form_media_upload_youtube';
			$data['form_action'] = 'media/ajax_add_youtube';

			$data['page_title'] = 'Add Youtube';
			$data['menu'] = 'Add Youtube';
			$data['page_mode'] = 'youtube';

			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/media.js'),
					'type' => 'js'
				)
			);

			$this->load_admin_view($data);
		} elseif ($type == 'image') {

			$data['page'] = 'add_image';
			$data['form_id'] = 'form_image_upload';
			$data['form_action'] = 'media/ajax_add_image';

			$data['page_title'] = 'Add Image';
			$data['menu'] = 'Add Image';

			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/add_image.js'),
					'type' => 'js'
				)
			);

			$this->load_admin_view($data);
		} else {
			$data['page'] = 'add_image';
			$data['form_id'] = 'form_image_upload';
			$data['form_action'] = 'media/ajax_add_image';

			$data['page_title'] = 'Add Image';
			$data['menu'] = 'Add Image';

			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/add_image.js'),
					'type' => 'js'
				)
			);

			$this->load_admin_view($data);
		}
	}

	public function ajax_add_image(){
		$json['records'] = array();
		$json['message'] = '';
		$json['success'] = TRUE;

		try {
			$this->core_function->validate_ajax_origin();

			$this->db->trans_start();

			$image_records = array();

			foreach ($_POST as $k => $v) {
				$v = $this->input->post($k);

				if (preg_match('/^datetime_/', $k)) {
					$image_records[$k] = date('Y-m-d H:i:s', strtotime($v));
				} else {
					$image_records[$k] = $v;
				}
			}

			$this->_add_image($image_records);

			$this->db->trans_complete();
			$json['redirect'] = site_url('gallery');
		} catch (Exception $e) {
			$json['message'] = $e->getMessage();
			$json['success'] = FALSE;

			if ($json['message'] == '') {
				$json['message'] = 'Server error';
			}
		}

		header('Content-Type: application/json');
		echo json_encode($json);
	}

	private function _add_image($image_records){
		$date = array();
		$date['Y'] = date('Y');
		$date['m'] = date('m');
		$date['d'] = date('d');

		$upload_dir_m = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'];
		$upload_dir_y = CONTENTDIR . '/' . $date['Y'];
		$upload_dir = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'] . '/';

		if(!is_dir($upload_dir_y))
		{
			if(!@mkdir(CONTENTDIR . '/' . $date['Y']))
			{
				throw new Exception("Permission denied while creating directory for your media. Please contact administrator.");
			}
		}

		if(!is_dir($upload_dir_m))
		{
			if(!@mkdir(CONTENTDIR . '/' . $date['Y'] . '/' . $date['m']))
			{
				throw new Exception("Permission denied while creating directory for your media. Please contact administrator.");
			}
		}

		$config_upload['upload_path']   = FCPATH.'/assets/img/gallery/';
		$config_upload['allowed_types'] = 'gif|jpg|png|ico';

		$this->load->library('upload', $config_upload);

		if (!is_dir($config_upload['upload_path'])) {
			throw new Exception($this->upload->display_errors());
		}

		if (!$this->upload->do_upload('userfile')) {
			throw new Exception($this->upload->display_errors());
		}

		$arr_image_detail = $this->upload->data();
		$image_records['author_id'] = $this->session->userdata('user_id');
		$image_records['title'] = $arr_image_detail['raw_name'];
		$image_records['name'] = $arr_image_detail['orig_name'];
		$image_records['type'] = $arr_image_detail['file_type'];

		$image_id = $this->db_model->insert('media', $image_records);
		$image_name = $image_id . '_' . $arr_image_detail['raw_name'];

		$this->_image_resize($arr_image_detail['full_path'], $image_name . '-1024'. $arr_image_detail['file_ext'], 1024, 1024);
		$this->_image_resize($arr_image_detail['full_path'], $image_name . '-600'. $arr_image_detail['file_ext'], 600, 600);
		$this->_image_resize($arr_image_detail['full_path'], $image_name . '-300', $arr_image_detail['file_ext'], 300, 300);
		$this->_image_crop($upload_dir . $image_name . '-300'. $arr_image_detail['file_ext'], $image_name . '-cropped'. $arr_image_detail['file_ext'], 300, 300);

		rename($arr_image_detail['full_path'], $upload_dir . $image_name . $arr_image_detail['file_ext']);

		$this->db->where('id', $image_id);
		$this->db->update('media', array('name' => $image_name . $arr_image_detail['file_ext']));
	}

	private function _image_resize($image_source, $image_dest, $width, $height) {
		$this->load->library('image_lib');

		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_source;
		$config['new_image'] = $image_dest;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
	}

	private function _image_crop($image_source, $image_dest, $width, $height) {
		$this->load->library('image_lib');

		$image_properties = getimagesize($image_source);
		$img_prop = array();
		$img_prop['width'] = $image_properties[0];
		$img_prop['height'] = $image_properties[1];
		$img_prop['type'] = $image_properties['mime'];

		$config['width'] = 200;
		$config['height'] = 200;

		if ($img_prop['width'] > $img_prop['height']) {
			$config['width'] = $img_prop['height'];
			$config['height'] = $img_prop['height'];
			$config['x_axis'] = ($img_prop['width'] - $img_prop['height']) / 2;
			$config['y_axis'] = 0;
		} else if ($img_prop['height'] > $img_prop['width']) {
			$config['width'] = $img_prop['width'];
			$config['height'] = $img_prop['width'];
			$config['x_axis'] = ($img_prop['height'] - $img_prop['width']) / 2;
			$config['y_axis'] = 0;
		}

		$config['image_library'] ='gd2';
		$config['source_image'] = $image_source;
		$config['new_image'] = $image_dest;
		$config['maintain_ratio'] FALSE;

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->crop();
	}
}
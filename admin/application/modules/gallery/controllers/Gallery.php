<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends Admin_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Gallery';
		$data['assets_header'] = array(
			array(
				'href' => 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css',
				'type' => 'css'
			),
			array(
				'href' => base_url('assets/css/gallery-grid.css'),
				'type' => 'css'
			)
		);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/gallery.js'),
				'type' => 'js'
				)
			);
		$this->load_admin_view($data);
	}

  	public function data(){
  		$table = "gallery";
  		$primaryKey = "id";
  		$columns = array(
  			array('db' => 'id', 'dt' => 'id'),
  			array('db' => 'nama_foto', 'dt' => 'nama_foto'),
  			array(
                'db' => 'nama_foto',
                'dt' => 'foto',
                'formatter' => function( $d) {
                    return "<img width='100px' src='".base_url()."/assets/img/gallery/".$d."'>";
                }
            ),
            array(
				'db' => 'nama_foto',
				'dt' => 'aksi',
				'formatter' => function($d){
					return anchor('gallery/delete/'.$d, '<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Edit"');
				}
			)
  		);

  		$sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
		);

		echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
  	}

  	public function delete(){
		$kode=$this->uri->segment(3);
		if (!empty($kode)) {
			if(file_exists($file=FCPATH.'assets/img/gallery/'.$kode) && file_exists($thumb=FCPATH. 'assets/img/gallery/thumbnails/'.$kode)){
				unlink($file);
				unlink($thumb);
			}
			$this->db->delete('gallery',array('nama_foto'=>$kode));
		} 
		redirect('gallery');
	}

	//Upload photo process
	// function proses_upload(){
	// 	$date = array();
	// 	$date['Y'] = date('Y');
	// 	$date['m'] = date('m');
	// 	$date['d'] = date('d');

	// 	$upload_dir_m = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'];
	// 	$upload_dir_y = CONTENTDIR . '/' . $date['Y'];
	// 	$upload_dir = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'] . '/';


 //        $config_upload['upload_path']   = FCPATH.'/assets/img/gallery/';
 //        $config_upload['allowed_types'] = 'gif|jpg|png|ico';
 //        $config_upload['max_size'] = 10240;
 //        $this->upload->initialize($config_upload);

 //        if($this->upload->do_upload('userfile')){
 //        	$arr_image_detail = $this->upload->data();
 //        	$token=$this->input->post('token_foto');
 //        	$nama=$this->upload->data('file_name');
 //        	$image_id = $this->db->insert('gallery',array('nama_foto'=>$nama,'token'=>$token));

 //        	var_dump($arr_image_detail);
 //        	// $image_name = $image_id . '_' . $arr_image_detail['raw_name'];
 //        	// $this->_image_resize($arr_image_detail['full_path'], $image_name . '-1024'. $arr_image_detail['file_ext'], 1024, 1024);
 //        	// $this->_image_resize($arr_image_detail['full_path'], $image_name . '-600'. $arr_image_detail['file_ext'], 600, 600);
 //        	// $this->_image_resize($arr_image_detail['full_path'], $image_name . '-300'. $arr_image_detail['file_ext'], 300, 300);

 //        	// rename($arr_image_detail['full_path'], $upload_dir . $image_name . $arr_image_detail['file_ext']);

 //        	// $this->db->where('id', $image_id);
 //        	// $this->db->update('gallery', array('name' => $image_name . $arr_image_detail['file_ext']));
 //        }
	// }
	private function _image_resize($image_source, $image_dest, $width, $height)
	{
		$this->load->library('image_lib');

		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_source;
		$config['new_image'] = $image_dest;
		$config['width'] = $width;
		$config['height'] = $height;

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
		}
	
	}

	function proses_upload(){
        $config['upload_path']   = FCPATH.'/assets/img/gallery/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
        $this->upload->initialize($config);

        if($this->upload->do_upload('userfile')){
        	$uploadedImage = $this->upload->data();
        	$cropped_img = $this->_resizeImage($uploadedImage['file_name']);
        	$target_path = FCPATH.'assets/img/gallery/thumbnails/cropped_img__'.$cropped_img;
        	$source_path = FCPATH.'assets/img/gallery/thumbnails/' . $cropped_img;
        	$this->_image_crop($source_path, $target_path, 300, 300);
        	$token=$this->input->post('token_foto');
        	$nama=$this->upload->data('file_name');
        	$this->db->insert('gallery',array('nama_foto'=>$nama,'token'=>$token));
        }
	}

	private function _resizeImage($filename){
		$config['image_library'] = 'gd2';
		$source_path = FCPATH.'assets/img/gallery/' . $filename;
		$target_path = FCPATH.'assets/img/gallery/thumbnails/';
		$config['source_image'] = $source_path;
		$config['new_image'] = $target_path;
		$config['maintain_ratio'] = TRUE;
		// $config['create_thumb'] = '_thumb';
		$config['width'] = 600;
		$config['height'] = 300;
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();
		return $filename;
	}

	private function _image_crop($image_source, $image_dest, $width, $height)
	{
		$this->load->library('image_lib');

		$image_properties = getimagesize($image_source);
		$img_prop = array();
		$img_prop['width'] = $image_properties[0];
		$img_prop['height'] = $image_properties[1];
		$img_prop['type'] = $image_properties['mime'];

		$config['width'] = 200;
		$config['height'] = 200;

		// Landscape
		if($img_prop['width'] > $img_prop['height'])
		{
			$config['width'] = $img_prop['height'];
			$config['height'] = $img_prop['height'];
			$config['x_axis'] = ($img_prop['width'] - $img_prop['height']) / 2;
			$config['y_axis'] = 0;
		}
		// Potrait
		elseif($img_prop['height'] > $img_prop['width'])
		{
			$config['width'] = $img_prop['width'];
			$config['height'] = $img_prop['width'];
			$config['x_axis'] = ($img_prop['height'] - $img_prop['width']) / 2;
			$config['y_axis'] = 0;
		}

		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_source;
		$config['new_image'] = $image_dest;
		$config['maintain_ratio'] = FALSE;

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->crop();
	}

	//Remove photo
	function remove_foto(){
		//Get token photo
		$token=$this->input->post('token');
		$foto=$this->db->get_where('gallery',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->nama_foto;
			if(file_exists($file=FCPATH.'assets/img/gallery/'.$nama_foto) && file_exists($thumb=FCPATH. 'assets/img/gallery/thumbnails/'.$nama_foto)){
				unlink($file);
				unlink($thumb);
			}
			$this->db->delete('gallery',array('token'=>$token));
		}
		echo "{}";
	}

	// public function ajax_add_image(){
	// 	$json['records'] = array();
	// 	$json['message'] = '';
	// 	$json['success'] = TRUE;

	// 	try {
	// 		$this->core_function->validate_ajax_origin();

	// 		$this->db->trans_start();

	// 		$image_records = array();

	// 		foreach ($_POST as $k => $v) {
	// 			$v = $this->input->post($k);

	// 			if (preg_match('/^datetime_/', $k)) {
	// 				$image_records[$k] = date('Y-m-d H:i:s', strtotime($v));
	// 			} else {
	// 				$image_records[$k] = $v;
	// 			}
	// 		}

	// 		$this->_add_image($image_records);

	// 		$this->db->trans_complete();
	// 		$json['redirect'] = site_url('gallery');
	// 	} catch (Exception $e) {
	// 		$json['message'] = $e->getMessage();
	// 		$json['success'] = FALSE;

	// 		if ($json['message'] == '') {
	// 			$json['message'] = 'Server error';
	// 		}
	// 	}

	// 	header('Content-Type: application/json');
	// 	echo json_encode($json);
	// }

	// private function _add_image($image_records){
	// 	$date = array();
	// 	$date['Y'] = date('Y');
	// 	$date['m'] = date('m');
	// 	$date['d'] = date('d');

	// 	$upload_dir_m = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'];
	// 	$upload_dir_y = CONTENTDIR . '/' . $date['Y'];
	// 	$upload_dir = CONTENTDIR . '/' . $date['Y'] . '/' . $date['m'] . '/';

	// 	if(!is_dir($upload_dir_y))
	// 	{
	// 		if(!@mkdir(CONTENTDIR . '/' . $date['Y']))
	// 		{
	// 			throw new Exception("Permission denied while creating directory for your media. Please contact administrator.");
	// 		}
	// 	}

	// 	if(!is_dir($upload_dir_m))
	// 	{
	// 		if(!@mkdir(CONTENTDIR . '/' . $date['Y'] . '/' . $date['m']))
	// 		{
	// 			throw new Exception("Permission denied while creating directory for your media. Please contact administrator.");
	// 		}
	// 	}

	// 	$config_upload['upload_path']   = FCPATH.'/assets/img/gallery/';
	// 	$config_upload['allowed_types'] = 'gif|jpg|png|ico';

	// 	$this->load->library('upload', $config_upload);

	// 	if (!is_dir($config_upload['upload_path'])) {
	// 		throw new Exception($this->upload->display_errors());
	// 	}

	// 	if (!$this->upload->do_upload('userfile')) {
	// 		throw new Exception($this->upload->display_errors());
	// 	}

	// 	$arr_image_detail = $this->upload->data();
	// 	$image_records['author_id'] = $this->session->userdata('user_id');
	// 	$image_records['title'] = $arr_image_detail['raw_name'];
	// 	$image_records['name'] = $arr_image_detail['orig_name'];
	// 	$image_records['type'] = $arr_image_detail['file_type'];

	// 	$image_id = $this->db_model->insert('media', $image_records);
	// 	$image_name = $image_id . '_' . $arr_image_detail['raw_name'];

	// 	$this->_image_resize($arr_image_detail['full_path'], $image_name . '-1024'. $arr_image_detail['file_ext'], 1024, 1024);
	// 	$this->_image_resize($arr_image_detail['full_path'], $image_name . '-600'. $arr_image_detail['file_ext'], 600, 600);
	// 	$this->_image_resize($arr_image_detail['full_path'], $image_name . '-300', $arr_image_detail['file_ext'], 300, 300);
	// 	$this->_image_crop($upload_dir . $image_name . '-300'. $arr_image_detail['file_ext'], $image_name . '-cropped'. $arr_image_detail['file_ext'], 300, 300);

	// 	rename($arr_image_detail['full_path'], $upload_dir . $image_name . $arr_image_detail['file_ext']);

	// 	$this->db->where('id', $image_id);
	// 	$this->db->update('media', array('name' => $image_name . $arr_image_detail['file_ext']));
	// }

	// private function _image_resize($image_source, $image_dest, $width, $height) {
	// 	$this->load->library('image_lib');

	// 	$config['image_library'] = 'gd2';
	// 	$config['source_image'] = $image_source;
	// 	$config['new_image'] = $image_dest;
	// 	$config['width'] = $width;
	// 	$config['height'] = $height;

	// 	$this->image_lib->clear();
	// 	$this->image_lib->initialize($config);
	// 	if (!$this->image_lib->resize()) {
	// 		echo $this->image_lib->display_errors();
	// 	}
	// }

	// private function _image_crop($image_source, $image_dest, $width, $height) {
	// 	$this->load->library('image_lib');

	// 	$image_properties = getimagesize($image_source);
	// 	$img_prop = array();
	// 	$img_prop['width'] = $image_properties[0];
	// 	$img_prop['height'] = $image_properties[1];
	// 	$img_prop['type'] = $image_properties['mime'];

	// 	$config['width'] = 200;
	// 	$config['height'] = 200;

	// 	if ($img_prop['width'] > $img_prop['height']) {
	// 		$config['width'] = $img_prop['height'];
	// 		$config['height'] = $img_prop['height'];
	// 		$config['x_axis'] = ($img_prop['width'] - $img_prop['height']) / 2;
	// 		$config['y_axis'] = 0;
	// 	} else if ($img_prop['height'] > $img_prop['width']) {
	// 		$config['width'] = $img_prop['width'];
	// 		$config['height'] = $img_prop['width'];
	// 		$config['x_axis'] = ($img_prop['height'] - $img_prop['width']) / 2;
	// 		$config['y_axis'] = 0;
	// 	}

	// 	$config['image_library'] ='gd2';
	// 	$config['source_image'] = $image_source;
	// 	$config['new_image'] = $image_dest;
	// 	$config['maintain_ratio'] = FALSE;

	// 	$this->image_lib->clear();
	// 	$this->image_lib->initialize($config);
	// 	$this->image_lib->crop();
	// }

	public function upload_foto(){
		$this->load->view('image_upload');
	}

	public function uploadImage(){
		$config['upload_path']   = FCPATH.'/assets/img/gallery/';
        $config['allowed_types'] = 'gif|jpg|png|ico';

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
        	$error = array('error' => $this->upload->display_errors());
        	$this->load->view('image_upload', $error);
        } else {
        	$uploadedImage = $this->upload->data();
        	$this->_resizeImage($uploadedImage['file_name']);
   //      	$config['image_library'] = 'gd2';
   //      	$source_path = $uploadedImage['full_path'];
			// $target_path = FCPATH.'assets/img/gallery/thumbnails/';
			// $config['source_image'] = $source_path;
			// $config['new_image'] = $target_path;
			// $config['maintain_ratio'] = TRUE;
			// $config['create_thumb'] = '_thumb';
			// $config['width'] = 150;
			// $config['height'] = 150;

			// $this->load->library('image_lib', $config);
			// $this->image_lib->initialize($config);
   //      	$this->image_lib->resize();
   //      	var_dump(gd_info());
        	print_r('image uploaded successfully');
        	exit;
        }
	}

	// private function _resizeImage($filename){
	// 	$config['image_library'] = 'gd2';
	// 	$source_path = FCPATH.'assets/img/gallery/' . $filename;
	// 	$target_path = FCPATH.'assets/img/gallery/thumbnails/';
	// 	$config['source_image'] = $source_path;
	// 	$config['new_image'] = $target_path;
	// 	$config['maintain_ratio'] = TRUE;
	// 	$config['create_thumb'] = '_thumb';
	// 	$config['width'] = 400;
	// 	$config['height'] = 400;
	// 	// $config = array(
	// 	// 	'source_image' => $source_path,
	// 	// 	'new_image' => $target_path,
	// 	// 	'maintain_ratio' => TRUE,
	// 	// 	'create_thumb' => TRUE,
	// 	// 	'thumb_marker' => '_thumb',
	// 	// 	'width' => 150,
	// 	// 	'height' => 150
	// 	// );
	// 	$this->load->library('image_lib', $config);
	// 	$this->image_lib->initialize($config);
	// 	if (!$this->image_lib->resize()) {
	// 		echo $this->image_lib->display_errors();
	// 	}

	// 	$this->image_lib->clear();
	// }
}

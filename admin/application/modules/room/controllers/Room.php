<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends Admin_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}

		$this->load->library('upload');
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Testimoni';
		$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
			);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/room.js'),
				'type' => 'js'
				)
			);
		$data['page'] = 'main';
		$data['form_name'] = 'form_room_add';
		$this->load_admin_view($data);
	}

	public function edit_image(){
		if (isset($_POST['submit'])) {
			$uploadfoto = $this->upload_foto_room();
			$this->update_image($uploadfoto);
			redirect('room');
		} else {
			$id = $this->uri->segment(3);
			$arr_room = $this->db_model->get('room', $id);
			$data['arr_room']= $arr_room;
			$data['page'] = 'edit_image';
			$this->load_admin_view($data);
		}
	}

	function update_image($foto){
		if (empty($foto)) {
			$data = array(
				'id' => $this->input->post('id', TRUE)
			);
		} else {
			$data = array(
				'id' => $this->input->post('id', TRUE),
				'image' => $foto
			);
		}
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$this->db->update('room', $data);
	}

	function upload_foto_room(){
        $config['upload_path']   = FCPATH.'assets/img/room/';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->upload->initialize($config);

        //proses upload
        $this->upload->do_upload('userfile');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

	public function edit($id){
		if ($this->uri->segment(3) == null) {
			redirect('room');
		} else {
			$arr_room = $this->db_model->get('room', $id);
			$data['page'] = 'edit';
			$data['form_id'] = 'form_room_edit';
			$data['form_name'] = 'form_room_edit';
			$data['form_action'] = site_url('room/ajax_edit');
			$data['arr_room']= $arr_room;
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/room.js'),
					'type' => 'js'
					)
				);
			$this->load_admin_view($data);
		}
	}

	public function delete(){
		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->db_model->delete('room', $id);
		}
		redirect('room');
	}

	public function ajax_edit(){
		$json['records'] = array();
		$json['message'] = '';
		$json['success'] = TRUE;

		try {
			$this->core_function->validate_ajax_origin();
			$room_records = array();
			foreach ($_POST as $k => $v)
			{
				$v = $this->input->post($k);

				if($v == '')
				{
					unset($k);
				}
				else
				{
					
					$room_records[$k] = $v;
				}
			}
			$this->_validate_edit($room_records);
			$this->_edit($room_records);
			$json['message'] = 'Room was saved';
			$json['redirect'] = site_url('room');
		} catch (Exception $e){
			$json['message'] = $e->getMessage();
			$json['success'] = FALSE;

			if ($json['message'] == '')
			{
				$json['message'] = 'Server error.';
			}
		}

		echo json_encode($json);
	}

	private function _edit($room_records){
		$this->db_model->update('room', $room_records['id'], $room_records);
	}

	private function _validate_edit($room_records){

		if (!isset($room_records['nama_room']) || $room_records['nama_room'] == '') {
			throw new Exception("Please provide room name");
		}

		if (!isset($room_records['jumlah_room']) || $room_records['jumlah_room'] == '') {
			throw new Exception("Please provide amount of room set 0 if room is full");
		}

		if (!isset($room_records['harga']) || $room_records['harga'] == '') {
			throw new Exception("Please provide price of room");
		}

		if (!isset($room_records['diskon']) || $room_records['diskon'] == '') {
			throw new Exception("Please provide diskon");
		}

		if (!isset($room_records['keterangan']) || $room_records['keterangan'] == '') {
			throw new Exception("Please provide description");
		}
	}

	public function ajax_add(){
		$json = array();
		$json['success'] = TRUE;
		$json['message'] = '';
		$json['error'] = '';

		try {
			$this->db->trans_start();
			$room_records = array();

			foreach ($_POST as $k => $v){
				$v = $this->input->post($k);

				if($v == ''){
					unset($k);
				} else {
					$room_records[$k] = $v;
				}
			}

			$this->_validate_add($room_records);
			$this->_add($room_records);

			$json['redirect'] = site_url('room');
			$json['message'] = 'New Room was successfully added.';

			$this->db->trans_complete();
		} catch (Exception $e) {
			$json['message'] = $e->getMessage();
			$json['success'] = FALSE;

			unset($json['redirect']);
			if ($json['message'] ==  '') {
				$json['message'] = 'Server error.';
			}
		}
		echo json_encode($json);
	}

	private function _add($room_records){
		$this->db->insert('room', $room_records);
	}

	private function _validate_add($room_records){

		if (!isset($room_records['nama_room']) || $room_records['nama_room'] == '') {
			throw new Exception("Please provide room name");
		}

		if (!isset($room_records['jumlah_room']) || $room_records['jumlah_room'] == '') {
			throw new Exception("Please provide amount of room");
		}

		if (!isset($room_records['harga']) || $room_records['harga'] == '') {
			throw new Exception("Please provide price of room");
		}

		$this->db->where('nama_room', $room_records['nama_room']);
		$query_room = $this->db->get('room');
		$arr_room = $query_room->result();

		if (count($arr_room) > 0) {
			throw new Exception("Room name already registered, please input another room name");
		}
	}

	public function data(){
		$table = 'room';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array(
                'db' => 'image',
                'dt' => 'image',
                'formatter' => function( $d) {
                    return "<img width='100px' src='".base_url()."/assets/img/room/".$d."'>";
                }
            ),
			array('db' => 'nama_room', 'dt' => 'nama_room'),
			array('db' => 'harga', 'dt' => 'harga'),
			array('db' => 'jumlah_room', 'dt' => 'jumlah_room'),
			array('db' => 'diskon', 'dt' => 'diskon'),
			array('db' => 'breakfast', 'dt' => 'breakfast'),
			array(
				'db' => 'id',
				'dt' => 'aksi',
				'formatter' => function( $d){
					return anchor('room/edit/'.$d, '<i class="fa fa-edit"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit"').' '.anchor('room/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"') .' '.anchor('room/edit_image/'.$d,'<i class="fa fa-image"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit image"');
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
}
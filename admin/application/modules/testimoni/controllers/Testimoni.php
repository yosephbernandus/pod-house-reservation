<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimoni extends Admin_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
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
				'href' => base_url('assets/javascript/testimoni.js'),
				'type' => 'js'
				)
			);
		$this->load_admin_view($data);
	}

	public function edit($id){
		if ($this->uri->segment(3) == null) {
			redirect('reservasi');
		} else {	
			$data['page'] = 'edit';
			$arr_testimoni = $this->db_model->get('testimoni', $id);
			$data['form_id'] = 'form_testimoni_edit';
			$data['form_action'] = site_url('testimoni/ajax_edit');
			$data['arr_testimoni']= $arr_testimoni;
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/testimoni.js'),
					'type' => 'js'
					)
				);
			$this->load_admin_view($data);
		}
	}

	public function ajax_edit(){
		$json['records'] = array();
		$json['message'] = '';
		$json['success'] = TRUE;

		try {
			$this->core_function->validate_ajax_origin();
			$testimoni_records = array();
			foreach ($_POST as $k => $v)
			{
				$v = $this->input->post($k);

				if($v == '')
				{
					unset($k);
				}
				else
				{
					
					$testimoni_records[$k] = $v;
				}
			}
			$this->_edit($testimoni_records);
			$json['message'] = 'Testimoni was saved';
			$json['redirect'] = site_url('testimoni');
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

	public function delete(){
		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->db_model->delete('testimoni', $id);
		}
		redirect('testimoni');
	}

	private function _edit($testimoni_records){
		if (!isset($testimoni_records['id'])) {
			throw new Exception("Server Error");
		}
		
		$this->db_model->update('testimoni', $testimoni_records['id'], $testimoni_records);
	}

	function data(){
		$table = 'testimoni';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array('db' => 'id_reservasi', 'dt' => 'id_reservasi'),
			array('db' => 'nama', 'dt' => 'nama'),
			array('db' => 'email', 'dt' => 'email'),
			array('db' => 'pesan', 'dt' => 'pesan'),
			array('db' => 'company', 'dt' => 'company'),
			array('db' => 'rating', 'dt' => 'rating'),
			array('db' => 'status', 'dt' => 'status'),
			array(
				'db' => 'id',
				'dt' => 'aksi',
				'formatter' => function( $d){
					return anchor('testimoni/edit/'.$d, '<i class="fa fa-edit"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit"').' '.anchor('testimoni/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"');
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
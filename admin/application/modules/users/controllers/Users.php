<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}

		if ($this->session->userdata('level') != "admin") {
            redirect('reservasi');
        }
        $this->load->library('form_validation');
        $this->load->model('user_model');
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Users';
		$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
			);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/users.js'),
				'type' => 'js'
				)
			);

		$data['form_name'] = 'form_user_add';
		$this->load_admin_view($data);
	}

	public function data(){
		$table = 'administrator';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array('db' => 'user', 'dt' => 'user'),
			array('db' => 'level', 'dt' => 'level'),
			array('db' => 'email', 'dt' => 'email'),
			array(
				'db' => 'id',
				'dt' => 'aksi',
				'formatter' => function( $d){
					return anchor('users/edit/'.$d, '<i class="fa fa-edit"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit"').' '.anchor('users/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"');
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

	public function edit($id){
		if ($this->uri->segment(3) == null) {
			redirect('users');
		} else {
			$arr_user = $this->db_model->get('administrator', $id);
			$data['page'] = 'edit';
			$data['form_id'] = 'form_user_edit';
			$data['form_name'] = 'form_user_edit';
			$data['form_action'] = site_url('users/ajax_edit');
			$data['arr_user']= $arr_user;
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/users.js'),
					'type' => 'js'
					)
				);
			$this->load_admin_view($data);
		}
	}

	public function delete(){
		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->db_model->delete('administrator', $id);
		}
		redirect('users');
	}

	public function ajax_edit(){
		$json['records'] = array();
		$json['message'] = '';
		$json['success'] = TRUE;


		try {
			$this->core_function->validate_ajax_origin();
			$user_records = array();
			foreach ($_POST as $k => $v)
			{
				$v = $this->input->post($k);

				if($v == '')
				{
					unset($k);
				}
				else
				{
					
					$user_records[$k] = $v;
				}
			}
			$this->_validate_edit($user_records);
			$this->_edit($user_records);
			$json['message'] = 'User was saved';
			$json['redirect'] = site_url('users');
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

	private function _edit($user_records){
		if (empty($user_records['password'])) {
			$data = array(
				'user' => $user_records['user'],
				'email' => $user_records['email'],
				'level' => $user_records['level']
			);
		} else {
			$data = array(
				'user' => $user_records['user'],
				'password' => password_hash($user_records['password'], PASSWORD_DEFAULT),
				'email' => $user_records['email'],
				'level' => $user_records['level']
			);
		}

		$id = $user_records['id'];
		$this->db->where("id",$id);
		$this->db->update("administrator",$data);
	}

	private function _validate_edit($user_records){

		$this->form_validation->set_rules('user', 'Username', 'required|min_length[2]',
			array(
				'required' => 'You must provide a %s.',
				'required|min_length[3]|alpha_numeric|is_unique[administrator.user]',
			)
		);

		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]',
			array(
				'min_length' => 'Minimal character of %s is 5.'
			)
		);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',
			array(
				'required' => 'You must provide a %s.',
				'valid_email' => 'Your %s is not valid.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			throw new Exception(validation_errors());
		}

		$arr_check_unique_user_name = $this->user_model->check_unique_user_name($user_records['id'], $user_records['user']);

		if(count($arr_check_unique_user_name) > 0)
		{
			throw new Exception("Username address already registered.");
		}
	}

	public function ajax_add(){
		$json = array();
		$json['success'] = TRUE;
		$json['message'] = '';
		$json['error'] = '';

		try {
			$this->core_function->validate_ajax_origin();
			$this->db->trans_start();
			$user_records = array();

			foreach ($_POST as $k => $v){
				$v = $this->input->post($k);

				if($v == ''){
					unset($k);
				} else {
					$user_records[$k] = $v;
				}
			}

			$this->_validate_add($user_records);
			$this->_add($user_records);

			$json['redirect'] = site_url('users');
			$json['message'] = 'New User was successfully added.';

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

	private function _add($user_records){

		$this->db->where('user', $user_records['user']);
		$query_user = $this->db->get('administrator');
		$arr_user = $query_user->result();

		if (count($arr_user) > 0) {
			throw new Exception("Username already registered, please input another username");
		}

		$user_records['password'] = password_hash($user_records['password'], PASSWORD_DEFAULT);
		$this->db->insert('administrator', $user_records);
	}

	private function _validate_add($user_records){

		$this->form_validation->set_rules('user', 'Username', 'required|min_length[2]',
			array(
				'required' => 'You must provide a %s.',
				'required|min_length[3]|alpha_numeric|is_unique[administrator.user]',
			)
		);

		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]',
			array(
				'required' => 'You must provide a %s.',
				'min_length' => 'Minimal character of %s is 5.'
			)
		);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[administrator.email]',
			array(
				'required' => 'You must provide a %s.',
				'valid_email' => 'Your %s is not valid.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			throw new Exception(validation_errors());
		}


	}
}
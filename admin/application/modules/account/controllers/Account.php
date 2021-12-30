<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Admin_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
		$this->load->model('user_model');
        $this->load->library('form_validation');
	}

	public function change_password($id){
		if ($this->uri->segment(3) == null) {
			redirect('reservasi');
		} else {
			$arr_user = $this->db_model->get('administrator', $id);
			$data['page_title'] = 'Account';
			$data['form_id'] = 'form_user_edit';
			$data['form_name'] = 'form_user_edit';
			$data['form_action'] = site_url('account/ajax_edit');
			$data['arr_user']= $arr_user;
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/account.js'),
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
			$json['redirect'] = site_url('reservasi');
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
			);
		} else {
			$data = array(
				'user' => $user_records['user'],
				'password' => password_hash($user_records['password'], PASSWORD_DEFAULT),
				'email' => $user_records['email'],
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
}
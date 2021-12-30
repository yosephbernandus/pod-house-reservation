<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('username')) {
			redirect('reservasi');
		}
		$this->load->model('model_administrator');
	}

	public function logout()
	{
		$arr_sess = array(
			'id' => $this->session->userdata('id'),
			'username' => $this->session->userdata('username'),
			'password' => $this->session->userdata('password'),
			'level' => $this->session->userdata('level'),
			'email' => $this->session->userdata('email')
		);
		// $this->session->unset_userdata($arr_sess);
		$this->session->sess_destroy();
		redirect('auth');
	}
	// Array ( [__ci_last_regenerate] => 1542773590 [id] => 1 [username] => admin [password] => admin.2017 [level] => admin [email] => admin@email.com )

	public function index()
	{
		redirect('auth/login');
	}

	public function login($error = '0')
	{
		$user_id = $this->session->userdata('user_id');

		if (!empty($user_id)) {
			redirect();
		}

		if ($error != '0') {
			$data['error'] = $error;
		}

		$data['page_title'] = 'Pod House App Login';

		$this->load->view('login', $data);
	}

	public function submit()
	{
		$json = array();
		$json['success'] = TRUE;
		$json['message'] = '';
		$json['redirect'] = '';

		try {
			$this->db->trans_start();
			$this->_submit();

			$redirect = site_url('reservasi');
			$json['redirect'] = $redirect;

			$this->db->trans_complete();
		} catch (Exception $e) {
			$json['message'] = $e->getMessage();
			$json['success'] = FALSE;

			unset($json['redirect']);

			if ($json['message'] == '') {
				$json['message'] = 'Server error.';
			}
		}

		header('Content-type: application/json');

		echo json_encode($json);
	}

	private function _submit()
	{

		$id = $this->input->post('id_admin');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if (empty($username) && empty($password)) {
			throw new Exception("Username or password cannot be empty.");
		}

		$cek = $this->model_administrator->cek($username);
		if ($cek->num_rows() > 0) {
			$hash = $this->model_administrator->cek($username)->result();
			foreach ($hash as $row) {
				if (password_verify($password, $row->password)) {
					$admin = array(
						'id' => $row->id,
						'username' => $username,
						'password' => $password,
						'level' => $row->level,
						'email' => $row->email
					);
					$this->session->set_userdata($admin);
				} else {
					throw new Exception("Wrong Username or password");
				}
			}
		} else {
			throw new Exception("Wrong Username or password");
		}
	}
}

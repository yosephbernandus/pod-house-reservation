<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guestbook extends Admin_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Guestbook';
		$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
			);

		$data['assets_footer'] = array(
			array(
				'href' => base_url('assets/javascript/guestbook.js'),
				'type' => 'js'
				)
			);
		$this->load_admin_view($data);
	}

	function data(){
		$table = 'bukutamu';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array('db' => 'tanggal', 'dt' => 'tanggal'),
			array('db' => 'nama', 'dt' => 'nama'),
			array('db' => 'email', 'dt' => 'email'),
			array('db' => 'telp', 'dt' => 'telp'),
			array('db' => 'pesan', 'dt' => 'pesan'),
			array(
				'db' => 'id',
				'dt' => 'aksi',
				'formatter' => function( $d){
					return anchor('guestbook/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"');
				}
			),
			array(
				'db' => 'id',
				'dt' => 'aksi_email',
				'formatter' => function($d){
					return anchor('guestbook/reply/'.$d, '<i class="fa fa-envelope-o"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit"');
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

	public function notif_reply(){
		$id = $this->input->post('id');
		$bukutamu = $this->db->select('*')->from('bukutamu')->where('id', $this->input->post('id'))->get()->row();

		if ($bukutamu) {
			$this->db->where('id',$this->input->post('id'))->update('bukutamu', array('read_status'=>1));

			$data['update_count_message'] = $this->db->where('read_status', 0)->count_all_results('bukutamu');
			$data['redirect'] = site_url('guestbook/reply/'.$id);
			$data['success'] = true;
		} else {
			$data['success'] = false;
		}

		echo json_encode($data);
	}

	public function reply($id){
		if ($this->uri->segment(3) == null) {
			redirect('users');
		} else {
			$arr_guestbook = $this->db_model->get('bukutamu', $id);
			$data['page'] = 'reply';
			$data['message_success'] = '';
			$data['form_id'] = 'form_guest_reply';
			$data['form_name'] = 'form_guest_reply';
			$data['form_action'] = site_url('guestbook/send');
			$data['arr_guestbook']= $arr_guestbook;
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/guestbook.js'),
					'type' => 'js'
					)
				);
			$this->load_admin_view($data);
		}
	}

	public function delete(){
		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->db_model->delete('bukutamu', $id);
		}
		redirect('guestbook');
	}

	public function send(){
			$id = $this->input->post('id');

			$subject = $this->input->post('subject');
			$email = $this->input->post('email');
			$email_from = $this->input->post('email_from');
			$pass_email = $this->input->post('pass_email');
			$pesan = $this->input->post('pesan');

			$number_of_files = sizeof($_FILES['userfile']['tmp_name']);
			$files = $_FILES['userfile'];

			$config['upload_path'] = FCPATH.'/assets/emails/';
			$config['allowed_types'] = '*';
			for ($i=0; $i < $number_of_files; $i++) { 
				$_FILES['userfile']['name'] = $files['name'][$i];
				$_FILES['userfile']['type'] = $files['type'][$i];
				$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['userfile']['error'] = $files['error'][$i];
				$_FILES['userfile']['size'] = $files['size'][$i];

				$this->upload->initialize($config);

				$multi_upload = $this->upload->do_upload('userfile');
				$data['uploads'][$i] = $this->upload->data();
			}

			$this->load->library('email');
			$config = array();
			$config['charset'] = 'utf-8';
			$config['useragent'] = 'Codeigniter';
			$config['protocol'] = "smtp";
			$config['mailtype'] = "html";
			$config['smtp_host'] = "ssl://hestia.hideserver.net";
			$config['smtp_port'] = "465";
			$config['smtp_timeout'] = "400";
			$config['smtp_user'] = "noreply@manadopodhouse.com";
			$config['smtp_pass'] = "mdopod.2018";
			$config['crlf'] = "\r\n";
			$config['newline'] = "\r\n";
			$config['wordwrap'] = TRUE;

			$this->email->initialize($config);
			if (empty($multi_upload)) {
				$this->email->from($config['smtp_user'], 'Manado Pod House');
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($pesan);

				if ($this->email->send()) {
					$data['message_success']="<div class='alert alert-success'>Send Email Success</div>";
					$arr_guestbook = $this->db_model->get('bukutamu', $id);
					$data['page'] = 'reply';
					$data['arr_guestbook']= $arr_guestbook;
					$this->load_admin_view($data);
				} else {
					show_error($this->email->print_debugger());
				}
			} else {				
				foreach ($data['uploads'] as $key => $value) {
					$this->email->attach($value['full_path']);
				}

				$this->email->from($config['smtp_user'], 'Manado Pod House');
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($pesan);

				if ($this->email->send()) {
					$data['message_success']="<div class='alert alert-success'>Send Email Success</div>";
					$arr_guestbook = $this->db_model->get('bukutamu', $id);
					$data['page'] = 'reply';
					$data['arr_guestbook']= $arr_guestbook;
					$this->load_admin_view($data);
				} else {
					show_error($this->email->print_debugger());
				}		
			}
	}
}
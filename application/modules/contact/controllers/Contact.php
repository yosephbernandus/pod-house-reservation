<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Site_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('model_reservasi');
	}

	public function ajax_simpan(){
		if ($_POST != NULL) {
			$arr['tanggal'] = date('Y-m-d');
			$arr['nama'] = $this->input->post('nama');
			$arr['pesan'] = $this->input->post('pesan');
			$arr['email'] = $this->input->post('email');
			$arr['telp'] = $this->input->post('telp');

			// $simpan = array(
			// 	'tanggal' => $tanggal,
			// 	'nama' => $nama,
			// 	'pesan' => $pesan,
			// 	'email' => $email,
			// 	'telp' => $phone,
			// 	);

			$this->db->insert('bukutamu', $arr);
			$detail = $this->db->select('*')->from('bukutamu')->where('id', $this->db->insert_id())->get()->row();
			$arr['tanggal'] = $detail->tanggal;
			$arr['nama'] = $detail->nama;
			$arr['pesan'] = $detail->pesan;
			$arr['email'] = $detail->email;
			$arr['telp'] = $detail->telp;
			$arr['id'] = $detail->id;
			$arr['new_count_message'] = $this->db->where('read_status', 0)->count_all_results('bukutamu');
			

			
			// $nama = $this->model_reservasi->simpan_contact($simpan);


				// $config = array();
				// $config['charset'] = 'utf-8';
				// $config['useragent'] = 'Codeigniter';
				// $config['protocol'] = "smtp";
				// $config['mailtype'] = "html";
				// $config['smtp_host'] = "ssl://hestia.hideserver.net";

				// $config['smtp_port'] = "465";
				// $config['smtp_timeout'] = "400";
				// $config['smtp_user'] = "noreply@manadopodhouse.com";
				// $config['smtp_pass'] = "mdopod.2018";
				// $config['crlf'] = "\r\n";
				// $config['newline'] = "\r\n";
				// $config['wordwrap'] = TRUE;

				// $this->email->initialize($config);
				// $this->email->from($config['smtp_user'], 'Guestbook Masuk');
				// $this->email->to(array('info@manadopodhouse.com', 'admin@manadopodhouse.com'));
				// $this->email->reply_to($email);
				// $this->email->subject("Guestbook");

				// $data['guestbook'] = $this->model_reservasi->view_email_con($nama)->row_array();
	

				// $body = $this->load->view('email_con', $data, TRUE);

				// $this->email->message($body);
				// $this->email->send();
				echo json_encode($arr);
		} else {
			redirect('reservasi');
		}
	}
}

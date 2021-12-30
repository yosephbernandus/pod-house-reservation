<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends Site_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('model_reservasi');
	}

	public function index()
	{
		if (isset($_POST['check_in'])) {
			$data = array();
			$data['page_title'] = 'Booking';
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
			$check_in = $this->input->post('check_in');
			$check_out = $this->input->post('check_out');
			$room = $this->input->post('room');

			$datetime1 = new DateTime($check_in);
			$datetime2 = new DateTime($check_out);
			$difference = $datetime1->diff($datetime2);

			$data['jumlah_room'] = $room;
			$data['selisih'] = $difference->days;
			$data['check_in'] = $check_in;
			$data['check_out'] = $check_out;
			$data['room'] = $this->db->get('room')->result();
			$this->load_site_view($data);
		} else {
			$data = array();
			$data['page_title'] = 'Booking';
			$data['assets_header'] = array(
			// array(
			// 	'href' => base_url('assets/css/home.css'),
			// 	'type' => 'css'
			// )
				);

			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/reservasi.js'),
					'type' => 'js'
				)
			);
			$data['room'] = $this->db->get('room')->result();
			$data['jumlah_room'] = "1";
			$data['selisih'] = "1";
			$data['check_in'] = date('Y-m-d');
			$data['check_out'] = strtotime('+1 day',strtotime($data['check_in']));
			$data['check_out'] = date('Y-m-d',$data['check_out']);
			$this->load_site_view($data);
		}
	}

	public function checkout(){
		if (empty($_SESSION['cart'])) {
			redirect('reservasi');
		} else {
			$data = array();
			$data['page_title'] = 'Checkout';
			$data['page'] = 'checkout';
			$data['assets_header'] = array(
				// array(
				// 	'href' => base_url('assets/css/home.css'),
				// 	'type' => 'css'
				// )
			);

			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/reservasi.js'),
					'type' => 'js'
				)
			);
			$data['date_now'] = date('Y-m-d');
			$data['noauto'] = $this->_nootomatis();
			$this->load_site_view($data);
		}
	}

	public function add(){
		if (isset($_POST['check_in'])) {
			if (empty($_SESSION['cart'])) {
				$_SESSION['cart'] = array();
			}
			array_push($_SESSION['cart'], $_POST);

			redirect('reservasi');
		} else {
			redirect('reservasi');
		}
	}

	public function ajax_simpan_reservasi(){
		if ($_POST != NULL) {
			foreach ($_SESSION['cart'] as $cart) {
				$input_date = $this->input->post('date_now');
				$id_reservasi = $this->input->post('id_reservasi');
				$guest_name = $this->input->post('guest_name');
				$province = $this->input->post('province');
				$email = $this->input->post('email');
				$country = $this->input->post('country');
				$company = $this->input->post('company');
				$phone = $this->input->post('telp');
				$id_room = $cart['id_room'];
				$check_in = $cart['check_in'];
				$check_out = $cart['check_out'];
				$jumlah_room = $cart ['jumlah_room'];
				$selisih = $cart['selisih'];
				$subtotal = $cart['total'];
				$status = 'booking';

				$simpan = array(
					'input_date' => $input_date,
					'id_reservasi' => $id_reservasi,
					'guest_name' => $guest_name,
					'province' => $province,
					'email' => $email,
					'country' => $country,
					'company' => $company,
					'telp' => $phone,
					'id_room' => $id_room,
					'check_in' => $check_in,
					'check_out' => $check_out,
					'jumlah' => $jumlah_room,
					'selisih' => $selisih,
					'total' => $subtotal,
					'status' => $status
				);


				$id_reservasi = $this->model_reservasi->simpan($simpan);
				$reservasi_detail = $this->db->select('*')->from('reservasi')->where('id', $this->db->insert_id())->get()->row();
				$arr['id_reservasi'] = $reservasi_detail->id_reservasi;
				$arr['guest_name'] = $reservasi_detail->guest_name;
				$arr['email'] = $reservasi_detail->email;
				$arr['telp'] = $reservasi_detail->telp;
				$arr['id'] = $reservasi_detail->id;
				$arr['new_reservasi_message'] = $this->db->where('read_status', 0)->count_all_results('reservasi');
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
				$this->email->from($config['smtp_user'], 'Manado Pod House');
				$this->email->to($email);
				$this->email->reply_to('info@manadopodhouse.com');
				$this->email->subject("Reservation");

				$data['pemesanan'] = $this->model_reservasi->view_email($id_reservasi)->row_array();
				$data['detail'] = $this->model_reservasi->view_email($id_reservasi)->result();

				$body = $this->load->view('email', $data, TRUE);

				$this->email->message($body);
				$this->email->send();
				unset($_SESSION['cart']);
				echo json_encode($arr);	
			}
		} else {
			redirect('reservasi');
		}
	}

	public function ajax_add_testimoni(){
		$json = array();
		$json['success'] = TRUE;
		$json['message'] = '';
		$json['error'] = '';

		try {
			$this->db->trans_start();
			$testimoni_records = array();

			$id_reservasi = $this->input->post('id_booking');
			$pesan = $this->input->post('pesan_testimoni');
			$rating = $this->input->post('rating');
			$cek = $this->model_reservasi->check($id_reservasi);
			$cek_input = $this->model_reservasi->check_submit($id_reservasi);
			$status = "pending";

			if ($cek->num_rows()>0) {
				if ($cek_input->num_rows()>0) {
					$json['message'] = "Booking id sudah di submit";
					$json['submitted'] = FALSE;
				} else {
					$booking_data = $this->model_reservasi->check($id_reservasi)->result();
					foreach ($booking_data as $row) {
						if ($row->status == 'booking') {
							$json['message'] = "Anda Belum Checkout";
							$json['notcheckout'] = FALSE;
						} else {
							$simpan = array(
								'id_reservasi' => $row->id_reservasi,
								'nama' => $row->guest_name,
								'pesan' => $pesan,
								'email' => $row->email,
								'company' => $row->company,
								'rating' => $rating,
								'status' => $status
							);

						if($this->db->insert('testimoni', $simpan)) {
							$json['message'] = "Thank you";
						}
						}
					}
				}
			} else {
				$json['message'] = "sorry, you cant access directly";
				$json['notfound'] = FALSE;
			}

			$this->db->trans_complete();
		} catch (Exception $e) {
			$json['message'] = $e->getMessage();
			$json['success'] = FALSE;

			unset($json['redirect']);
			if ($json['message'] ==  '') {
				$json['message'] = 'Server error.';
			}
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}

	public function ajax_sess_remove(){
		if ($_POST != NULL) {
			$id = $this->input->post('key');
			unset($_SESSION['cart'][$id]);
			redirect('reservasi');
		} else {
			redirect('reservasi');
		}
	}

	private function _nootomatis(){
		$today=date('Ymd');

		$mysqli = mysqli_connect("localhost","root","","dev_manadopodhouse");
		$query=mysqli_query($mysqli,"select max(id_reservasi) as last from reservasi where id_reservasi like '$today%'");
		// $this->db->query("select max(id_reservasi) as last from reservasi where id_reservasi like '$today%'");
		// $data = $query->result_array();
		$data=mysqli_fetch_array($query);
		$lastNoBooking=$data['last'];

		$lastNoUrut=substr($lastNoBooking, 8,3);
		$nextNoUrut=$lastNoUrut+1;
		$nextNoBook=$today.sprintf('%03s',$nextNoUrut);

		return $nextNoBook;
	}
}

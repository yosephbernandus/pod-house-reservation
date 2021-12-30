<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservasi extends Admin_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('username')) {
			redirect('auth');
		}
	}

	public function index(){
		$data = array();
		$data['page_title'] = 'Reservasi';
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
		$this->load_admin_view($data);
	}

	public function notif_reservasi(){
		$id = $this->input->post('id');
		$reservasi = $this->db->select('*')->from('reservasi')->where('id_reservasi', $this->input->post('id'))->get()->row();

		if ($reservasi) {
			$this->db->where('id_reservasi', $this->input->post('id'))->update('reservasi', array('read_status'=>1));

			$data['update_reservasi_message'] = $this->db->where('read_status', 0)->count_all_results('reservasi');
			$data['redirect'] = site_url('reservasi/view/'.$id);
			$data['success'] = true;
		} else {
			$data['success'] = false;
		}

		echo json_encode($data);
	}

	public function view($id_reservasi){
		if ($this->uri->segment(3) == null) {
			redirect('reservasi');
		} else {
			$this->db->select("reservasi.id_reservasi");
			$this->db->select("reservasi.input_date");
			$this->db->select("reservasi.guest_name");
			$this->db->select("reservasi.company");
			$this->db->select("reservasi.province");
			$this->db->select("reservasi.country");
			$this->db->select("reservasi.telp");
			$this->db->select("reservasi.email");
			$this->db->select("reservasi.jumlah");
			$this->db->select("reservasi.selisih");
			$this->db->select("reservasi.check_in");
			$this->db->select("reservasi.check_out");
			$this->db->select("reservasi.total");
			$this->db->select("room.diskon");
			$this->db->select("room.harga");
			$this->db->select("room.nama_room");
			$this->db->select("room.breakfast");
			$this->db->where("reservasi.id_reservasi",$id_reservasi);
			$this->db->join("room","room.id=reservasi.id_room");
			$arr_reservasi = $this->db_model->get('reservasi');

			$total = 0;

			foreach($arr_reservasi as $res)
			{
				$total += $res->total;
			}

			$data['total'] = $total;
			$data['page'] = 'view';
			$data['arr_reservasi'] = $arr_reservasi[0];
			$data['arr_detail'] = $arr_reservasi;
			$this->load_admin_view($data);
		}
	}

	public function report($id_reservasi){
		if ($this->uri->segment(3) == null) {
			redirect('reservasi');
		} else {
			$this->db->select("reservasi.id_reservasi");
			$this->db->select("reservasi.input_date");
			$this->db->select("reservasi.guest_name");
			$this->db->select("reservasi.company");
			$this->db->select("reservasi.province");
			$this->db->select("reservasi.country");
			$this->db->select("reservasi.telp");
			$this->db->select("reservasi.email");
			$this->db->select("reservasi.jumlah");
			$this->db->select("reservasi.selisih");
			$this->db->select("reservasi.check_in");
			$this->db->select("reservasi.check_out");
			$this->db->select("reservasi.total");
			$this->db->select("room.diskon");
			$this->db->select("room.harga");
			$this->db->select("room.nama_room");
			$this->db->select("room.breakfast");
			$this->db->where("reservasi.id_reservasi",$id_reservasi);
			$this->db->join("room","room.id=reservasi.id_room");
			$arr_reservasi = $this->db_model->get('reservasi');

			$total = 0;

			foreach($arr_reservasi as $res)
			{
				$total += $res->total;
			}

			$data['total'] = $total;
			
			$data['arr_reservasi'] = $arr_reservasi[0];
			$data['arr_detail'] = $arr_reservasi;
			$this->load->view('print', $data);
		}
	}

	public function edit($id_reservasi){
		if ($this->uri->segment(3) == null) {
			redirect('reservasi');
		} else {

			$this->db->select("reservasi.id");
			$this->db->select("reservasi.id_reservasi");
			$this->db->select("reservasi.guest_name");
			$this->db->select("reservasi.status");
			$this->db->where("reservasi.id_reservasi",$id_reservasi);
			$this->db->join("room","room.id=reservasi.id_room");
			$arr_reservasi = $this->db_model->get('reservasi');
			
			$data['page'] = 'edit';
			$data['form_id'] = 'form_reservasi_edit';
			$data['form_action'] = site_url('reservasi/ajax_edit');
			$data['arr_reservasi']= $arr_reservasi[0];
			$data['assets_footer'] = array(
				array(
					'href' => base_url('assets/javascript/reservasi.js'),
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
			$reservasi_records = array();
			foreach ($_POST as $k => $v)
			{
				$v = $this->input->post($k);

				if($v == '')
				{
					unset($k);
				}
				else
				{
					
					$reservasi_records[$k] = $v;
				}
			}
			$this->_edit($reservasi_records);
			$json['message'] = 'Reservasi was saved';
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

	public function delete(){
		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->db_model->delete_reservasi('reservasi', $id);
		}
		redirect('reservasi');
	}

	private function _edit($reservasi_records){
		if (!isset($reservasi_records['id'])) {
			throw new Exception("Server Error");
		}
		
		$this->db_model->update('reservasi', $reservasi_records['id'], $reservasi_records);
	}

	public function data(){
		$table = 'reservasi';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array('db' => 'id_reservasi', 'dt' => 'id_reservasi'),
			array('db' => 'guest_name', 'dt' => 'guest_name'),
			array('db' => 'check_in', 'dt' => 'check_in'),
			array('db' => 'check_out', 'dt' => 'check_out'),
			array('db' => 'status', 'dt' => 'status'),
			array(
				'db' => 'id_reservasi',
				'dt' => 'aksi',
				'formatter' => function( $d){
					return anchor('reservasi/view/'.$d, '<i class="fa fa-eye"></i>','class="btn btn-xs btn-primary tooltips" data-placement="top" data-original-title="Edit"').' '.anchor('reservasi/report/'.$d,'<i class="fa fa-print"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"').' '.anchor('reservasi/edit/'.$d,'<i class="fa fa-edit"></i>','class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Edit"');
				}
			),
			array(
				'db' => 'id_reservasi',
				'dt' => 'aksi_hapus',
				'formatter' => function($d){
					return anchor('reservasi/delete/'.$d,'<i class="fa fa-trash"></i>','class="btn btn-xs btn-danger tooltips" data-placement="top" data-original-title="Delete"');
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
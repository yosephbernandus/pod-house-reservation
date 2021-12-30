<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_reservasi extends CI_Model{
	private $table="reservasi";
	private $primary="id_reservasi";

	public function simpan($simpan){
		$this->db->insert("reservasi",$simpan);
		return $this->db->insert_id();
	}

	public function simpan_contact($simpan){
		$this->db->insert("bukutamu",$simpan);
		return $this->db->insert_id();
	}

	public function view_email($id_reservasi){
		$this->db->select("*");
		$this->db->from("reservasi");
		$this->db->where("id", $id_reservasi);
		$this->db->join("room","room.id_room=reservasi.id_room");
		return $this->db->get();
	}

	public function view_email_con($nama){
		$this->db->select("*");
		$this->db->from("bukutamu");
		$this->db->where("id", $nama);
		return $this->db->get();
	}


	public function check($id_reservasi){
		$this->db->select("*");
		$this->db->where('id_reservasi',$id_reservasi);
		return $this->db->get('reservasi');
	}

	public function check_submit($id_reservasi){
		$this->db->select("*");
		$this->db->where('id_reservasi',$id_reservasi);
		return $this->db->get('testimoni');
	}
}
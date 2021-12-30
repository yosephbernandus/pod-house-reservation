<?php
class Model_administrator extends CI_Model {
	
	public function cek ($username){
		$this->db->select('*');
		$this->db->where("user",$username);
		// $this->db->where("password",$password);
		return $this->db->get("administrator");
	}


	public function semua(){
		return $this->db->get('administrator');
	}

	public function cekKode($kode){
		$this->db->where('user',$kode);
		return $this->db->get('administrator');
	}

	public function cekId($kode){
		$this->db->where('id_admin', $kode);
		return $this->db->get("administrator");
	}

	public function cekUser($kode){
		$this->db->where('user', $kode);
		return $this->db->get("administrator");
	}

	public function update($password){
		if (empty($password)) {
			$data = array(
				'user' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'level' => $this->input->post('level')
			);
		} else {
			$data = array(
				'user' => $this->input->post('username'),
				'password' => password_hash($password, PASSWORD_DEFAULT),
				'email' => $this->input->post('email'),
				'level' => $this->input->post('level')
			);
		}
		$id = $this->input->post('id_admin');
		$this->db->where("id_admin",$id);
		$this->db->update("administrator",$data);
    }

    public function simpan($info){
    	$this->db->insert("administrator",$info);
    }

    public function hapus($kode){
    	$this->db->where('id_admin',$kode);
    	$this->db->delete("administrator");
    }


}
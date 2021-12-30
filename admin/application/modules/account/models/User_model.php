<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function check_unique_user_email($id = '', $email)
	{
		$this->db->select('id, user_email');

		if($id != '')
		{
			$this->db->where('id !=', $id);
		}

		$this->db->where('user_email', $email);

		$query = $this->db->get('administrator');
		$row = $query->result();

		return $row;
	}

	function check_unique_user_name($id = '', $user_name)
	{
		$this->db->select('id, user');

		if($id != '')
		{
			$this->db->where('id !=', $id);
		}

		$this->db->where('user', $user_name);

		$query = $this->db->get('administrator');
		$row = $query->result();

		return $row;
	}

	function load_email($email = '')
	{
		$this->db->select('email');
		$this->db->where('email', $email);

		$query = $this->db->get('user');
		$row = $query->result();

		return $row;
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function auto_increment_reset($table)
	{
		$max_id = $this->db_model->maximum($table, 'id');
		$max_id = $max_id + 1;

		$table = 'an_' . $table;

		return $this->db->query("ALTER TABLE $table AUTO_INCREMENT = $max_id");
	}

	public function count($table)
	{
		return $this->db->count_all_results($table);
	}

	public function delete($table, $id = 0)
	{
		if (is_array($id) && count($id) > 0)
		{
			$this->db->where_in('id', $id);
		}
		elseif (!is_array($id) && $id > 0)
		{
			$this->db->where('id', $id);
		}
		else
		//if (count($this->db->ar_where) <= 0)
		{
			return FALSE;
		}

		return $this->db->delete($table);
	}

	public function get($table, $id = 0)
	{
		if (is_array($id))
		{
			if (count($id) <= 0)
			{
				$this->db->flush_cache();
				// $this->db->ar_select = array();
				// $this->db->ar_from = array();
				// $this->db->ar_join = array();
				// $this->db->ar_where = array();
				// $this->db->ar_like = array();
				// $this->db->ar_groupby = array();
				// $this->db->ar_having = array();
				// $this->db->ar_orderby = array();
				// $this->db->ar_wherein = array();
				// $this->db->ar_aliased_tables = array();
				// $this->db->ar_no_escape = array();
				// $this->db->ar_distinct = FALSE;
				// $this->db->ar_limit = FALSE;
				// $this->db->ar_offset = FALSE;
				// $this->db->ar_order = FALSE;

				return array();
			}

			$this->db->where_in('id', $id);
		}
		elseif ($id > 0)
		{
			$this->db->where('id', $id);
		}

		$query = $this->db->get($table);

		if (!is_array($id) && $id > 0)
		{
			return $query->first_row();
		}

		return $query->result();
	}

	public function get_db_size()
	{	
		$dbName = $this->db->database;
		
		$dbName = $this->db->escape($dbName);
		
		$sql = "SELECT table_schema AS db_name, sum( data_length + index_length ) AS db_size_mb 
				FROM information_schema.TABLES 
				WHERE table_schema = $dbName
				GROUP BY table_schema ;";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 1) {
			
			$row = $query->row(); 
			$size = $row->db_size_mb;
			return $size;
		   
		} else {
			
			log_message('ERROR', "*** Unexpected number of rows returned " . ' | line ' . __LINE__ . ' of ' . __FILE__);
			show_error('Sorry, an error has occured.');
			
		}
	}

	public function get_enums($table = '', $field = '')
    {
        $enums = array();
		
		if ($table == '' || $field == '') return $enums;
        $CI =& get_instance();
        preg_match_all("/'(.*?)'/", $CI->db->query("SHOW COLUMNS FROM {$table} LIKE '{$field}'")->row()->Type, $matches);
        foreach ($matches[1] as $key => $value) {
            $enums[$value] = $value; 
        }
        return $enums;
    }  

	public function get_json($table, $column_id = 0, $row_id = 0, $column_detail = '')
	{
		$column = 'name';

		if(is_numeric($column_id))
		{
			$column = 'id';
		}

		$this->db->select('value');
		$this->db->where($column, $column_id);

		$query = $this->db->get('setting');
		$row = $query->result();

		$row = json_decode($row[0]->value);

		if($row_id <= 0)
		{
			return $row;
		}
		else
		{
			foreach($row as $r)
			{
				if($row_id == $r->id)
				{
					if($column_detail != '')
					{
						return $r->$column_detail;
					}

					return $r;
				}
			}
		}
	}

	public function maximum($table, $field)
	{
		$this->db->select_max($field);
		$arr_max = $this->db_model->get($table);

		$arr_field_part = explode('.', $field);
		$field = array_pop($arr_field_part);

		return ($arr_max[0]->$field == NULL) ? 0 : $arr_max[0]->$field;
	}

	public function minimum($table, $field)
	{
		$this->db->select_min($field);
		$arr_min = $this->core_model->get($table);

		$arr_field_part = explode('.', $field);
		$field = array_pop($arr_field_part);

		return ($arr_min[0]->$field == NULL) ? 0 : $arr_min[0]->$field;
	}

	public function insert($table, $record = array())
	{
		$user_id = $this->session->userdata('user_id');
		
		if($user_id && !isset($record['author_id']))
		{
			$record['author_id'] = $this->session->userdata('user_id');
		}
		
		$record['created'] = date('Y-m-d H:i:s');

		if (!$this->db->insert($table, $record))
		{
			return FALSE;
		}

		return $this->db->insert_id();
	}

	public function insert_batch($table, $arr_record = array())
	{
		foreach ($arr_record as $k => $record)
		{
			$arr_record[$k]['created'] = date('Y-m-d H:i:s');
			$arr_record[$k]['author_id'] = $this->session->userdata('user_id');
		}

		$this->db->insert_batch($table, $arr_record);
	}

	public function update($table, $id = 0, $record = array())
	{
		if (is_array($id) && count($id) > 0)
		{
			$this->db->where_in('id', $id);
		}
		elseif (!is_array($id) && $id > 0)
		{
			$this->db->where('id', $id);
		}
		else
		// if (count($this->db->qb_where) <= 0)
		{
			return FALSE;
		}

		$record['updated'] = date('Y-m-d H:i:s');

		return $this->db->update($table, $record);
	}

	public function update_batch($table, $arr_record = array())
	{
		foreach ($arr_record as $k => $record)
		{
			$arr_record[$k]['updated'] = date('Y-m-d H:i:s');
		}

		$this->db->update_batch($table, $arr_record, 'id');
	}

	public function sum($table, $field)
	{
		$this->db->select_sum($field);
		$arr_sum = $this->core_model->get($table);

		return ($arr_sum[0]->$field == NULL) ? 0 : $arr_sum[0]->$field;
	}

	public function validate($table, $id = 0, $updated = 0)
	{
		if ($updated > 0)
		{
			$this->db->where('updated', date('Y-m-d H:i:s', $updated));
		}

		$this->db->where('id', $id);
		$core_count = $this->count();

		return ($core_count > 0) ? TRUE : FALSE;
	}

}

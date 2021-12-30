<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_function
{
	public function compile_join($table)
	{
		$CI = &get_instance();

		$arr_field = explode(', ', $CI->input->post('select'));

		foreach ($arr_field as $field)
		{
			if (!preg_match('/_id$/', $field) || $field == 'ref_id')
			//if (!preg_match('/_id$/', $field) || $field == 'ref_id' || $field == 'buyer_id' || $field == 'seller_id' || $field == 'account_id')
			{
				continue;
			}

			$table_foreign = preg_replace('/_id$/', '', $field);
			$table_foreign = $CI->aba_function->translate_table($table_foreign);

			if ($table_foreign == $table)
			{
				$CI->db->join("{$table_foreign} AS {$table_foreign}1", "{$table_foreign}1.id = {$table}.{$field}", 'left');
			}
			else
			{
				switch ($table_foreign)
				{
					case 'coa_credit': $CI->db->join("coa AS coa_credit", "coa_credit.id = {$table}.{$field}", 'left'); break;
					case 'coa_debit': $CI->db->join("coa AS coa_debit", "coa_debit.id = {$table}.{$field}", 'left'); break;
					case 'salesperson': $CI->db->join("user AS salesperson", "salesperson.id = {$table}.{$field}", 'left'); break;
					default: $CI->db->join("{$table_foreign}", "{$table_foreign}.id = {$table}.{$field}", 'left');
				}
			}
		}
	}

	public function compile_limit($table)
	{
		$CI = &get_instance();

		$limit = $CI->input->post('limit');
		$start = $CI->input->post('start');

		if ($limit !== FALSE && $start !== FALSE)
		{
			$CI->db->limit($limit, $start);
		}
	}

	public function compile_order_by($table)
	{
		$CI = &get_instance();

		$arr_sort = json_decode($CI->input->post('sort'));

		if (!$arr_sort)
		{
			return;
		}

		foreach ($arr_sort as $sort)
		{
			$sort->property = preg_replace('/_link$/', '', $sort->property);

			$arr_part = explode('__', $sort->property);

			if (count($arr_part) > 1)
			{
				$CI->db->order_by("{$arr_part[0]}.{$arr_part[1]} {$sort->direction}");
			}
			else
			{
				$CI->db->order_by("{$table}.{$sort->property} {$sort->direction}");
			}
		}
	}

	public function compile_select($table, $arr_select = array())
	{
		$CI = &get_instance();

		$select = $CI->input->post('select');

		if ($select == '')
		{
			$CI->db->select('id');

			return;
		}

		$arr_select = (count($arr_select) > 0) ? array_merge($arr_select, explode(', ', $select)) : explode(', ', $select);
		$arr_select_new = array();

		foreach ($arr_select as $select)
		{
			if ($select == '')
			{
				continue;
			}

			if (preg_match('/__/', $select))
			{
				$arr_part = explode('__', $select);
				$table_foreign = $CI->aba_function->translate_table($arr_part[0]);

				if ($table_foreign == $table)
				{
					$arr_select_new[] = "{$table_foreign}1.{$arr_part[1]} AS {$select}";
				}
				else
				{
					$arr_select_new[] = "{$table_foreign}.{$arr_part[1]} AS {$select}";
				}
			}
			else
			{
				$arr_select_new[] = "{$table}.{$select} AS {$select}";
			}
		}

		if (count($arr_select_new) > 0)
		{
			$CI->db->select(implode(', ', $arr_select_new));
		}
	}

	public function compile_where($table)
	{
		$CI = &get_instance();

		$arr_filter = json_decode($CI->input->post('filter'));
		$arr_filter_extra = json_decode($CI->input->post('filter_extra'));

		if ($arr_filter)
		{
			foreach ($arr_filter as $k => $filter)
			{
				$arr_filter[$k]->field = preg_replace('/_link$/', '', $filter->property);
			}

			$CI->aba_database->apply_filters($arr_filter, $table);
		}

		if ($arr_filter_extra)
		{
			foreach ($arr_filter_extra as $k => $filter_extra)
			{
				$arr_filter_extra[$k]->field = preg_replace('/_link$/', '', $filter_extra->property);
			}

			$CI->aba_database->apply_filters($arr_filter_extra, $table);
		}

		$query = $CI->input->post('query');

		if ($query == '')
		{
			$query = $CI->input->post('keyword');
		}

		$search = $CI->input->post('field');

		if ($search == '')
		{
			$search = $CI->input->post('search');
		}

		$arr_keyword = ($query == '') ? array() : explode(' ', $query);
		$arr_search = explode(', ', $search);
		$arr_where = array();

		foreach ($arr_search as $search)
		{
			$search = (preg_match('/__/', $search)) ? preg_replace('/__/', '.', $search) : $table . '.' . $search;

			$sql = array();

			foreach ($arr_keyword as $keyword)
			{
				$sql[] = "({$search} LIKE '%{$keyword}' OR {$search} LIKE '{$keyword}%' OR {$search} LIKE '%{$keyword}%')";
			}

			if (count($sql) > 0)
			{
				$arr_where[] = '(' . implode(' AND ', $sql) . ')';
			}
		}

		if (count($arr_where) > 0)
		{
			$CI->db->where('(' . implode(' OR ', $arr_where) . ')');
		}
	}

	public function extract_records($records, $field)
	{
		$data = array();

		foreach ($records as $record)
		{
			if (!isset($record->$field) || isset($data[$record->$field]))
			{
				continue;
			}

			$data[$record->$field] = $record->$field;
		}

		return array_values($data);
	}

	public function date_indo($date)
	{
		if($date == '0000-00-00 00:00:00')
		{
			return;
		}

		$CI = &get_instance();

		$date = strtotime($date);

		$date_user_timezone = strtotime($CI->setting_model->user_timezone('php') . ' hours') - time();

		$date = $date + $date_user_timezone;

		$date = date('Y-m-d H:i:s', $date);

		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl = substr($date, 8, 2);

		$jam = substr($date, 11, 2);
		$menit = substr($date, 14, 2);
		$detik = substr($date, 17, 2);

		$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun . ' ' . $jam . ':' . $menit . ':' . $detik;

		return $result;
	}

	public function rupiah($angka)
	{
		$jadi = "Rp. " . number_format($angka,2,',','.');
		return $jadi;
	}

	public function time_elapsed_string($datetime, $full = false)
	{
		if($datetime == '0000-00-00 00:00:00')
		{
			return;
		}

		$CI = &get_instance();

		$date_user_timezone = strtotime($CI->session->userdata('user_timezone') . ' hours') - time();
		$datetime = strtotime($datetime);
		$datetime = date('Y-m-d H:i:s', $datetime);

		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}	
}

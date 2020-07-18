<?php 

	function dd($message, $is_exit='')
	{
		switch ($is_exit) {
			case 1:
				echo "<pre>";
				print_r ($message);
				echo "</pre>";
				break;
			
			default:
				echo "<pre>";
				var_dump ($message);
				echo "</pre>";
				die();
				break;
		}
	}

	function PopulateForm()
	{
		$CI = &get_instance();
		$post = array();
		foreach (array_keys($_POST) as $key) {
			$post[$key] = $CI->input->post($key);
		}
		return $post;
	}

	function active_year()
	{
		$http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$CI =& get_instance();
		$data = $CI->curl_lib->exec_curl($hostapi.'/api_bkd/active_year', $http_header);
		$decode_data = json_decode($data);
		return $decode_data->data;
	}

	function get_teaching_param($code)
	{
		$CI = &get_instance();
		$param = $CI->db->get_where('param_pengajaran_tambahan', ['kode' => $code])->row();
		return $param;
	}

	function guess_academic_year($year, $i)
	{
		$prefix = substr($year, 0, 4);
		$subfix = substr($year, 4, 1);

		$added_smt = $i * 0.5;
		if (($subfix % 2) == 1 && $added_smt < 1) {
			$must_add = 0;
		} elseif (($subfix % 2) == 0 && $added_smt < 1) {
			$must_add = round($added_smt);
		} elseif (($subfix % 2) == 0 && $added_smt > 0.5)  {
			$must_add = ceil($added_smt);
		} else {
			$must_add = floor($added_smt);
		}

		$res_subfix = ($subfix + $i) % 2 == 1 ? 1 : 2;

		$res_prefix = $prefix + $must_add;

		$result = $res_prefix.$res_subfix;
		return $result;
	}

	function list_year()
	{
		$CI =& get_instance();
		$http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$years = $CI->curl_lib->exec_curl($hostapi.'/api_bkd/year_list', $http_header);
		return json_decode($years);
	}

	function notohari($day)
	{
		switch ($day) {
			case 1:
				return 'Senin';
				break;

			case 2:
				return 'Selasa';
				break;

			case 3:
				return 'Rabu';
				break;

			case 4:
				return 'Kamis';
				break;

			case 5:
				return 'Jum\'at';
				break;

			case 6:
				return 'Sabtu';
				break;

			case 7:
				return 'Minggu';
				break;
			
			default:
				return '';
				break;
		}
	}

	function TanggalIndo($date, $format = '')
	{
		$BulanIndo = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$split = explode('-', $date);

		if ($format == 'd M Y')
			return $split[0] . ' ' . $BulanIndo[(int) $split[1]] . ' ' . $split[2];

		return $split[2] . ' ' . $BulanIndo[(int) $split[1]] . ' ' . $split[0];
	}

	function year_name($year)
	{
		$prefix = substr($year, 0, 4);
		$subfix = substr($year, -1);

		$subfixname = $subfix == 2 ? 'Genap' : 'Ganjil';
		$year_name = $prefix.' / '.$subfixname;
		return $year_name;
	}

	function position_name($pos)
	{
		switch ($pos) {
			case 'SAH':
				return 'Asisten Ahli';
				break;

			case 'TPD':
				return 'Tenaga Pendidik';
				break;

			case 'BIG':
				return 'Guru Besar';
				break;

			case 'LKT':
				return 'Lektor';
				break;
			
			default:
				return 'Lektor Kepala';
				break;
		}
	}
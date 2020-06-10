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
				print_r ($message);
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
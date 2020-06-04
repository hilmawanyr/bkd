<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl_lib
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function exec_curl($endpoint, $header, $is_post_req='', $body='')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		if (!empty($is_post_req)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

}

/* End of file Curl_lib.php */
/* Location: ./application/libraries/Curl_lib.php */

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib extends Curl_lib
{
	protected $ci;
	public $http_header, $hostapi;

	public function __construct()
	{
        $this->ci =& get_instance();

		$this->hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$this->http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$this->ci->load->helper('cookie');
	}

	public function is_has_cookie()
	{
		$cookie = get_cookie('sia_cookie');
		if (isset($cookie)) {
			$credential = explode('.', base64_decode($cookie));
			$username   = $credential[0];
			$usertype	= $credential[3];
			$usergroup	= $credential[2];
			$body       = json_encode(['username' => $username, 'usergroup' => $usergroup, 'usertype' => $usertype]);
			$req = $this->exec_curl($this->hostapi.'/api_bkd/cookie_login', $this->http_header, 1, $body);
			$this->_decode_auth_response($req);
		}
		return FALSE;
	}

	public function decode_response($res)
	{
		$this->_decode_auth_response($res);
	}

	private function _decode_auth_response($res)
	{
		$response = json_decode($res);

		if ($response->status == 1) {
			$payload = [
				'username' => $response->data->username,
				'homebase' => $response->data->homebase,
				'nid' => $response->data->userid,
				'nidn' => $response->data->nidn,
				'nupn' => $response->data->nupn,
				'group' => $response->data->group,
				'address' => $response->data->address,
				'phone' => substr(trim($response->data->phone), 0, 13),
				'email' => $response->data->email
			];
			$this->_create_session($payload);
		} elseif ($response->status == 3) {
			$this->ci->session->set_flashdata('fail', 'Login fail! Invalid username or password');
			redirect('auth','refresh');
		} else {
			$this->ci->session->set_flashdata('fail', 'Login fail! You don\'t have permission to access this application.');
			delete_cookie('sia_cookie');
			redirect('auth','refresh');
		}
	}

	protected function _create_session($data)
	{
		$this->ci->session->set_userdata('bkd_session', $data);
		redirect('/','refresh');
	}

}

/* End of file Auth_lib.php */
/* Location: ./application/libraries/Auth_lib.php */

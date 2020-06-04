<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $http_header, $hostapi;

	public function __construct()
	{
		parent::__construct();
		$this->http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$this->hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$this->load->helper('cookie');
	}

	/**
	 * Will be redirect to home if bkd_session or sia_cookie exist
	 * 
	 * @return void
	 */
	public function index()
	{
		if (!$this->session->userdata('bkd_session')) {
			$is_cookie_exist = $this->_is_has_cookie();
			if ($is_cookie_exist === FALSE) {
				$data['page_title'] = 'Authentication';
				$this->load->view('auth_v', $data);
			}	
		} else {
			redirect('/','refresh');
		}
	}

	/**
	 * Handle login from manually login
	 * 
	 * @return void
	 */
	public function attemp_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		(empty($username) OR empty($password)) ? redirect('auth','refresh') : '';

		$body = json_encode(['username' => $username, 'password' => $password]);
		$exec = $this->curl_lib->exec_curl($this->hostapi.'/api_bkd/attemp_login', $this->http_header, 1, $body);
		$this->_decode_auth_response($exec);
	}

	/**
	 * Cookie from SIA login will be delete when user sign out
	 * 
	 * @return void
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		setcookie('sia_cookie','',time() - 7200,'/');
		redirect('auth','refresh');
	}

	/**
	 * Checking available cookie
	 * 
	 * @return void
	 */
	private function _is_has_cookie()
	{
		$cookie = get_cookie('sia_cookie');
		if (isset($cookie)) {
			$credential = explode('.', base64_decode($cookie));
			$username   = $credential[0];
			$usertype	= $credential[3];
			$usergroup	= $credential[2];
			$body       = json_encode(['username' => $username, 'usergroup' => $usergroup, 'usertype' => $usertype]);
			$req = $this->curl_lib->exec_curl($this->hostapi.'/api_bkd/cookie_login', $this->http_header, 1, $body);
			$this->_decode_auth_response($req);
		}
		return FALSE;
	}

	/**
	 * Decode response to create session and give direct response for invalid login or permission
	 * 
	 * @return void
	 */
	private function _decode_auth_response($res)
	{
		$response = json_decode($res);

		if ($response->status == 1) {
			$this->_create_session((array)$response->data);
		} elseif ($response->status == 3) {
			$this->session->set_flashdata('fail', 'Login fail! Invalid username or password');
			redirect('auth','refresh');
		} else {
			$this->session->set_flashdata('fail', 'Login fail! You don\'t have permission to access this application.');
			delete_cookie('sia_cookie');
			redirect('auth','refresh');
		}
	}

	/**
	 * Create main session
	 * 
	 * @return void
	 */
	protected function _create_session($data)
	{
		$this->session->set_userdata('bkd_session', $data);
		redirect('/','refresh');
	}

}

/* End of file Auth.php */
/* Location: ./application/modules/auth/controllers/Auth.php */
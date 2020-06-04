<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $http_header, $hostapi;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth_lib');
		$this->http_header = $this->auth_lib->http_header;
		$this->hostapi = $this->auth_lib->hostapi;
	}

	public function index()
	{
		if (!$this->session->userdata('bkd_session')) {
			$is_cookie_exist = $this->auth_lib->is_has_cookie();
			if ($is_cookie_exist === FALSE) {
				$data['page_title'] = 'Authentication';
				$this->load->view('auth_v', $data);
			}	
		} else {
			redirect('/','refresh');
		}
	}

	public function attemp_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		(empty($username) OR empty($password)) ? redirect('auth','refresh') : '';

		$body = json_encode(['username' => $username, 'password' => $password]);
		$exec = $this->auth_lib->exec_curl($this->hostapi.'/api_bkd/attemp_login', $this->http_header, 1, $body);
		$this->auth_lib->decode_response($exec);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		setcookie('sia_cookie','',time() - 7200,'/');
		redirect('auth','refresh');
	}

}

/* End of file Auth.php */
/* Location: ./application/modules/auth/controllers/Auth.php */
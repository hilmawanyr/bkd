<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->username = $this->session->userdata('bkd_session')['username'];
	}

	public function index()
	{
		$data['username']  = $this->username;
		$data['pagename']  = 'Dashboard';
		$data['page'] = 'home_v';
		$this->load->view('template/template', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/modules/home/controllers/Home.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	protected $tahunakademik;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->tahunakademik = active_year()->kode_tahun;
		$this->load->model('home/home_model','hm');
	}

	public function index()
	{
		$data['pagename']  = 'Dashboard';
		$data['page'] = 'home_v';
		$this->load->view('template/template', $data);
	}

	public function total_pengajaran()
	{
		$rowData = $this->hm->data_pengajaran($this->userid, $this->tahunakademik);
		echo $rowData;
	}

	public function sks_pengajaran()
	{
		$rowData = $this->hm->sks_pengajaran($this->userid, $this->tahunakademik);
		echo number_format($rowData, 2);
	}

	public function total_penelitian()
	{
		$rowData = $this->hm->data_penelitian($this->userid, $this->tahunakademik);
		echo $rowData;
	}

	public function sks_penelitian()
	{
		$rowData = $this->hm->sks_penelitian($this->userid, $this->tahunakademik);
		echo number_format($rowData, 2);
	}

	public function total_abdimas()
	{
		$rowData = $this->hm->data_pengabdian($this->userid, $this->tahunakademik);
		echo $rowData;
	}

	public function sks_abdimas()
	{
		$rowData = $this->hm->sks_pengabdian($this->userid, $this->tahunakademik);
		echo number_format($rowData, 2);
	}

	public function position()
	{
		$rowData = $this->hm->position($this->userid, $this->tahunakademik);
		echo $rowData;
	}

}

/* End of file Home.php */
/* Location: ./application/modules/home/controllers/Home.php */
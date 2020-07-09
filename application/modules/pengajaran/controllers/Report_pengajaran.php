<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_pengajaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->load->model('report_pengajaran_model', 'rpm');
	}

	public function index()
	{
		$data['years'] = list_year()->data;
		$data['teaches'] = $this->rpm->get_pengajaran($this->userid, active_year()->kode_tahun);
		$data['pagename'] = 'Laporan Pengajaran';
		$data['page'] = 'report_pengajaran_v';
		$this->load->view('template/template', $data);
	}

	public function detail(string $year) : void
	{
		$data['teaches'] = $this->rpm->get_pengajaran($this->userid, $year);
		$this->load->view('tabel_claim_pengajaran_pertahun', $data);		
	}

	public function claim(string $code) : void
	{
		$this->db->insert('laporan_pengajaran', ['kode_transaksi' => $code]);
		echo $this->db->affected_rows();
	}

	public function flag(string $code) : void
	{
		$claim = $this->rpm->is_claimed($code);
		$docs  = $this->rpm->has_docs($code);

		if ($claim == 1 && $docs > 0) {
			echo '<a class="btn btn-xs bg-green">Document attached</a>';
		} elseif ($claim == 1 && $docs == 0) {
			echo '<a class="btn btn-xs bg-orange" style="cursor: text">Claimed</a>';
		} else {
			echo '<a class="btn btn-xs btn-default" style="cursor: text">Unclaimed</a>';
		}
	}

	public function attach_file()
	{
		$code = $this->input->post('code');
		$url = $this->input->post('link');

		$data = [
			'kode_transaksi' => $code,
			'url' => $url
		];

		$this->db->insert('dokumen_bukti_pengajaran', $data);
		$this->session->set_flashdata('success', 'Dokumen bukti berhasil dilampirkan');
		redirect('laporan-pengajaran','refresh');
	}

}

/* End of file Report_pengajaran.php */
/* Location: ./application/modules/pengajaran/controllers/Report_pengajaran.php */
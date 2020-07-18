<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_pengabdian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->load->model('pengabdian/devotion_report_model','drm');
	}

	public function index()
	{
		$data['years'] = list_year()->data;
		$data['devs'] = $this->drm->get_devotions($this->userid, active_year()->kode_tahun);
		$data['pagename'] = 'Laporan Pengabdian';
		$data['page'] = 'report_pengabdian_v';
		$this->load->view('template/template', $data);
	}

	/**
	 * Show devotion per academic year
	 * 
	 * @param int $tahunakademik
	 * @return void
	 */
	public function get_dev_peryear(int $tahunakademik) : void
	{
		$data['devs'] = $this->drm->get_devotions($this->userid, $tahunakademik);
		$this->load->view('dev_peryear_v', $data);
	}

	/**
	 * Show popup for attach the proof file
	 * 
	 * @param string $key
	 * @return void
	 */
	public function attach_file(string $key) : void
    {
    	$data['key'] = $key;
    	$this->load->view('dev_modal_upload_v', $data);
    }

    /**
     * Submit proof file link
     * 
     * @return void
     */
    public function submit_proof_file(string $key) : void
    {
    	$this->_is_dev_exist($key);

    	extract(PopulateForm());
    	$this->db->insert('bukti_pengabdian', ['url' => $url, '_key' => $key]);
    	if ($this->db->affected_rows()) {
    		$this->session->set_flashdata('success', 'Berkas berhasil dilampirkan!');
    		redirect('laporan-pengabdian','refresh');
    	} else {
    		$this->session->set_flashdata('fail', 'Berkas gagal dilampirkan! Terjadi kesalahan pada sistem, silahkan unggah kembali');
    		redirect('laporan-pengabdian','refresh');
    	}
    }

    /**
     * Verification for key. Is key of devotion exist?
     * 
     * @param string $key
     * @return void
     */
    private function _is_dev_exist($key) : void
    {
    	$is_exist = $this->db->get_where('abdimas_dosen', ['_key' => $key])->num_rows();
    	if ($is_exist == 0) {
    		$this->session->set_flashdata('fail', 'Gagal melampirkan dokumen! Kode pengabdian tidak valid.');
    		redirect('laporan-pengabdian','refresh');
    	}
    	return;
    }

}

/* End of file Report_pengabdian.php */
/* Location: ./application/modules/pengabdian/controllers/Report_pengabdian.php */
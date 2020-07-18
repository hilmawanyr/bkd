<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_jabatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->load->model('struktural/Report_struktural_model','rsm');
	}

	public function index()
	{
		$data['years'] = list_year()->data;
		$data['poss'] = $this->rsm->get_struktural($this->userid, active_year()->kode_tahun);
		$data['pagename'] = 'Laporan Jabatan Struktural';
		$data['page'] = 'report_position_v';
		$this->load->view('template/template', $data);
	}

	/**
	 * Get position data per year
	 * 
	 * @param int $tahunakademik
	 * @return void
	 */
	public function get_pos_peryear(int $tahunakademik) : void
	{
		$data['poss'] = $this->rsm->get_struktural($this->userid, $tahunakademik);
		$this->load->view('position_peryear_v', $data);
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
    	$this->load->view('pos_modal_upload_v', $data);
    }

    /**
     * Submit proof file link
     * 
     * @return void
     */
    public function submit_proof_file(string $key) : void
    {
    	$this->_is_pos_exist($key);

    	extract(PopulateForm());
    	$this->db->insert('bukti_jabatan', ['url' => $url, '_key' => $key]);
    	if ($this->db->affected_rows()) {
    		$this->session->set_flashdata('success', 'Berkas berhasil dilampirkan!');
    		redirect('laporan-jabatan-struktural','refresh');
    	} else {
    		$this->session->set_flashdata('fail', 'Berkas gagal dilampirkan! Terjadi kesalahan pada sistem, silahkan unggah kembali');
    		redirect('laporan-jabatan-struktural','refresh');
    	}
    }

    /**
     * Verification for key. Is key of devotion exist?
     * 
     * @param string $key
     * @return void
     */
    private function _is_pos_exist($key) : void
    {
    	$is_exist = $this->db->get_where('struktural_dosen', ['_key' => $key])->num_rows();
    	if ($is_exist == 0) {
    		$this->session->set_flashdata('fail', 'Gagal melampirkan dokumen! Kode jabatan struktural tidak valid.');
    		redirect('laporan-jabatan-struktural','refresh');
    	}
    	return;
    }

}

/* End of file Report_jabatan.php */
/* Location: ./application/modules/struktural/controllers/Report_jabatan.php */
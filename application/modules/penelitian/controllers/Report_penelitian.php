<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_penelitian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->load->model('penelitian/report_penelitian_model','rrscm');
	}

	public function index()
	{
		$data['years'] = list_year()->data;
		$data['pagename'] = 'Laporan penelitian';
		$data['page'] = 'report_penelitian_v';
		$data['rscs'] = $this->rrscm->daftar_penelitian($this->userid, active_year()->kode_tahun);
		$this->load->view('template/template', $data);
	}

	public function detail(int $tahunakademik) : void
	{
		$data['rscs'] = $this->rrscm->daftar_penelitian($this->userid, $tahunakademik);
		$this->load->view('rsc_table_peryear_v', $data);
	}

	public function attach_file($key, $isEqual)
    {
    	$rsc = $this->rrscm->get_research($key);
    	$data['doc_key'] = $rsc->key;
    	$is_equal = explode('-', $isEqual);
    	$data['is_doc_complete'] = $is_equal[1] == 0 ? 0 : ($is_equal[0] != $is_equal[1] ? 1 : 2);
    	$data['data'] = $this->rrscm->proof_doc($rsc->kegiatan, $rsc->param);
    	$this->load->view('rsc_modal_upload_v', $data);
    }

    public function submit_attachment($doc_key)
    {
    	$this->_is_research_exist($doc_key);
    	$attachment = $this->input->post('attachment');
    	$doc_code = $this->input->post('doctype');
    	for ($i = 0; $i < count($attachment); $i++) {
    		if (!empty($attachment[$i])) {
    			$data[] = [
	    			'kode_dokumen' => $doc_code[$i],
	    			'url' => $attachment[$i],
	    			'key_penelitian' => $doc_key
	     		];	
    		}
    	}
    	$this->db->insert_batch('bukti_penelitian', $data);
    	$this->session->set_flashdata('success', 'Bukti penelitian berhasil dilampirkan!');
    	redirect('laporan-penelitian','refresh');
    }

    private function _is_research_exist($doc_key)
    {
    	$is_exist = $this->db->get_where('penelitian_dosen', ['key' => $doc_key])->num_rows();
    	if ($is_exist == 0) {
    		$this->session->set_flashdata('fail', 'Gagal melampirkan dokumen! Kode penelitian tidak valid.');
    		redirect('penelitian','refresh');
    	}
    	return;
    }

    public function remove_link($doc, $key)
    {
    	$this->db->update('bukti_penelitian', ['deleted_at' => date('Y-m-d H:i:s')], ['kode_dokumen' => $doc, 'key_penelitian' => $key]);
    	$this->session->set_flashdata('success', 'Link dokumen berhasil dihapus!');
    	redirect('penelitian','refresh');
    }

}

/* End of file Report_penelitian.php */
/* Location: ./application/modules/penelitian/controllers/Report_penelitian.php */
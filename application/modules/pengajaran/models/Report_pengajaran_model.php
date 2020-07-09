<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_pengajaran_model extends CI_Model {

	public function get_pengajaran(string $nid, string $year) : array
	{
		$data = $this->db->query("SELECT 
									ptd.*, 
									pt.`komponen`,
									lp.`kode_transaksi` AS tsc_rep,
									dbp.`url` AS tsc_url
								FROM pengajaran_tambahan_dosen ptd 
								JOIN pengajaran_tambahan pt ON ptd.`kode_pengajaran` = pt.`kode_pengajaran`
								LEFT JOIN laporan_pengajaran lp ON ptd.`kode_transaksi` = lp.`kode_transaksi`
								LEFT JOIN dokumen_bukti_pengajaran dbp ON dbp.`kode_transaksi` = lp.`kode_transaksi`
								WHERE ptd.`nid` = '{$nid}' 
								AND ptd.`tahunakademik` = '{$year}'
								AND ptd.`deleted_at` IS NULL")->result();
		return $data;	
	}

	public function is_claimed(string $code) : int
	{
		$claimed = $this->db->query("SELECT * FROM laporan_pengajaran WHERE kode_transaksi = '{$code}'")->num_rows();
		return $claimed;		
	}

	public function has_docs(string $code) : int
	{
		$docs = $this->db->query("SELECT * FROM dokumen_bukti_pengajaran WHERE kode_transaksi = '{$code}'")->num_rows();
		return $docs;		
	}

}

/* End of file Report_pengajaran_model.php */
/* Location: ./application/modules/pengajaran/models/Report_pengajaran_model.php */
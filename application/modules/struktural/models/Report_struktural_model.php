<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_struktural_model extends CI_Model {

	public function get_struktural(string $nid, int $tahunakademik) : array
	{
		$data = $this->db->query("SELECT sd.`_key`, js.`jabatan`, bj.`url` FROM struktural_dosen sd
								JOIN jabatan_struktural js ON js.`kode` = sd.`kode_jabatan`
								LEFT JOIN bukti_jabatan bj ON bj.`_key` = sd.`_key`
								WHERE sd.`nid` = '{$nid}'
								AND sd.`tahunakademik` = '{$tahunakademik}'
								AND sd.`deleted_at` IS NULL")->result();
		return $data;		
	}	

}

/* End of file Report_struktural_model.php */
/* Location: ./application/modules/struktural/models/Report_struktural_model.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devotion_report_model extends CI_Model {

	public function get_devotions(string $nid, int $tahunakademik) : array
	{
		$data = $this->db->query("SELECT 
									ad.`_key`,
									ab.`nama`,
									ap.`program`,
									pr.`nama` AS peran,
									bk.`url`
								FROM abdimas_dosen ad
								JOIN abdimas ab ON ab.`kode` = ad.`type`
								JOIN abdimas_program ap ON ap.`kode_program` = ad.`program`
								LEFT JOIN abdimas_parameter pr ON pr.`kode` = ad.`param`
								LEFT JOIN bukti_pengabdian bk ON ad.`_key` = bk.`_key`
								WHERE ad.`nid` = '{$nid}'
								AND ad.`tahunakademik` = '{$tahunakademik}'
								AND ad.`deleted_at` IS NULL")->result();
		return $data;
	}	

}

/* End of file Devotion_report_model.php */
/* Location: ./application/modules/pengabdian/models/Devotion_report_model.php */
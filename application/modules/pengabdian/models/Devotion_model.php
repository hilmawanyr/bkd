<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devotion_model extends CI_Model {

	public function get_devotion_program($code)
	{
		$devProgram = $this->db->query("SELECT a.kode_program, a.program FROM abdimas_program a
										JOIN abdimas b ON a.kode_abdimas = b.kode
										WHERE a.kode_abdimas = '{$code}'
										ORDER BY a.kode_program ASC")->result();
		return $devProgram;
	}

	function devotion_program($code)
	{
		$program = $this->db->query("SELECT sks, program FROM abdimas_program WHERE kode_program = '{$code}'")->row();
		return $program;
	}

	function devotion_type($code)
	{
		$type = $this->db->query("SELECT nama FROM abdimas WHERE kode = '{$code}'")->row()->nama;
		return $type;
	}

	public function get_dev_param($param=NULL)
	{
		if (!is_null($param)) {
			$param = $this->db->query("SELECT nama FROM abdimas_parameter WHERE kode = '{$param}'")->row()->nama;
			return $param;
		}
		return $param;
	}

	public function get_devotion_param_weight($code)
	{
		$param 	= $this->db->query("SELECT ap.kode, ap.nama FROM abdimas_bobot ab 
									JOIN abdimas_parameter ap ON ab.param = ap.kode
									WHERE ab.kode_program = '{$code}'")->result();
		return $param;
	}

	public function get_devotion_credit($code, $param)
	{
		$credit= "";
		if (!empty($code) && !empty($param)) {
			$credit = $this->db->query("SELECT sks FROM abdimas_bobot WHERE kode_program = '$code' AND param = '$param'")->row()->sks;	
		} elseif (!empty($code) && empty($param)) {
			$credit = $this->db->query("SELECT sks FROM abdimas_bobot WHERE kode_program = '$code'")->row()->sks;
		} elseif ($code == "" && !empty($param)) {
			$credit = "";
		} else {
			$credit = "";
		}
		return $credit;
	}

	public function list_all($userid, $tahunakademik)
	{
		$data 	= $this->db->query("SELECT 
										ad.bobot_sks AS sks, 
										ad.id, 
										ad.nid, 
										ar.nama, 
										ap.program, 
										ab.nama AS abdimas  
									FROM abdimas_dosen ad
									JOIN abdimas_program ap ON ad.program = ap.kode_program
									LEFT JOIN abdimas_parameter ar ON ad.param = ar.kode
									JOIN abdimas ab ON ad.type = ab.kode
									WHERE ad.nid = '{$userid}'
									AND ad.tahunakademik = '{$tahunakademik}'
									AND ad.deleted_at IS NULL")->result();
		return $data;
	}

	public function dev_detail($id)
	{
		$data 	= $this->db->query("SELECT 
										ad.bobot_sks AS sks, 
										ad.tahunakademik,
										ad.id, 
										ad.type,
										ad.nid, 
										ar.nama, 
										ap.program, 
										ab.nama AS abdimas  
									FROM abdimas_dosen ad
									JOIN abdimas_program ap ON ad.program = ap.kode_program
									LEFT JOIN abdimas_parameter ar ON ad.param = ar.kode
									JOIN abdimas ab ON ad.type = ab.kode
									WHERE ad.id = '{$id}'")->row();
		return $data;
	}

}

/* End of file Devotion_model.php */
/* Location: ./application/modules/pengabdian/models/Devotion_model.php */
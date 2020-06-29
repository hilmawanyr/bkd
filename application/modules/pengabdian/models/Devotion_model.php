<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devotion_model extends CI_Model {

	public function get_devotion_program($code)
	{
		$devProgram = $this->db->query("SELECT a.kode_program, a.program, b.param, b.sks FROM abdimas_program a
										JOIN abdimas_bobot b ON a.kode_program = b.kode_program
										WHERE a.kode_abdimas = '{$code}'
										GROUP BY a.kode_program
										ORDER BY a.kode_program ASC")->result();
		return $devProgram;
	}

	function devotion_program($code)
	{
		$program = $this->db->query("SELECT program FROM abdimas_program WHERE kode_program = '{$code}'")->row()->program;
		return $program;
	}

	function devotion_type($code)
	{
		$type = $this->db->query("SELECT nama FROM abdimas WHERE kode = '{$code}'")->row()->nama;
		return $type;
	}

	public function get_devotion_param($code)
	{
		$param = $this->db->query("SELECT * FROM tbl_research_params WHERE group_param = '$code'")->result();
		return $param;
	}

}

/* End of file Devotion_model.php */
/* Location: ./application/modules/pengabdian/models/Devotion_model.php */
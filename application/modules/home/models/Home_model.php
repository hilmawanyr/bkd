<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function data_pengajaran(string $nid, int $tahunakademik) : int
	{
		$data = $this->db
						->get_where('pengajaran_tambahan_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->num_rows();
		return $data;		
	}	

	public function sks_pengajaran(string $nid, int $tahunakademik) : float
	{
		$data = $this->db
						->select('SUM(sks) AS sks')
						->get_where('pengajaran_tambahan_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->row()->sks;
		return ($data === false OR is_null($data)) ? 0 : $data;		
	}	

	public function data_penelitian(string $nid, int $tahunakademik) : int
	{
		$data = $this->db
						->get_where('penelitian_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->num_rows();
		return $data;		
	}	

	public function sks_penelitian(string $nid, int $tahunakademik) : float
	{
		$data = $this->db
						->select('SUM(sks) AS sks')
						->get_where('penelitian_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->row()->sks;
		return ($data === false OR is_null($data)) ? 0 : $data;		
	}	

	public function data_pengabdian(string $nid, int $tahunakademik) : int
	{
		$data = $this->db
						->get_where('abdimas_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->num_rows();
		return $data;		
	}	

	public function sks_pengabdian(string $nid, int $tahunakademik) : float
	{
		$data = $this->db
						->select('SUM(bobot_sks) AS sks')
						->get_where('abdimas_dosen', [
							'tahunakademik' => $tahunakademik, 
							'nid' => $nid,
							'deleted_at IS NULL' => NULL
						])
						->row()->sks;
		return ($data === false OR is_null($data)) ? 0 : $data;		
	}	

	public function position(string $nid, int $tahunakademik) : string
	{
		$data = $this->db->query("SELECT pos.`jabatan` FROM struktural_dosen sd JOIN jabatan_struktural pos
									ON sd.`kode_jabatan` = pos.`kode`
									WHERE sd.`nid` = '{$nid}'
									AND sd.`tahunakademik` = '{$tahunakademik}'
									AND sd.`deleted_at` IS NULL")->row()->jabatan;
		return ($data === false) ? '-' : $data;
	}

}

/* End of file Home_model.php */
/* Location: ./application/modules/home/models/Home_model.php */
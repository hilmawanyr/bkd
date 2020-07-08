<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajaran_model extends CI_Model {

	public function get_pengajaran($nid, $tahunakademik)
	{
		$data = $this->db->query("SELECT 
									ptd.*, 
									pt.`komponen` 
								FROM pengajaran_tambahan_dosen ptd 
								JOIN pengajaran_tambahan pt ON ptd.`kode_pengajaran` = pt.`kode_pengajaran`
								WHERE ptd.`nid` = '{$nid}' 
								AND ptd.`tahunakademik` = '{$tahunakademik}'
								AND ptd.`deleted_at` IS NULL")->result();
		return $data;
	}

	public function get_year_list()
	{
		$http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$years = $this->curl_lib->exec_curl($hostapi.'/api_bkd/year_list', $http_header);
		return json_decode($years);
	}

	public function detail_pengajaran($id)
	{
		$data = $this->db->query("SELECT 
									ptd.*, 
									pt.`komponen` 
								FROM pengajaran_tambahan_dosen ptd 
								JOIN pengajaran_tambahan pt ON ptd.`kode_pengajaran` = pt.`kode_pengajaran`
								WHERE ptd.`id` = '{$id}'")->result();
		return $data;
	}

	public function get_param_penelitian($kode)
	{
		$param = $this->db->get_where('param_pengajaran_tambahan', ['kode' => $kode])->row();
		return $param;
	}

}

/* End of file Pengajaran_model.php */
/* Location: ./application/modules/pengajaran/models/Pengajaran_model.php */
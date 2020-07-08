<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {

	public function get_param($code)
	{
		$param = $this->db->query("SELECT b.* FROM program_penelitian a 
									JOIN parameter_penelitian b ON a.param_code = b.group_param 
									WHERE a.kode_program = '{$code}'")->result();
		return $param;
	}

	public function get_param2($code)
	{
		$param = $this->db->query("SELECT b.* FROM sks_penelitian a 
									JOIN persentase_param_penelitian b ON a.parameter = b.kode_param 
									WHERE a.kode_kegiatan = '{$code}'")->result();
		return $param;
	}

	public function get_sks($activity, $param)
	{
		$where = [ 'kode_kegiatan' => $activity, 'parameter' => $param ];
		$sks = $this->db->get_where('sks_penelitian', $where);
		return $sks;
	}

	public function research_program($code)
	{
		$program = $this->db->select('program')->get_where('program_penelitian', ['kode_program' => $code])->row()->program;
		return $program;
	}

	public function activity_research($code)
	{
		$activity = $this->db->select('kegiatan')->get_where('kegiatan_penelitian', ['kode_kegiatan' => $code])->row()->kegiatan;
		return $activity;
	}

	public function param_research($code = "")
	{
		if (!empty($code)) {
			$param = $this->db->select('parameter')->get_where('persentase_param_penelitian', ['kode_param' => $code])->row()->parameter;
			return $param;
		}
		return '';
	}

	public function duration_detail($code)
	{
		$duration = $this->db->get_where('kategori_parameter_durasi', ['kode' => $code])->row();
		return $duration;
	}

	public function duration_by_activity($act)
	{
		$this->db->select('a.jenis, b.kode_durasi, b.kode_kegiatan, b.persentase');
		$this->db->from('kategori_parameter_durasi a');
		$this->db->join('durasi_penelitian b', 'a.kode = b.kode_durasi');
		$this->db->where('b.kode_kegiatan', $act);
		$this->db->where('b.deleted_at IS NULL', NULL);
		return $this->db->get();
	}

	public function rsc_list($uid, $year)
	{
		$data = $this->db->query("SELECT 
									rsc.id, 
									rsc.key,
									rsc.judul, 
									rsc.sks,
									rsc.tahunakademik, 
									prg.program, 
									act.kegiatan, 
									prm.parameter,
									(SELECT COUNT(*) FROM dokumen_penelitian 
									WHERE kode_kegiatan = rsc.kegiatan 
									AND kode_param = rsc.param) AS requirement,
									(SELECT COUNT(*) FROM bukti_penelitian
									WHERE key_penelitian = rsc.key
									AND deleted_at IS NULL) AS attachment
								FROM penelitian_dosen rsc
								JOIN program_penelitian prg ON rsc.program = prg.kode_program
								JOIN kegiatan_penelitian act ON rsc.kegiatan = act.kode_kegiatan
								JOIN persentase_param_penelitian prm ON rsc.param = prm.kode_param
								WHERE rsc.nid = '{$uid}'
								AND rsc.tahunakademik = '{$year}'
								AND rsc.deleted_at IS NULL")->result();
		return $data;
	}

	public function detail_rsc($id)
	{
		$data = $this->db->query("SELECT 
									rsc.id, 
									rsc.key,
									rsc.judul, 
									rsc.tahunakademik, 
									rsc.anggota,
									rsc.durasi_progres,
									rsc.sks,
									rsc.program as kode_program,
									prg.program, 
									act.kegiatan, 
									prm.parameter
								FROM penelitian_dosen rsc
								JOIN program_penelitian prg ON rsc.program = prg.kode_program
								JOIN kegiatan_penelitian act ON rsc.kegiatan = act.kode_kegiatan
								JOIN persentase_param_penelitian prm ON rsc.param = prm.kode_param
								WHERE rsc.id = '{$id}'")->row();
		return $data;
	}

	public function get_research($id)
	{
		return $this->db->get_where('penelitian_dosen', ['id' => $id])->row();
	}

	public function proof_doc($act, $param)
	{
		$data 	= $this->db->query("SELECT doc.kode, doc.jenis FROM jenis_dokumen_penelitian doc
									JOIN dokumen_penelitian dpl ON doc.kode = dpl.kode_dokumen
									WHERE dpl.kode_kegiatan = '{$act}'
									AND dpl.kode_param = '{$param}'")->result();
		return $data;
	}

	public function is_research_has_doc($key, $doc)
	{
		$is_exist = $this->db->get_where('bukti_penelitian', [
			'kode_dokumen' => $doc, 'key_penelitian' => $key, 'deleted_at IS NULL' => NULL
		]);
		return $is_exist;
	}

}

/* End of file Research_model.php */
/* Location: ./application/modules/penelitian/models/Research_model.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_penelitian_model extends CI_Model {

	public function daftar_penelitian(string $nid, int $tahunakademik) : array
	{
		$data = $this->db->query("SELECT DISTINCT
										pd.`key`,
										pd.`judul`,
										pd.`sks`,
										prg.`program`,
										act.`kegiatan`,
										prm.`parameter`,
										(SELECT COUNT(*) FROM dokumen_penelitian 
										WHERE kode_kegiatan = pd.`kegiatan` 
										AND kode_param = pd.`param`) AS requirement,
										(SELECT COUNT(*) FROM bukti_penelitian
										WHERE key_penelitian = pd.`key`
										AND deleted_at IS NULL) AS attachment
								FROM penelitian_dosen pd
								JOIN program_penelitian prg ON prg.`kode_program` = pd.`program`
								JOIN kegiatan_penelitian act ON act.`kode_kegiatan` = pd.`kegiatan`
								JOIN persentase_param_penelitian prm ON prm.`kode_param` = pd.`param`
								WHERE pd.`nid` = '{$nid}'
								AND pd.`tahunakademik` = '{$tahunakademik}'
								AND pd.`deleted_at` IS NULL
								ORDER BY pd.`tahunakademik` ASC")->result();
		return $data;
	}

	public function get_research($key)
	{
		return $this->db->limit(1)->get_where('penelitian_dosen', ['key' => $key])->row();
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

/* End of file Report_penelitian_model.php */
/* Location: ./application/modules/penelitian/models/Report_penelitian_model.php */
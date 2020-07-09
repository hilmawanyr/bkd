<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajaran extends CI_Controller {

	private $http_header, $hostapi;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->active_year = active_year()->nama_tahun;
		$this->username = $this->session->userdata('bkd_session')['username'];
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$this->hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
		$this->load->library('curl_lib');
		$this->load->model('pengajaran/pengajaran_model','ajar');
	}

	public function index()
	{
		$data['pagename'] = 'Pendidikan dan Pengajaran';
		$data['teaching'] = $this->db->get_where('pengajaran_tambahan', ['is_used' => 1])->result();
		$data['page'] = 'pengajaran_v';
		$this->load->view('template/template', $data);
	}

	public function load_page()
	{
		$payload = json_encode(['userid' => $this->userid]);
		$get_teaching = $this->curl_lib->exec_curl($this->hostapi.'/api_bkd/teaching_list', $this->http_header, 1, $payload);
		$decode_res = json_decode($get_teaching);
		$data['teaching'] = $decode_res->data;
		$this->load->view('review_pengajaran', $data);
	}

	/**
	 * Set sks for additional teaching
	 * @param int $id
	 * @return void
	 */
	public function set_sks_teaching($id)
	{
		$sks = $this->db->select('sks')->get_where('pengajaran_tambahan', ['id' => $id])->row()->sks;
		echo $sks;
	}

	/**
	 * Set param for additonal teaching
	 * @param int $id
	 * @return void
	 */
	public function set_teaching_param($id)
	{
		$params = $this->_set_param($id);
		foreach ($params as $param) {
			$validation = get_teaching_param($param)->tipe_nilai == 'NUMBER' ? "onkeypress=\"return isNumber(event)\"" : '';
			$paramType = '<span class="col-xs-3" style="margin-left:-16px">';
			$paramType .= '<div class="input-group">';
			$paramType .= '<span class="input-group-addon add-on">'.get_teaching_param($param)->nama.'</span>';
			$paramType .= '<input class="paramCode" type="hidden" value="'.$param.'">';
			$paramType .= '<input class="form-control params" type="text" '.$validation.'>';
			$paramType .= '</div></span>';

			$dataParams[] = $paramType;
		}
		echo json_encode($dataParams);
	}

	/**
	 * Prepare param before serve
	 * @param int $id
	 * @return array
	 */
	protected function _set_param($id)
	{
		$params         = $this->db->select('param')->get_where('pengajaran_tambahan', ['id' => $id])->row()->param;
		$replaceBracket = str_replace(['[',']'], '', $params);
		$getUnitParam   = explode(',', $replaceBracket);
		return $getUnitParam;
	}

	public function add_additional_teaching()
	{
		extract(PopulateForm());
		$teaches = count($components);

		for ($i = 0; $i < $teaches; $i++) {
			$firstParam  = $i-$i;
			$secondParam = ($i-$i)+1;

			if (!isset($paramCode[$components[$i]][1])) {
				$paramCode2  = '';
				$paramValue2 = '';
			} else {
				$paramCode2  = $paramCode[ $components[$i] ][ $secondParam ][0];
				$paramValue2 = $paramValue[ $components[$i] ][ $secondParam ][0];
			}

			$teachingData[] = [
				'kode_transaksi'  => $this->_generateRandomString(),
				'kode_pengajaran' => $components[$i],
				'param1_type'     => $paramCode[ $components[$i] ][ $firstParam ][0],
				'param1_value'    => $paramValue[ $components[$i] ][ $firstParam ][0],
				'param2_type'     => $paramCode2,
				'param2_value'    => $paramValue2,
				'sks'             => $sks[$i],
				'tahunakademik'   => active_year()->kode_tahun,
				'nid'             => $this->userid
			];
		}

		$this->db->insert_batch('pengajaran_tambahan_dosen', $teachingData);
		$this->session->set_flashdata('success','Data berhasil disimpan! Anda dapat melihatnya dengan mengklik tombol Daftar Pengajaran Tambahan.');
		redirect('pengajaran','refresh');
	}

	protected function _generateRandomString() : string
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 10; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function daftar_pengajaran()
	{
		$data['current_year'] = active_year()->nama_tahun;
		$data['pagename'] = 'Daftar Pengajaran Tambahan';
		$data['year_list'] = $this->ajar->get_year_list()->data;
		$data['data'] = $this->ajar->get_pengajaran($this->userid, active_year()->kode_tahun);
		$data['page'] = 'detail_pengajaran_v';
		$this->load->view('template/template', $data);
	}

	public function detail($year)
	{
		$data['data'] = $this->ajar->get_pengajaran($this->userid, $year);
		$this->load->view('table_pengajaran_v', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['teachs'] = $this->ajar->detail_pengajaran($id);
		$this->load->view('modal_edit_pengajaran', $data);
	}

	public function update($id)
	{
		$this->_is_id_exist($id, 'Gagal mengubah data! ID komponen tidak ditemukan.');
		extract(PopulateForm());

		$sks   = $this->_count_sks($kodekomponen, $param[0], $sks);
		$data1 = ['sks' => $sks];

		for ($i = 0; $i < count($param); $i++) {
			$data2['param'.($i+1).'_value'] = $param[$i];
		}

		$finaldata = array_merge($data1, $data2);
		$this->db->update('pengajaran_tambahan_dosen', $finaldata, ['id' => $id]);
		$this->session->set_flashdata('success', 'Data berasil diperbarui!');
		redirect(base_url('daftar-pengajaran'),'refresh');
	}

	private function _count_sks($kode, $value, $sks)
	{
		if ($kode == 'COM1' OR $kode == 'COM2') {
			$getsks  = $this->db->get_where('pengajaran_tambahan', ['kode_pengajaran' => $kode])->row()->sks;
			$formula = (($value / 10) * $getsks);
			return floatval($formula);

		} elseif ($kode == 'COM5') {
			$getsks  = $this->db->get_where('pengajaran_tambahan', ['kode_pengajaran' => $kode])->row()->sks;
			$formula = (($value / 4) * $sgetks);
			return floatval($formula);

		} elseif ($kode == 'COM7') {
			$getsks  = $this->db->get_where('pengajaran_tambahan', ['kode_pengajaran' => $kode])->row()->sks;
			$formula = (($value / 30) * $getsks);
			return floatval($formula);

		} else {
			return $sks;
		}
	}

	public function remove($id)
	{
		$this->_is_id_exist($id, 'Gagal menghapus data! Komponen tidak ditemukan.');
		$this->db->update('pengajaran_tambahan_dosen', ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]);
		$this->session->set_flashdata('success', 'Data berasil dihapus!');
		redirect(base_url('daftar-pengajaran'),'refresh');
	}

	private function _is_id_exist($id, $message='')
	{
		$is_exist = $this->db->get_where('pengajaran_tambahan_dosen', ['id' => $id])->num_rows();
		if ($is_exist == 0) {
			$this->session->set_flashdata('fail', $message);
			redirect(base_url('daftar-pengajaran'));
		}
		return;
	}

}

/* End of file Pengajaran.php */
/* Location: ./application/modules/pengajaran/controllers/Pengajaran.php */
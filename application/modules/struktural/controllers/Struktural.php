<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural extends CI_Controller {

	protected $username;
	protected $userid;
	protected $table = 'struktural_dosen';

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->username = $this->session->userdata('bkd_session')['username'];
		$this->userid = $this->session->userdata('bkd_session')['userid'];

	}

	// List all your items
	public function index( $offset = 0 )
	{
		$data['username']  = $this->username;
		$data['pagename']  = 'Dashboard';

		$jabatan = $this->data->findAll('jabatan_struktural');

		$data['jabatan'] = $jabatan->result();
		$data['page'] = 'struktural_v';
		
		$this->load->view('template/template', $data);
	}

	// Add a new item
	public function store()
	{
		$req = explode("-", $_POST['position']);
		$position = $req[0];
		$sks = $req[1];
		$tahunakademik = active_year()->kode_tahun;

		$condition = ['nid' => $this->userid, "tahunakademik" => $tahunakademik];
		$exist = $this->data->find($this->table, $condition)->num_rows(); // check exist data before insert
		
		$data = [
			'_key' => $this->_generateRandomString(),
			'nid' => $this->userid,
			'id_jabatan' => $position,
			'tahunakademik' => $tahunakademik,
			'sks' => $sks,
			'status' => null,
			'created_at' => date('Y-m-d H:i:s'),
		];

		if ($exist) {
			$res = $this->data->update($this->table, $data, $condition);
		}else{
			$res = $this->data->insert($this->table, $data);
		}
		
		if ($res) {
			$this->session->set_flashdata('success', 'Jabatan struktural berhasil disimpan!');
	    	redirect('struktural','refresh');
		}else{
			$this->session->set_flashdata('success', 'Jabatan struktural gagal disimpan!');
	    	redirect('struktural','refresh');
		}
	}

	public function show()
	{
		$response = ['code' => 204, "message" => "Not Found...",];

		$condition = ['nid' => $this->userid, 'tahunakademik' => active_year()->kode_tahun];
		$data = $this->data->find($this->table, $condition);

		if ($data->num_rows() > 0) {
			$data = $data->row();

			$where = ['kode' => $data->kode_jabatan];
			$jabatan = $this->data->find('jabatan_struktural', $where);

			$data->nama_tahunakademik = year_name($data->tahunakademik);

			if ($jabatan->num_rows() > 0 ) {
				$data->jabatan = $jabatan->row()->jabatan;
			}else{
				$data->jabatan = "";
			}

			$response["code"]    = 200;
			$response["message"] = "Success";
			$response["data"]    = $data;
		}
		
		echo json_encode($response);
	}

	//Delete one item
	public function remove( $id = NULL )
	{
		$exist = $this->data->find($this->table, $id)->num_rows();

		if ($exist) {
			$this->data->delete($this->table, ['id' => $id]);
			$this->session->set_flashdata('success', 'Jabatan struktural berhasil dihapus !');
	    	redirect('struktural','refresh');
		}else{
			$this->session->set_flashdata('danger', 'Jabatan struktural gagal dihapus !');
	    	redirect('struktural','refresh');
		}
	}

	/**
     * Generate random string
     * 
     * @return string
     */
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
}

/* End of file Struktural.php */
/* Location: ./application/modules/struktural/controllers/Struktural.php */

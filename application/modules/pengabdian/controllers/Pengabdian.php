<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengabdian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->userid = $this->session->userdata('bkd_session')['userid'];
		$this->load->model('pengabdian/devotion_model','dev');
		$this->load->library('cart');
	}

	public function index()
	{
		$this->session->unset_userdata('devotions');
        $this->session->set_userdata('devotions',[]);

		$data['devotionType'] = $this->db->get('abdimas')->result();
		$data['pagename'] = 'Pengabdian';
		$data['page'] = 'pengabdian_v';
		$this->load->view('template/template', $data);
	}

	public function load_list_page()
	{
		$data['years'] = list_year()->data;
		$data['dev'] = $this->dev->list_all($this->userid, active_year()->kode_tahun);
		$this->load->view('daftar_pengabdian', $data);
	}

	/**
	 * Get devotion program by its devotion
	 * @param string $id
	 * @return void
	 */
	public function get_devotion_program($code)
	{
		$programs = $this->dev->get_devotion_program($code);

		$option = "<option value=\"\" disabled=\"\" selected=\"\"></option>";
		foreach ($programs as $program) {
			$option .= "<option value='".$program->kode_program."'>".$program->program."</option>";
		}

		echo $option;
	}

	/**
	 * Get devotion param
	 * @param string $id
	 * @return void
	 */
	public function get_devotion_param($code)
	{
		$params = $this->dev->get_devotion_param_weight($code);

		if (count($params) == 0) {
			$sks = $this->dev->devotion_program($code)->sks;
			echo $sks;
		} else {
			$option = "<option value=\"\" disabled=\"\" selected=\"\"></option>";
			foreach ($params as $param) {
				$option .= "<option value='".$param->kode."'>".$param->nama."</option>";
			}

			echo $option;	
		}
	}

	/**
	 * Set devotion credit
	 * @param string $id
	 * @return void
	 */
	public function set_devotion_credit($code="",$param="")
	{
		$credit = $this->dev->get_devotion_credit($code,$param);
		echo $credit;
	}

	/**
	 * Load temporary devotion table
	 * 
	 * @return void
	 */
	public function load_devotion_temp_table()
    {
        $data['team'] = $this->cart->contents();   
        $this->load->view('temp_table_devotion',$data); 
    }

    /**
	 * Set temporary devotion data
	 * 
	 * @return void
	 */
	public function temporaryDevotion()
	{
        extract(PopulateForm());

		$ses   = $this->session->userdata('devotions');
		$cp    = count($ses);
		$param = isset($devParam) ? $devParam : NULL ;

        if (!$ses) {
            $data = array(
                    $cp => array(
						'nid'           => $this->userid,
						'type'          => $devotion,
						'program'       => $devProgram, 
						'tahunakademik' => active_year()->kode_tahun, 
						'param'         => $param, 
						'sks'           => $devCredit
                    )
                );
            $this->session->set_userdata('numberof_array',$cp);     

            $arr = $ses + $data;
            $count = $cp+1;
            $this->session->unset_userdata('devotions');
            $this->session->set_userdata('devotions',$arr);
            $this->session->set_userdata('numberof_array',$count);

         } else {
            $i_arr = $this->session->userdata('numberof_array');
            $data = array(
                $i_arr => array(
                    'nid'           => $this->userid,
					'type'          => $devotion,
					'program'       => $devProgram, 
					'tahunakademik' => active_year()->kode_tahun, 
					'param'         => $param, 
					'sks'           => $devCredit
                )
            );     

            $arr = $ses + $data;
            $count = $i_arr+1;
            $this->session->unset_userdata('devotions');
            $this->session->unset_userdata('numberof_array');
            
            $this->session->set_userdata('devotions',$arr);
            $this->session->set_userdata('numberof_array',$count);
         
    	}
	}

	/**
	 * Remove devotion from temporary data
	 * @param int $id
	 * @return void
	 */
	public function delete_temp_devotion($id)
	{
        $arr = $this->session->userdata('devotions');

        unset($arr[$id]);
        
        $this->session->unset_userdata('devotions');
        $this->session->set_userdata('devotions',$arr);
    }

    /**
     * Store devotion
     * 
     * @return void
     */
    public function add_devotion()
    {
    	extract(PopulateForm());

    	$programAmount = count($program);
    	for ($i = 0; $i < $programAmount; $i++) {
    		$devotionList[] = [
				'nid'           => $this->userid,
				'tahunakademik' => $tahunakademik[$i],
				'type'          => $type[$i],
				'program'       => $program[$i],
				'param'         => $param[$i],
				'bobot_sks'     => $sks[$i],
				'created_at'    => date('Y-m-d H:i:s')
    		];
    	}
    	$this->_dev_input_validation($devotionList);
    	$this->db->insert_batch('abdimas_dosen', $devotionList);
    	$this->session->set_flashdata('success', 'Data pengabdian berhasil ditambahkan!');
    	redirect('pengabdian');
    }

    /**
     * Validation for devotion. In a semester, only 3 devotions allowed.
     * 
     * @return void
     */
    protected function _dev_input_validation($dev_manifest)
    {
    	$dev_amount = $this->db->get_where("abdimas_dosen",
            [
        		'nid' => $this->userid, 
        		'tahunakademik' => active_year()->kode_tahun,
                'deleted_at IS NULL' => NULL
            ]
    	)->num_rows();

        $total_dev_with_newdata = count($dev_manifest) + $dev_amount;

    	if ($dev_amount > 2 OR $total_dev_with_newdata > 3) {
    		$this->session->set_flashdata('fail', 'Gagal menyimpan data! Jumlah pengabdian melebihi batas jumlah per semester!');
    		redirect('pengabdian','refresh');
    	}
        
    	return;
    }

    /**
     * Load detail devotion to edit
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
    	$data['dev'] = $this->dev->dev_detail($id);
    	$this->load->view('dev_modal_edit', $data);
    }

    /**
     * Update devotion
     * 
     * @return void
     */
    public function update()
    {
    	extract(PopulateForm());

    	$param = isset($devParamEdit) ? $devParamEdit : NULL;

    	$data = [
			'program'       => $devProgramEdit,
			'param'         => $param,
			'bobot_sks'     => $devCreditEdit,
			'updated_at'    => date('Y-m-d H:i:s')
    	];
    	$this->db->update('abdimas_dosen', $data, ['id' => $id]);
    	$this->session->set_flashdata('success', 'Data pengabdian berhasil diubah!');
    	redirect('pengabdian');
    }

    /**
     * Remove devotion by update deleted_at column
     * @param int $id
     * @return void
     */
    public function remove($id)
    {
    	$this->_is_dev_exist($id);

    	$this->db->update('abdimas_dosen', ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]);
    	$this->session->set_flashdata('success', 'Data pengabdian berhasil dihapus!');
    	redirect('pengabdian');
    }

    /**
     * Check whether data is exist or no by its id
     * @param int $id
     * @return void
     */
    private function _is_dev_exist($id)
    {
    	$is_exist = $this->db->get_where('abdimas_dosen', ['id' => $id])->num_rows();
    	if ($is_exist == 0) {
    		$this->session->set_flashdata('fail', 'Gagal menghapus data! Data pengabdian tidak ditemukan!');
    		redirect('pengabdian','refresh');
    	}
    	return;
    }

    /**
     * Get devotion by its year
     * @param string $year
     * @return void
     */
    public function dev_on_year($year)
    {
    	$data['dev'] = $this->dev->list_all($this->userid, $year);
		$this->load->view('daftar_pengabdian_mod', $data);
    }

}

/* End of file Pengabdian.php */
/* Location: ./application/modules/pengabdian/controllers/Pengabdian.php */
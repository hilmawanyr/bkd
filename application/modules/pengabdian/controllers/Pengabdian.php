<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengabdian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('bkd_session')) {
			redirect('auth','refresh');
		}
		$this->load->model('pengabdian/devotion_model','dev');
		$this->load->library('cart');
	}

	public function index()
	{
		$data['devotionType'] = $this->db->get('abdimas')->result();
		$data['pagename'] = 'Pengabdian';
		$data['page'] = 'pengabdian_v';
		$this->load->view('template/template', $data);
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
			$param = !is_null($program->param) ? $program->param : "NIL";
			$option .= "<option value='".$program->kode_program.'x'.$param.'x'.$program->sks."'>".$program->program."</option>";
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
		$params = $this->dev->get_devotion_param($code);

		$option = "<option value=\"\" disabled=\"\" selected=\"\"></option>";
		foreach ($params as $param) {
			$option .= "<option value='".$param->kode."'>".$param->param."</option>";
		}

		echo $option;
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

        $ses    = $this->session->userdata('devotions');
        $cp     = count($ses);

        if ($cp == 0) {
            $data = array(
                    $cp => array(
						'nid'           => $this->userid,
						'type'          => $devotion,
						'program'       => $devProgram, 
						'tahunakademik' => $tahunakademik, 
						'param'         => $devParam, 
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
					'tahunakademik' => $tahunakademik, 
					'param'         => $devParam, 
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

    	$this->_devotion_validation();

    	$programAmount = count($program);
    	for ($i = 0; $i < $programAmount; $i++) {
    		$devotionList[] = [
				'nid'           => $this->userid,
				'tahunakademik' => $tahunakademik[$i],
				'program'       => $program[$i],
				'param'         => $param[$i],
				'bobot_sks'     => $sks[$i],
				'created_at'    => date('Y-m-d H:i:s')
    		];
    	}
    	$this->db->insert_batch('abdimas_dosen', $devotionList);
    	echo '<script>alert("Data pengabdian berhasil disimpan!");history.go(-1);</script>';
    }

    /**
     * Validation for devotion. In a semester, only 3 devotions allowed.
     * @param string $nid
     * @return void
     */
    protected function _devotion_validation()
    {
    	$isValid = $this->db->get_where("abdimas_dosen",['nid' => $this->userid, 'tahunakademik' => getactyear()]);
    	if ($isValid->num_rows() > 3) {
    		echo '<script>alert("Jumlah pengabdian sudah melebihi batas yang diijinkan!");history.go(-1);</script>';
    		exit();
    	}
    	return;
    }

}

/* End of file Pengabdian.php */
/* Location: ./application/modules/pengabdian/controllers/Pengabdian.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penelitian extends CI_Controller {

	private $hostapi, $http_header, $active_year;

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
		$this->load->library('cart');
		$this->load->model('penelitian/research_model','rsc');
	}

	public function index()
	{
		$this->session->unset_userdata('research');
        $this->session->set_userdata('research',[]);

		$data['programs'] = $this->db->get('program_penelitian')->result();
		$data['pagename'] = 'Penelitian';
		$data['page'] = 'penelitian_v';
		$this->load->view('template/template', $data);	
	}

	public function add()
    {
    	extract(PopulateForm());

    	for ($i = 0; $i < count($judul); $i++) {

    		if (strlen($duration[$i]) > 1) {
    			$dataRsc[] = [
	    			'key' => md5($program[$i].$kegiatan[$i].$param[$i].$this->userid),
	    			'judul' => $judul[$i],
	    			'tahunakademik' => $tahunakademik[$i],
	    			'program' => $program[$i],
	    			'kegiatan' => $kegiatan[$i],
	    			'param' => $param[$i],
	    			'sks' => $sks[$i],
	    			'nid' => $this->userid,
	    			'anggota' => $member[$i],
	    			'durasi_progres' => $duration[$i]
	    		];
    		} else {
    			for ($j = 0; $j < (int)$duration[$i]; $j++) {

    				// credit persentage divider for each semester
    				if ($duration[$i] == 1) {
    					$final_sks = [100];
    				} elseif ($duration[$i] == 2) {
    					$final_sks = [40,60];
    				} else {
    					$final_sks = [30,30,40];
    				}
    				$total_sks = ($sks[$i]*$final_sks[$j])/100;

					$tahunajaran = guess_academic_year($tahunakademik[$i], $j);

    				$dataRsc[] = [
		    			'key' => md5($program[$i].$kegiatan[$i].$param[$i].$this->userid),
		    			'judul' => $judul[$i],
		    			'tahunakademik' => $tahunajaran,
		    			'program' => $program[$i],
		    			'kegiatan' => $kegiatan[$i],
		    			'param' => $param[$i],
		    			'sks' => $total_sks,
		    			'nid' => $this->userid,
		    			'anggota' => $member[$i],
		    			'durasi_progres' => $duration[$i]
		    		];
    			}
    		}
    	}
    	$this->db->insert_batch('penelitian_dosen', $dataRsc);
    	$this->session->set_flashdata('success', 'Penelitian berhasil disimpan!');
    	redirect('penelitian','refresh');
    }

    public function daftar_penelitian()
    {
    	$data['rsc_list'] = $this->rsc->rsc_list($this->userid, active_year()->kode_tahun);
    	$this->load->view('rsc_list_v', $data);
    }

    public function load_detail($id, $isEqual)
    {
    	$is_equal = explode('-', $isEqual);
    	$data['is_doc_complete'] = $is_equal[1] == 0 ? 0 : ($is_equal[0] != $is_equal[1] ? 1 : 2);
    	$data['rsc'] = $this->rsc->detail_rsc($id);
    	$this->load->view('rsc_modal_detail_v', $data);
    }

    public function attach_file($id, $isEqual)
    {
    	$rsc = $this->rsc->get_research($id);
    	$data['doc_key'] = $rsc->key;
    	$is_equal = explode('-', $isEqual);
    	$data['is_doc_complete'] = $is_equal[1] == 0 ? 0 : ($is_equal[0] != $is_equal[1] ? 1 : 2);
    	$data['data'] = $this->rsc->proof_doc($rsc->kegiatan, $rsc->param);
    	$this->load->view('rsc_modal_upload_v', $data);
    }

    public function remove_link($doc, $key)
    {
    	$this->db->update('bukti_penelitian', ['deleted_at' => date('Y-m-d H:i:s')], ['kode_dokumen' => $doc, 'key_penelitian' => $key]);
    	$this->session->set_flashdata('success', 'Link dokumen berhasil dihapus!');
    	redirect('penelitian','refresh');
    }

    public function submit_attachment($doc_key)
    {
    	$this->_is_research_exist($doc_key);
    	$attachment = $this->input->post('attachment');
    	$doc_code = $this->input->post('doctype');
    	for ($i = 0; $i < count($attachment); $i++) {
    		if (!empty($attachment[$i])) {
    			$data[] = [
	    			'kode_dokumen' => $doc_code[$i],
	    			'url' => $attachment[$i],
	    			'key_penelitian' => $doc_key
	     		];	
    		}
    	}
    	$this->db->insert_batch('bukti_penelitian', $data);
    	$this->session->set_flashdata('success', 'Bukti penelitian berhasil dilampirkan!');
    	redirect('penelitian','refresh');
    }

    private function _is_research_exist($doc_key)
    {
    	$is_exist = $this->db->get_where('penelitian_dosen', ['key' => $doc_key])->num_rows();
    	if ($is_exist == 0) {
    		$this->session->set_flashdata('fail', 'Gagal melampirkan dokumen! Kode penelitian tidak valid.');
    		redirect('penelitian','refresh');
    	}
    	return;
    }

    public function remove_research($key)
    {
    	$this->db->update('penelitian_dosen', ['deleted_at' => date('Y-m-d H:i:s')], ['key' => $key]);
    	$this->session->set_flashdata('success', 'Penelitian berhasil dihapus!');
    	redirect('penelitian','refresh');
    }

    public function edit($id)
    {
    	$data['rsc'] = $this->rsc->detail_rsc($id);
    	$this->load->view('rsc_modal_edit_v', $data);
    }

    public function update()
    {
    	extract(PopulateForm());

    	if (strlen($duration) > 1) {
			$dataRsc = [
    			'judul' => $judul,
    			'kegiatan' => $kegiatan,
    			'param' => $param,
    			'sks' => $sks,
    			'nid' => $this->userid,
    			'anggota' => $member,
    			'durasi_progres' => $duration
    		];
    		$this->db->update('penelitian_dosen', $dataRsc, ['key' => $keys]);
		} else {
			for ($j = 0; $j < (int)$duration; $j++) {

				$this->db->delete('penelitian_dosen', ['key' => $keys]);
				// credit persentage divider for each semester
				if ($duration == 1) {
					$final_sks = [100];
				} elseif ($duration == 2) {
					$final_sks = [40,60];
				} else {
					$final_sks = [30,30,40];
				}
				$total_sks = ($sks*$final_sks[$j])/100;

				$tahunajaran = guess_academic_year(active_year()->kode_tahun, $j);

				$dataRsc[] = [
	    			'key' => $keys,
	    			'judul' => $judul,
	    			'tahunakademik' => $tahunajaran,
	    			'program' => $program,
	    			'kegiatan' => $kegiatan,
	    			'param' => $param,
	    			'sks' => $total_sks,
	    			'nid' => $this->userid,
	    			'anggota' => $member,
	    			'durasi_progres' => $duration
	    		];
			}
			$this->db->insert_batch('penelitian_dosen', $dataRsc);
		}
		$this->session->set_flashdata('success', 'Penelitian berhasil diubah!');
    	redirect('penelitian','refresh');
    }

    /**
	 * Get kegiatan program by its program
	 * @param string $id
	 * @return void
	 */
	public function program_activity($id)
	{
		$activities = $this->db->get_where('kegiatan_penelitian', ['kode_program' => $id])->result();

		$option = "<option value=\"\" disabled=\"\" selected=\"\"></option>";
		foreach ($activities as $activity) {
			$option .= "<option value='".$activity->kode_kegiatan."'>".$activity->kegiatan."</option>";
		}

		echo $option;
	}

	/**
	 * Get param for each program
	 * @param string $code
	 * @return void
	 */
	public function program_params($code)
	{
		$params = $this->rsc->get_param2($code);

		// set param type
		foreach ($params as $param) {
			$parameter = $param->kategori == 'PROGRESS' ? 'Progres' : 'Peran';
		}

		$options = "<option value=\"\" disabled=\"\" selected=\"\"></option>";
		foreach ($params as $param) {
			$options .= "<option value='{$param->kode_param}'>{$param->parameter}</option>";
		}

		echo json_encode(['options' => $options, 'param' => $parameter]);
	}

	/**
	 * Set SKS by program, activity, and param
	 * @param string [$program,$activity,$param]
	 * @return void
	 */
	public function set_sks($activity='',$param='')
	{
		if ($activity != '' && $param != '') {
			$sks = $this->rsc->get_sks($activity, $param);
			echo $sks->num_rows() > 0 ? $sks->row()->sks : '';
		}
		echo '';
	}

	/**
	 * Set duration category for each activity program
	 * @param string $act
	 * @return void HTML
	 */
	public function duration_category($act)
	{
		$duration_cat = $this->rsc->duration_by_activity($act);

		if ($duration_cat->num_rows() > 1) {

			$inputColumn = '<div class="form-group">';
			$inputColumn .= '<label class="col-sm-2 control-label" id="param-type">Level Proses</label>';
			$inputColumn .= '<div class="col-md-10">';
			$inputColumn .= '<select class="form-control" name="duration" id="duration" required="">';
			$inputColumn .= "<option value=\"\" disabled=\"\" selected=\"\"></option>";
			foreach ($duration_cat->result() as $duration) {
				$inputColumn .= "<option value='{$duration->kode_durasi}'>{$duration->jenis}</option>";
			}
			$inputColumn .= '</select>';
			$inputColumn .= '</div>';
			
		} else {
			$inputColumn = '<div class="form-group" id="member-column">
						        <label class="col-sm-2 control-label" for="member">Lama Penelitian</label>
						        <div class="col-md-10">
									<div class="input-group">
										<input 
											onkeypress="return isNumber(event)"
											maxlength="1" 
											required="" 
											type="text" 
											name="duration"  
											id="duration" 
											class="form-control">
										<span class="input-group-addon add-on">Semester</span>
									</div>
								</div>
							</div>';
		}
		echo $inputColumn;
	}

	/**
	 * Load temporary table
	 * 
	 * @return void
	 */
	public function loadTable()
    {
        $data['team'] = $this->cart->contents();   
        $this->load->view('temp_table_research',$data); 
    }

    /**
	 * Set temporary research data
	 * 
	 * @return void
	 */
	public function temporaryResearch()
	{
        extract(PopulateForm());

        $ses    = $this->session->userdata('research');
        $cp     = count($ses);

        if ($cp == 0) {
            $data = array(
                    $cp => array(
						'nid'           => $this->userid,
						'tahunakademik' => $tahunakademik, 
						'judul'         => $rscTitle,
						'program'       => $rscProgram, 
						'kegiatan'      => $rscActivity, 
						'param'         => $rscParam, 
						'sks'           => $rscCredit,
						'member'		=> $member,
						'duration'		=> $duration
                    )
                );
            $this->session->set_userdata('jml_array',$cp);     

            $arr = $ses + $data;
            $count = $cp+1;
            $this->session->unset_userdata('research');
            $this->session->set_userdata('research',$arr);
            $this->session->set_userdata('jml_array',$count);

         } else {
            $i_arr = $this->session->userdata('jml_array');
            $data = array(
                $i_arr => array(
                    'nid'           => $this->userid,
					'tahunakademik' => $tahunakademik, 
					'judul'         => $rscTitle,
					'program'       => $rscProgram, 
					'kegiatan'      => $rscActivity, 
					'param'         => $rscParam, 
					'sks'           => $rscCredit,
					'member'		=> $member,
					'duration'		=> $duration
                )
            );     

            $arr = $ses + $data;
            $count = $i_arr+1;
            $this->session->unset_userdata('research');
            $this->session->unset_userdata('jml_array');
            
            $this->session->set_userdata('research',$arr);
            $this->session->set_userdata('jml_array',$count);
         
    	}
	}

	/**
	 * Remove research from temporary data
	 * @param int $id
	 * @return void
	 */
	public function deleteList($id)
	{
        $arr = $this->session->userdata('research');

        unset($arr[$id]);
        
        $this->session->unset_userdata('research');
        $this->session->set_userdata('research',$arr);
    }

}

/* End of file Penelitian.php */
/* Location: ./application/modules/penelitian/controllers/Penelitian.php */
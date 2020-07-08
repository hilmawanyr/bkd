<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller{

  private $http_header, $hostapi;

  public function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('bkd_session')) {
      redirect('auth','refresh');
    }
    $this->http_header = ['x-bkd-key: '.APP_KEY, 'Content-Type: application/json'];
		$this->hostapi = ENVIRONMENT == 'development' ? DEV_HOST_ENDPOINT : PRO_HOST_ENDPOINT;
    $this->userid = $this->session->userdata('bkd_session')['userid'];
  }

  function index()
  {
    $this->session->unset_userdata('tahunakademik');
    $data['pagename'] = 'Print Formulir';
    $data['page'] = 'pre_print_form_v';
    $data['years'] = list_year()->data;
    $this->load->view('template/template', $data);
  }

  public function set_opt()
  {
    $tahunakademik = $this->input->post('tahunakademik');
    $this->session->set_userdata('tahunakademik', $tahunakademik);
    redirect('print-form');
  }

  public function print_out_form()
  {
    $tahunakademik = $this->session->userdata('tahunakademik');
    $this->load->library('Cfpdf');

     $courses = $this->curl_lib->exec_curl(
      $this->hostapi.'/api_bkd/teaching_list',
      $this->http_header,
      1,
      json_encode(['userid' => $this->userid])
    );
    $data['courses'] = json_decode($courses)->data;

    $lecturer = $this->curl_lib->exec_curl(
      $this->hostapi.'/api_bkd/lecturer_data',
      $this->http_header,
      1,
      json_encode(['userid' => $this->userid])
    );
    $data['data'] = json_decode($lecturer)->data;

    $this->load->model('pengajaran/pengajaran_model', 'teach');
    $data['additional'] = $this->teach->get_pengajaran($this->userid, $tahunakademik);

    $this->load->model('penelitian/research_model', 'rsc');
    $data['research'] = $this->rsc->rsc_list($this->userid, $tahunakademik);

    $this->load->model('pengabdian/devotion_model', 'dev');
    $data['devotion'] = $this->dev->list_all($this->userid, $tahunakademik);

    $condition = ['nid' => $this->userid, 'tahunakademik' => $tahunakademik];
		$data['others'] = $this->db->query("SELECT js.jabatan, sd.sks FROM struktural_dosen sd 
                                        JOIN jabatan_struktural js ON sd.kode_jabatan = js.kode
                                        WHERE sd.nid = '{$this->userid}'
                                        AND sd.tahunakademik = '{$tahunakademik}'")->result();

    $this->load->view('bkd_printout', $data);
  }

}

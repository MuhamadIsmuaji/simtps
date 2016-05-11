<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loa extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$distinct = $this->M_setting->getTahunAjaran()->result_array();
        $minThnAjaran = $distinct[0]['thn_ajaran'];
        $maxThnAjaran = $distinct[count($distinct)-1] ['thn_ajaran'];
        
        $setting = $this->M_setting->getSetting()->row();

		$data = [
            'content'       		=> 'admin/data/loa/loa_index',
            'pagetitle'     		=> 'Surat Tugas',
            'navbartitle'   		=> 'Surat Tugas',
            'minThnAjaran'			=> $minThnAjaran,
            'maxThnAjaran'			=> $maxThnAjaran,
  			'current_thn_ajaran'	=> $setting->thn_ajaran,
  			'current_smt'			=> $setting->smt
        ];

        $this->load->view('template',$data);		
	}

	public function dopingList($thn_ajaran = NULL, $smt = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/data/loa','refresh');
		}

        $thn_ajaran = $this->input->post('thn_ajaran');
        $smt = $this->input->post('smt');
		$list = $this->M_kelompok->getPembimbing($thn_ajaran, $smt)->result_array();
		$many = $this->M_kelompok->getPembimbing($thn_ajaran, $smt)->num_rows();

    	echo json_encode(['many' => $many, 'list' => $list]);

	}

	public function loaPrint(){
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('admin/data/loa','refresh');
        }

        $doping = array();

        for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $npp = $this->input->get('npp'.$i);
            $dataDoping = $this->M_dosen->getDosenByNpp($npp)->row();
            $doping[] = $dataDoping->nama; 
        }
		// load dompdf
        $this->load->helper('dompdf');
        //load content html
        $data['dosen'] = $doping;
        $html = $this->load->view('admin/data/loa/loa_print',$data , true);
        // create pdf using dompdf
        $filename = 'Message';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);

        //echo json_encode($this->input->get('jml'));
	}

}

/* End of file Loa.php */
/* Location: ./application/controllers/admin/data/Loa.php */
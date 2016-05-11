<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

        $setting = $this->M_setting->getSetting()->row();
        $distinct = $this->M_setting->getTahunAjaran()->result_array();
        $minThnAjaran = $distinct[0]['thn_ajaran'];
        $maxThnAjaran = $distinct[count($distinct)-1] ['thn_ajaran'];

		$data = [
            'content'       		=> 'admin/data/point/point_lists',
            'pagetitle'     		=> 'Daftar Nilai',
            'navbartitle'   		=> 'Daftar Nilai',
            'current_thn_ajaran'	=> $setting->thn_ajaran,
            'current_smt'			=> $setting->smt,
            'minThnAjaran'			=> $minThnAjaran,
            'maxThnAjaran'			=> $maxThnAjaran
        ];

        $this->load->view('template',$data);		

	}

	public function pointListAdmin($thn_ajaran = NULL, $smt = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
            redirect('admin/data/point','refresh');
        }

        $list = $this->M_anggota->participantListsAdmin($thn_ajaran, $smt);
        $no = $this->input->post('start');
        $data = array();

        foreach ($list as $participant) {

            $no++;
            $row = array();

            $row[] = $participant->nbi;
            $row[] = $participant->nama;
            $row[] = $participant->nilai_huruf;
            $data[] = $row;
        }
        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_anggota->countAll(),
            "recordsFiltered"   => $this->M_anggota->countFiltered($thn_ajaran, $smt),
            "data"              => $data,
        );

        echo json_encode($output);
	} 

	public function printPointList($thn_ajaran = NULL, $smt = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL) {
            redirect('admin/data/point','refresh');
        }

        $pointList = $this->M_anggota->getAnggotaPeriode($thn_ajaran, $smt)->result();

        // load dompdf
        $this->load->helper('dompdf');
        //load content html
        $data['pointList'] = $pointList;
        $html = $this->load->view('admin/data/point/point_print',$data,true);
        // create pdf using dompdf
        $filename = 'Message';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);

	}

}

/* End of file Point.php */
/* Location: ./application/controllers/admin/data/Point.php */
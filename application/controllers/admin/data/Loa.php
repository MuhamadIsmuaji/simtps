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
            $dosen = array();
            
            $npp = $this->input->get('npp'.$i);
            $dataDoping = $this->M_dosen->getDosenByNpp($npp)->row();
            $dosen[] = $dataDoping->nama;
            $dosen[] = $dataDoping->npp;

            $doping[] = $dosen;   
        }
		// load dompdf
        $this->load->helper('dompdf');
        //load content html
        $setting = $this->M_setting->getSetting()->row();
        $next = $setting->thn_ajaran+1;
        $smt = $setting->smt == 1 ? 'Gasal' : 'Genap'; 
        $when = $this->generateIndoTime($setting->tgl_surattgs);
        $pengikut = $this->input->get('jml');

        $data = [
            'dosen'         => $doping,
            'settingData'   => $setting,
            'when'          => $when,
            'pengikut'      => $pengikut
        ];

        $html = $this->load->view('admin/data/loa/loa_print',$data , true);
        // create pdf using dompdf
        $filename = 'Surat Tugas - Pemimbing Praktikum Tugas Perancangan Sistem TA '.$setting->thn_ajaran.' - '.$next.' Semester '.$smt;
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);

        //echo json_encode($this->input->get('jml'));
	}

    // Untuk generate waktu indonesia waktu cetak surat tugas
    private function generateIndoTime($date) {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
     
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);
     
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;     
        return($result);
    }

}

/* End of file Loa.php */
/* Location: ./application/controllers/admin/data/Loa.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function index() {
		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		$dosen = $this->session->userdata('npp');

		$jadwal = $this->M_jadwal->getScheduleDosen($thn_ajaran,$smt,$dosen)->result();
		$reviewData = $this->M_jadwal->getScheduleDosen($thn_ajaran,$smt,$dosen)->result();

		$dataMhs = [];
		foreach ($jadwal as $value) {
			$mhs = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$value->kode_kel)->result();

			foreach ($mhs as $datMhs) {
				$mhs_n = [];
				$review_as = '';
				$point = 0;

				if ( $value->moderator == $this->session->userdata('npp') ) {
		    		$review_as = 'Moderator';
		    		$point = 1;
		    		$kom_a = $datMhs->nilai_11;
		    		$kom_b = $datMhs->nilai_12;
		    		$kom_c = $datMhs->nilai_13;
		    		$kom_d = $datMhs->nilai_14;

				} else if ( $value->penguji1 == $this->session->userdata('npp') ) {
		    		$review_as = 'Penguji 1';
		    		$point = 2;
		    		$kom_a = $datMhs->nilai_21;
		    		$kom_b = $datMhs->nilai_22;
		    		$kom_c = $datMhs->nilai_23;
		    		$kom_d = $datMhs->nilai_24;
		    	} else {
		    		$review_as = 'Penguji 2';
		    		$point = 3;
		    		$kom_a = $datMhs->nilai_31;
		    		$kom_b = $datMhs->nilai_32;
		    		$kom_c = $datMhs->nilai_33;
		    		$kom_d = $datMhs->nilai_34;
		    	}
				
				$mhs_n = [
					'thn_ajaran'	=> $datMhs->thn_ajaran,
					'smt'			=> $datMhs->smt, 
					'nbi'			=> $datMhs->nbi,
					'nama'			=> $datMhs->nama,
					'kode_kel'		=> $datMhs->kode_kel,
					'review_as'		=> $review_as,
					'point'			=> $point,
					'kom_a'			=> $kom_a,
					'kom_b'			=> $kom_b, 
					'kom_c'			=> $kom_c, 
					'kom_d'			=> $kom_d 
				];

				$dataMhs [] = $mhs_n;
			}
		}

		$data = [
			'settingData'		=> $setting,
			'reviewData'		=> $reviewData,
			'dataMhs'			=> $dataMhs,
			'content' 			=> 'lecturer/data/review/review_index',
			'pagetitle' 		=> 'Review Sidang',
			'navbartitle' 		=> 'Review Sidang'
		];

		$this->load->view('template',$data);		
	}	

	public function action() {
		$fields = ['nama','nilai_11','nilai_12','nilai_13'];

		foreach ($fields as $field) {

			foreach ($_POST[$field] as $key => $value) {
				
				$datanya[$key][$field] = $value;
			}

		}

		$data['datanya'] = $datanya[0]['nama'];

		$this->load->view('hasil_review',$data);		

	}

}

/* End of file Review.php */
/* Location: ./application/controllers/lecturer/data/Review.php */
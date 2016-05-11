<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function index() {
		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		$dosen = $this->session->userdata('npp');
		$groupModerator = array();
		$groupPenguji1 = array();
		$groupPenguji2 = array();

		$reviewModerator = $this->M_jadwal->reviewSchedule($setting->thn_ajaran, $setting->smt, $dosen, 'moderator')->result();

		foreach ($reviewModerator as $value) {
			$groupModerator[] = $this->M_anggota->getAnggotaByKodeKelJoinMhsSort($thn_ajaran, $smt, $value->kode_kel)->result_object(); 
		}

		$reviewPenguji1 = $this->M_jadwal->reviewSchedule($setting->thn_ajaran, $setting->smt, $dosen, 'penguji1')->result();

		foreach ($reviewPenguji1 as $value) {
			$groupPenguji1[] = $this->M_anggota->getAnggotaByKodeKelJoinMhsSort($thn_ajaran, $smt, $value->kode_kel)->result_object(); 
		}

		$reviewPenguji2 = $this->M_jadwal->reviewSchedule($setting->thn_ajaran, $setting->smt, $dosen, 'penguji2')->result();

		foreach ($reviewPenguji2 as $value) {
			$groupPenguji2[] = $this->M_anggota->getAnggotaByKodeKelJoinMhsSort($thn_ajaran, $smt, $value->kode_kel)->result_object(); 
		}

		$data = [
			'groupModerator'	=> $groupModerator,
			'groupPenguji1'		=> $groupPenguji1,
			'groupPenguji2'		=> $groupPenguji2,
			'settingData'		=> $setting,
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	function construct() {
		parent::__construct();
	}

	public function index() {
		redirect('public/home','refresh');
	}

	public function loginProcess() {
		if( empty($_POST) ) {
            redirect('public/home');
        }

		if( !empty($_POST) ) {
			$username = $this->input->post('username');
			//$password = md5($this->input->post('password'));
			$password = $this->input->post('password');


			$isParticipant = substr($username,0,2);


			if ( $isParticipant == '14' || $isParticipant == '46') {
				$data = $this->loginParticipant($username,$password);
			} else {
				$data = $this->loginLecturer($username,$password);
			}
			echo json_encode($data);
		}
		//echo json_encode($checkLecturer);
	}

	private function loginParticipant($nbi,$pwd) {
		$checkParticipant = $this->M_mhs->getMhsLogin($nbi,$pwd)->num_rows();
		$accountCheck = 0;
		$isParticipantTps = 0;

		if ( $checkParticipant ) {
			$participantData = $this->M_mhs->getMhsLogin($nbi,$pwd)->row();

			if ( $participantData->akses == 0 ) { // peserta tidak aktif
				$accountCheck = 1;
			} else if ( $participantData->akses == 9 ) { // peserta belum konfirmasi email
				$accountCheck = 4;

				$tmpParticipantTps = [
					'nbi'				=> $participantData->nbi,
					'nama'				=> $participantData->nama,
					'tmpParticipantTps'	=> 1
				];

				$this->session->set_userdata($tmpParticipantTps);

			} else { // peserta yang sudah aktif
				$accountCheck = 5;

				$sessionParticipant = [
					'nbi'				=> $participantData->nbi,
					'nama'				=> $participantData->nama,
					'isParticipantTps'	=> 1
				];

				$this->session->set_userdata($sessionParticipant);
			}

			return $accountCheck;

		} else {
			return 0;
		}

	}

	private function loginLecturer($npp, $pwd) {
		$checkLecturer = $this->M_dosen->getDosenLogin($npp,$pwd)->num_rows();
		$isAdminTps = 0;
		$isLecturerTps = 0;
		$accountCheck = 0;

		if ( $checkLecturer ) { // Lecturer found
			$lecturerData = $this->M_dosen->getDosenLogin($npp,$pwd)->row();

			if ( $lecturerData->akses == 0 ) { // Lecturer not active
				$accountCheck = 1;
			} else { // Lecturer active

				if ($lecturerData->akses == 2) { //Lecturer As Admin too
					$isAdminTps = 1;
					$isLecturerTps = 1;
					$accountCheck = 3;
				} else { // Lecturer but not Admin
					$isAdminTps = 0;
					$isLecturerTps = 1;
					$accountCheck = 2;
				}

				$sessionLecturer = [
					'npp'					=> $lecturerData->npp,
					'nama'					=> $lecturerData->nama,
					'isAdminTps'			=> $isAdminTps,
					'isLecturerTps' 		=> $isLecturerTps
				];

			

				$this->session->set_userdata($sessionLecturer);
				$this->session->set_userdata($sessionLecturer);
			}

			return $accountCheck;

		} else { // Lecturer not found
			return 0;
		}
	}

	public function logout() {
		
		if ( $this->session->userdata('isAdminTps') ) {

			$this->session->unset_userdata('isAdminTps');
			$this->session->unset_userdata('isLecturerTps');
			
		} else if ( $this->session->userdata('isLecturerTps') ) {

			$this->session->unset_userdata('isLecturerTps');

		} else if ( $this->session->userdata('isParticipantTps') ) {

			$this->session->unset_userdata('isParticipantTps');

		} else {
			// nothing
			redirect('public/home','refresh');
		}

		redirect('public/home','refresh');
	}
}
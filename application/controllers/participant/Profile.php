<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		if ( !empty($_POST) ) {
			$participantData = $this->M_mhs->getMhsByNbi($this->session->userdata('nbi'))->row();
			$new_nbi = $this->input->post('nbi');
			$old_nbi = $this->input->post('old_nbi');
			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			$pwd_lama = $this->input->post('pwd_lama');
			$pwd_baru = $this->input->post('pwd_baru');
			$repwd_baru = $this->input->post('repwd_baru');


			if ( $pwd_lama != $participantData->pwd ) { // jika password lama tidak sesuai
				$errorMessage = 'Update profil gagal... Password lama tidak sesuai';
				$divClass = 'alert alert-danger alert-dismissible';
			} else { // jika password lama sesuai

				if ( $new_nbi == $old_nbi ) { // jika user tidak ganti nbinya

					$updatePar = $this->updateProcess($new_nbi, $new_nbi, $nama, $repwd_baru, $email);

					if ( $updatePar ) {
						$this->resetSession($new_nbi, $nama);
						$errorMessage = 'Update profil berhasil..';
						$divClass = 'alert alert-success alert-dismissible';
					} else {
						$errorMessage = 'Update profil gagal.. Kesalahan proses data';
						$divClass = 'alert alert-danger alert-dismissible';
					}

				} else { // jika user ganti nbi, maka dicek dulu apa ada nbi yg sama
					$isParticipant = $this->M_mhs->getMhsByNbi($new_nbi)->row();

					if ( $isParticipant ) { // jika nbi baru yg dimasukkan sudah ada
						$errorMessage = 'Update profil gagal... NBI sama dengan peserta lain';
						$divClass = 'alert alert-danger alert-dismissible';
					} else { // jika nbi baru yg dimasukkan belum ada
						$updatePar = $this->updateProcess($old_nbi, $new_nbi, $nama, $repwd_baru, $email);

						if ( $updatePar ) {
							$this->resetSession($new_nbi, $nama);
							$errorMessage = 'Update profil berhasil..';
							$divClass = 'alert alert-success alert-dismissible';
						} else {
							$errorMessage = 'Update profil gagal.. Kesalahan proses data';
							$divClass = 'alert alert-danger alert-dismissible';
						}
					}
				}

			}

		} else {
			$errorMessage = null;
			$divClass = null;
		}

		$participant = $this->M_mhs->getMhsByNbi($this->session->userdata('nbi'))->row();

		$data = [
			'content' 		=> 'participant/setting/profile',
			'pesan'			=> 'Halaman Setting Profile Lecturer',
			'pagetitle' 	=> 'Pengaturan Profil',
			'participant'	=> $participant,
			'errorMessage'	=> $errorMessage,
			'divClass'		=> $divClass,
			'navbartitle' 	=> 'Pengaturan Profil'
		];

		$this->load->view('template', $data);
	}

	private function resetSession($nbi = NULL, $nama = NULL) {
		$participantSession = [
			'nbi'	=> $nbi,
			'nama'	=> $nama
		];

		$this->session->set_userdata($participantSession);
	}

	private function updateProcess($old_nbi = NULL, $new_nbi = NULL, $nama = NULL, $pwd = NULL, $email = NULL) {
		$updateData = [
			'nbi'	=> $new_nbi,
			'nama'	=> $nama,
			'pwd'	=> $pwd,
			'email' => $email
		];

		$process = $this->M_mhs->update($old_nbi, $updateData);

		return $process;
	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/participant/Profile.php */
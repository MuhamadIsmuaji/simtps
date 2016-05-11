<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		} else {
			redirect('lecturer/setting/profile','refresh');
		}	
	}

	public function profile() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( !empty($_POST) ) { // If submit button clicked
			$lecturerData	= $this->M_dosen->getDosenBynpp($this->session->userdata('npp'))->row();
			$old_npp		= $this->session->userdata('npp');
			$new_npp		= $this->input->post('npp');
			$old_pwd		= $this->input->post('pwd_lama');
			$new_repwd		= $this->input->post('repwd_baru');
			$nama			= $this->input->post('nama');

			if ( $old_pwd != $lecturerData->pwd ) { //Jika password lama tidak sesuai
				$errorMessage = 'Update profil gagal... Password lama tidak sesuai';
				$divClass = 'alert alert-danger alert-dismissible';
			} else { //Jika password lama sesuai

				if ( $new_npp == null ) { // Untuk dosen yang tidak bisa ganti npp
					
					$nama = $this->session->userdata('nama');
					$update = $this->updateProcess($old_npp, $old_npp, $nama, $new_repwd);

					if ( $update ) {
						$errorMessage = 'Update profil berhasil..';
						$divClass = 'alert alert-success alert-dismissible';
					} else {
						$errorMessage = 'Update profil gagal.. Kesalahan proses data';
						$divClass = 'alert alert-danger alert-dismissible';
					}
				
				} else if ( $new_npp != null && $new_npp == $old_npp ) { // untuk dosen selaku admin yang bisa ganti npp tapi npp tidak diganti
					$this->resetSession($new_npp, $nama);
					$update = $this->updateProcess($old_npp, $new_npp, $nama, $new_repwd);

					if ( $update ) {
						$errorMessage = 'Update profil berhasil..';
						$divClass = 'alert alert-success alert-dismissible';
					} else {
						$errorMessage = 'Update profil gagal.. Kesalahan proses data';
						$divClass = 'alert alert-danger alert-dismissible';
					}

				} else { // untuk dosen selaku admin npp diganti
					$isAnyLecturer = $this->M_dosen->getDosenBynpp($new_npp)->row();

					if ( $isAnyLecturer ) { // Jika npp yang dimasukkan sudah ada

						$errorMessage = 'Update profil gagal... npp yang anda masukkan sudah ada';
						$divClass = 'alert alert-danger alert-dismissible';
					
					} else {// Jika npp yang dimasukkan belum ada

						$this->resetSession($new_npp, $nama);
						$update = $this->updateProcess($old_npp, $new_npp, $nama, $new_repwd);

						if ( $update ) {
							$errorMessage = 'Update profil berhasil..';
							$divClass = 'alert alert-success alert-dismissible';
						} else {
							$errorMessage = 'Update profil gagal.. Kesalahan proses data';
							$divClass = 'alert alert-danger alert-dismissible';
						}
						
					}
				}
			}	
			
		} else { // If submit button clicked yet
			$errorMessage = null;
			$divClass = null;
		}

		$lecturerData = $this->M_dosen->getDosenBynpp($this->session->userdata('npp'))->row();

		$data = [
			'content' 		=> 'lecturer/setting/profile',
			'pesan'			=> 'Halaman Setting Profile Lecturer',
			'pagetitle' 	=> 'Pengaturan Profil',
			'lecturerData'	=> $lecturerData,
			'errorMessage'	=> $errorMessage,
			'divClass'		=> $divClass,
			'navbartitle' 	=> 'Pengaturan Profil'
		];

		$this->load->view('template', $data);
	}

	private function resetSession($npp = null, $nama = null) {
		$sessionData = [
			'npp'  => $npp,
			'nama'	=> $nama
		];
		
		$this->session->set_userdata($sessionData);
	}

	private function updateProcess($oldnpp = null, $newnpp = null, $nama = null, $pwd = null) {
		$lecturer = [
			'npp'	=> $newnpp,
			'nama'	=> $nama,
			'pwd'	=> $pwd
		];	

		$process = $this->M_dosen->update($oldnpp,$lecturer);

		return $process;
	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/lecturer/Setting.php */
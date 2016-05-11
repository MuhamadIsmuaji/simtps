	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guidance extends CI_Controller {

	function construct() {
		parent::__construct();
	}
	
	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		$nbi = $this->session->userdata('nbi');
		
   		$participant = $this->M_anggota->getAnggotaByPeriode($thn_ajaran, $smt, $nbi)->row();

		if ( $participant->kode_kel != '0' && $participant->konfirmasi == 2 ) { 
			// jika sudah memiliki kelompok
			$kode_kel = $participant->kode_kel;

			$dataBimb = $this->M_bimbingan->getGuidanceByKodeKel($thn_ajaran, $smt, $kode_kel)->result();

			$data = [
				'content' 		=> 'participant/guidance/guidance_list',
				'participant'	=> $participant,
				'dataBimb'		=> $dataBimb,
				'pesan'			=> 'Halaman Data Bimbingan',
				'pagetitle' 	=> 'Data Bimbingan',
				'navbartitle' 	=> 'Data Bimbingan'
			];

			$this->load->view('template',$data);
		} else { // jika belum memiliki kelompok
			$message = 'Anda belum memiliki kelompok.. Silahkan memilih kelompok terlebih dahulu...';
			echo "<script>alert('". $message ."')</script>";
            redirect('participant/dashboard','refresh');
		}
	}

	public function create() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		$nbi = $this->session->userdata('nbi');

   		$participant = $this->M_anggota->getAnggotaByPeriode($thn_ajaran, $smt, $nbi)->row();

   		if ( $participant->kode_kel != '0' && $participant->konfirmasi == 2 ) { 
			// jika sudah memiliki kelompok
			 
			if ( !empty($_POST) ) { // ketika tombol submit ditekan

				$tgl_bimbingan = new DateTime($this->input->post('tgl'));
				$nou = $this->input->post('nou');
				$uraian = $this->input->post('uraian');

				$kode_kel = $participant->kode_kel;

				$filterData = [
					'thn_ajaran'	=> $thn_ajaran,
					'smt'			=> $smt,
					'kode_kel'		=> $kode_kel,
					'nou'			=> $nou
				];

				$cekBimb = $this->M_bimbingan->getGuidance($filterData)->num_rows();

				if ( $cekBimb == 0 ) { // jika bimbingan ke-x belum ada

					$inputData = [
						'thn_ajaran'	=> $thn_ajaran,
						'smt'			=> $smt,
						'kode_kel'		=> $kode_kel,
						'nou'			=> $nou,
						'tgl'			=> $tgl_bimbingan->format('Y-m-d'),
						'uraian'		=> $uraian,
						'validasi'		=> 0
					];

					$processInput = $this->M_bimbingan->insert($inputData);

					if ( $processInput ) { // proses input berhasil
						$errorMessage = '<strong>Input data bimbingan ke-'. $nou . ' berhasil... </strong>';
						$divClass = 'alert fresh-color alert-success alert-dismissible';	
					} else { // proses input gagal
						$errorMessage = '<strong>Input gagal. Silahkan ulangi lagi... </strong>';
						$divClass = 'alert fresh-color alert-danger alert-dismissible';	
					}

						
				} else { // jika bimbingan ke-x sudah ada
					$errorMessage = '<strong>Input gagal. Data bimbingan ke-'. $nou . ' sudah ada... </strong>';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';	
				}

			} else { // Ketika tombol submit belum ditekan
				$errorMessage = NULL;
				$divClass = NULL;
			}

			$data = [
				'content' 		=> 'participant/guidance/guidance_create',
				'pesan'			=> 'Halaman Data Bimbingan',
				'pagetitle' 	=> 'Data Bimbingan',
				'navbartitle' 	=> 'Data Bimbingan',
				'errorMessage'	=> $errorMessage,
				'divClass'		=> $divClass
			];

			$this->load->view('template',$data);
			
		} else { // jika belum memiliki kelompok
			$message = 'Anda belum memiliki kelompok.. Silahkan memilih kelompok terlebih dahulu...';
			echo "<script>alert('". $message ."')</script>";
            redirect('participant/dashboard','refresh');
		}
	}

	public function delete() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		if ( !empty($_POST) ) {
			$thn_ajaran = $this->input->post('thn_ajaran');
			$smt = $this->input->post('smt');
			$kode_kel = $this->input->post('kode_kel');
			$nou = $this->input->post('nou');

			$deleteProcess = $this->M_bimbingan->delete($thn_ajaran, $smt, $kode_kel, $nou);

			if ( $deleteProcess )
				$errorDelete = 0;
			else
				$errorDelete = 1;

			echo json_encode($errorDelete);

		} else {
			redirect('participant/guidance','refresh');
		}
	}

}

/* End of file Guidance.php */
/* Location: ./application/controllers/participant/Guidance.php */
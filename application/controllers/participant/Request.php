<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		$nbi = $this->session->userdata('nbi');
		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
   		$participant = $this->M_anggota->getAnggotaByPeriode($thn_ajaran, $smt, $nbi)->row();

   		if ( $participant->kode_kel != '0' && $participant->konfirmasi == 1 ) {
   			// jika benar - benar memiliki request join kelompok
   			$content = 'participant/join_request/request';
   			$kode_kel = $participant->kode_kel;
   			$dataMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();

   		} else {
   			// jika tidak memiliki request join kelompok
   			$content = 'participant/join_request/request_empty'; 
   			$kode_kel = NULL;
   			$dataMember = NULL;
   		}

		$data = [
			'content' 		=> $content,
			'dataMember'	=> $dataMember,
			'kode_kel'		=> $kode_kel,
			'pesan'			=> 'Halaman Request Kelompok',
			'pagetitle' 	=> 'Gabung Kelompok',
			'navbartitle' 	=> 'Gabung Kelompok'
		];

		$this->load->view('template',$data);
	}

	public function requestConfirmation() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/request','refresh');
        }

		$setting = $this->M_setting->getSetting()->row();
		$now = date('Y-m-d');
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		
		$kode_kel = $this->input->post('kode_kel');
		$nbi = $this->input->post('nbi');
		$status = $this->input->post('status');

		if ( $setting->bts_kelompok >= $now ) { // jika batas waktu pemilihan waktu masih ada

			if ( $status == 1 ) { // Proses menerima permintaan gabung kelompok

				$updateData = [ 'konfirmasi'	=> 2 ];
				

			} else { // Proses menghapus permintaan gabung kelompok
				$updateData = [
					'kode_kel'		=> '0', 
					'konfirmasi'	=> 0 
				];

			}

			$updateProcess = $this->M_anggota->update($thn_ajaran, $smt, $kode_kel, $nbi, $updateData);

			if ( $updateProcess ) 
				$errorRequestStatusProcess = 0; // proses berhasil
			else
				$errorRequestStatusProcess = 2; // proses gagal

		} else { // batas waktu pemilihan kelompok habis
			$errorRequestStatusProcess = 1; 
		}	

		echo json_encode($errorRequestStatusProcess);

	}

	public function checkRequest() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        $nbi = $this->session->userdata('nbi');
        $setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;

        $checkFilter = [
        	'thn_ajaran'	=> $thn_ajaran,
        	'smt'			=> $smt,
        	'nbi'			=> $nbi,
        	'konfirmasi'	=> 1
        ];

        $check = $this->M_anggota->getAnggota($checkFilter)->num_rows();

        echo json_encode($check);
	}

}

/* End of file Request.php */
/* Location: ./application/controllers/participant/Request.php */
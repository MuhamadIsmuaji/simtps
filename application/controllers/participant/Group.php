<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		redirect('participant/dashboard','refresh');		
	}

	// Untuk input judul kelompok
	public function inputTitleGroup() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('participant/dashboard','refresh');		
		} else {

			$now = date('Y-m-d');
			$setting = $this->M_setting->getSetting()->row();

			if ( $setting->bts_judul >= $now ) {
				$judulnya = $this->input->post('judul');
				$nbi = $this->session->userdata('nbi');
		        $thn_ajaran = $setting->thn_ajaran;
		        $smt = $setting->smt;
				$kode_kel = $this->input->post('kode_kel_modal_title');
				$cekKelompok = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

				if ( $cekKelompok->validasi == 1 ) {
					// judul tidak bisa diubah karena sudah divalidasi
	        		echo "<script>alert('Judul sudah divalidasi dan tidak dapat diubah')</script>";
				} else {

			        $filterData = [
			        	'thn_ajaran'	=> $thn_ajaran,
			        	'smt'			=> $smt,
			        	'nbi'			=> $nbi
			        ];

		        	$anggota = $this->M_anggota->getAnggota($filterData)->row();

		        	// cek apakah anggota kelompok yg input jdul sesuai kelompok yg terdaftar
		        	if ( $anggota->kode_kel == $kode_kel ) {
		        		// data kelompok sesuai kelompok yang dimiliki user
		        		$updateData = ['judul' => $judulnya];

		        		$updateJudul = $this->M_kelompok->update($thn_ajaran, $smt, $kode_kel, $updateData);

		        		if ( $updateJudul ) {
		        			echo "<script>alert('Input judul berhasil')</script>"; 
		        		} else {
		        			echo "<script>alert('Input judul gagal')</script>";
		        		}
		        	} else { 
		        		// data kelompok tidak sesuai
		        		echo "<script>alert('Data tidak sesuai')</script>";
		        	}
				}
				
			} else {
	        	echo "<script>alert('Batas input judul sudah habis')</script>";
			}

			redirect('participant/dashboard','refresh');		

		}
	}

	// Untuk upload file kelompok
	public function inputFileGroup() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('participant/dashboard','refresh');
		} else {
			$now = date('Y-m-d');
			$statusWaktu = 0; // jika 0 maka batas sudah habis
			$setting = $this->M_setting->getSetting()->row();
			$thn_ajaran = $setting->thn_ajaran;
			$smt = $setting->smt;
			$kode_kel = $this->input->post('kode_kel_modal_file'); // kode kelompoknya
			$code = $this->input->post('code'); // file proposal atau revisi proposal

			if ( $code == 1 ) {
				if ( $setting->bts_proposal >= $now ) {
					$statusWaktu = 1;
				} else {
					$statusWaktu = 0;
				}
			} else {
				if ( $setting->bts_revisi >= $now ) {
					$statusWaktu = 1;
				} else {
					$statusWaktu = 0;
				}
			}

			if ( $statusWaktu == 1 ) {
				
				$upload_path_file = $code == 1 ? './assets/files/proposal/' : './assets/files/revisi_proposal/';
				$code_file = $code == 1 ? 'Proposal' : 'Revisi';
				$fileName = $thn_ajaran.'-'.$smt.'-'.$code_file.'-'.$kode_kel;

				$config['upload_path']          = $upload_path_file;
				$config['allowed_types']        = 'pdf|docx';
				$config['max_size']             = 50000; //50 MB
				$config['remove_spaces']        = TRUE;
				$config['file_name']			= $fileName;
				$config['file_ext_tolower']		= FALSE;
				$config['overwrite']			= TRUE;
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('group_document') ) { // Jika upload file dokumen tidak sesuai
					echo "<script>alert('". $this->upload->display_errors() ."')</script>";
				} else { // Jika upload file dokumen sesuai

					$group = $this->M_kelompok->getActiveGroup($thn_ajaran, $smt, $kode_kel)->row();

					// untuk penghapusan file dokumen yang telah diupload sebelumnya
					if ( $code == 1 ) {
						// if ( $group->proposal != NULL ) {
						// 	unlink('assets/files/proposal/'.$group->proposal);
						// }
						$updateDokumen = ['proposal' => $this->upload->data('file_name')];

					} else {
						// if ( $group->revisi != NULL ) {
						// 	unlink('assets/files/revisi_proposal/'.$group->revisi);
						// }
						$updateDokumen = ['revisi' => $this->upload->data('file_name')];
					}
					$updateGroup = $this->M_kelompok->update($thn_ajaran,$smt,$kode_kel,$updateDokumen);
					echo "<script>alert('Upload Dokumen Berhasil !!!')</script>";
				}
				
			} else {
				echo "<script>alert('Batas waktu unggah dokumen sudah habis !!!')</script>";
			}

			redirect('participant/dashboard','refresh');
		}
	}

	// Untuk download dokumen kelompok
	// Param fileName untuk nama file
	// Param code untuk jenis file proposal / revisi proposal
	public function downloadGroupDocument($code = NULL, $fileName = NULL) {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		if ( $code == NULL || $fileName == NULL ) {
			redirect('participant/dashboard','refresh');		
		}

		if ( $code == 1 || $code == 2 ) {
			$file_path = $code == 1 ? 'assets/files/proposal/'.$fileName : 'assets/files/revisi_proposal/'.$fileName;

			if ( file_exists($file_path) ) {
				$this->load->helper('download');
				$file = file_get_contents($file_path);
				force_download($fileName, $file);
			} else {
				//not found page
				redirect('participant/dashboard','refresh');
			}
		} else {
			redirect('participant/dashboard','refresh');		
		}
	}

}

/* End of file Group.php */
/* Location: ./application/controllers/participant/Group.php */

				

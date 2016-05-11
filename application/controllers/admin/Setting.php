<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		redirect('admin/setting/system','refresh');
	}

	private function generateDateFormat($date) {
		$getDate = new DateTime($date);
		return  $getDate->format('Y-m-d');
	}

	public function system() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$settingData = $this->M_setting->getSetting()->row();

		$currentMonth = date('m');
		$currentYear = date('Y');

		// Untuk mengetahui sekarang tahun ajaran berapa dan semester apa
		if ( $currentMonth == 9 || $currentMonth == 10 || $currentMonth == 11 || $currentMonth == 12 || $currentMonth == 1 || $currentMonth == 2 ) {
			$current_thn_ajaran = $currentYear;
			$current_smt = 1;
		} else {
			$current_thn_ajaran = $currentYear - 1;
			$current_smt = 2;
		}
		// Untuk mengetahui sekarang tahun ajaran berapa dan semester apa

		if ( !empty($_POST) ) { // Jika sudah ada submit dari form
			$thn_ajaran = $this->input->post('thn_ajaran');
			$smt = $this->input->post('smt');
			$now = date('Y-m-d');
			
			if ( $this->input->post('btnCreatePeriode') ) { // Jika buat periode ditekan
				$isSetting = $this->M_setting->checkSetting($thn_ajaran, $smt)->num_rows(); // Cek thn_ajaran dan semester

				if ( $isSetting ) { // jika periode sudah ada 
					$errorMessage = 'Buat Periode Gagal. Periode Masih Aktif';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';
				} else { // Periode tidak ada
					if ( $thn_ajaran != $current_thn_ajaran || $smt != $current_smt ) { // Jika buat periode tidak sesuai
						$errorMessage = 'Buat Periode Gagal. Periode Tidak Sesuai';
						$divClass = 'alert fresh-color alert-danger alert-dismissible';		
					} else { // Periode sesuai
						$bts_judul = $this->generateBatasWaktuCreate($this->input->post('bts_judul'));
						$bts_kelompok = $this->generateBatasWaktuCreate($this->input->post('bts_kelompok'));
						$bts_proposal = $this->generateBatasWaktuCreate($this->input->post('bts_proposal'));
						$bts_revisi = $this->generateBatasWaktuCreate($this->input->post('bts_revisi'));

						if ( $bts_judul[0] || $bts_kelompok[0] || $bts_proposal[0] || $bts_revisi[0] ) {
							$errorMessage = 'Batas Waktu Tidak Boleh Kurang Dari Tanggal Sekarang';
							$divClass = 'alert fresh-color alert-danger alert-dismissible';	
						} else {
							$npp_dekan = $this->input->post('npp_dekan') ? $this->input->post('npp_dekan') : $settingData->npp_dekan;
							$nama_dekan = $this->input->post('nama_dekan') ? $this->input->post('nama_dekan') : $settingData->nama_dekan;
							$npp_kalab = $this->input->post('npp_kalab') ? $this->input->post('npp_kalab') : $settingData->npp_kalab;
							$nama_kalab = $this->input->post('nama_kalab') ? $this->input->post('nama_kalab') : $settingData->nama_kalab;

							$no_surattgs = $this->input->post('no_surattgs') ? $this->input->post('no_surattgs') : '';
							$tgl_surattgs = $this->input->post('tgl_surattgs') ? $this->input->post('tgl_surattgs') : $now;
							$tgl_surattgs = $this->generateDateFormat($tgl_surattgs);
							$status = 1;
							
							$updateSetting = [
								'status'	=> 0
							];
							$updateSettingProcess = $this->M_setting->update($settingData->thn_ajaran, $settingData->smt, $updateSetting);

							$createSetting = [
								'thn_ajaran'	=> $current_thn_ajaran,
								'smt'			=> $current_smt,
								'bts_judul'		=> $bts_judul[1],
								'bts_kelompok'	=> $bts_kelompok[1],
								'bts_proposal'	=> $bts_proposal[1],
								'bts_revisi'	=> $bts_revisi[1],
								'npp_dekan'		=> $npp_dekan,
								'nama_dekan'	=> $nama_dekan,
								'npp_kalab'		=> $npp_kalab,
								'nama_kalab'	=> $nama_kalab,
								'no_surattgs'	=> $no_surattgs,
								'tgl_surattgs'	=> $tgl_surattgs,
								'status'		=> $status,
							];

							$createSettingProcess = $this->M_setting->insert($createSetting);

							// Proses menonaktifkan semua peserta sebelumnya
							$mhsActive = $this->M_mhs->getMhsActive()->result_object();
							if ( $mhsActive ) {
								$updateMhs = ['akses' => 0];
								foreach( $mhsActive as $mhs ) {
									$this->M_mhs->update($mhs->nbi, $updateMhs);
								}
							}
							// Proses menonaktifkan semua peserta sebelumnya

							if ( $createSettingProcess ) {
								$errorMessage = 'Buat Periode Berhasil';
								$divClass = 'alert fresh-color alert-success alert-dismissible';
							} else {
								$errorMessage = 'Buat Periode Gagal';
								$divClass = 'alert fresh-color alert-danger alert-dismissible';
							}
						}
					}
				}

			} else { // Jika simpan periode ditekan
				$bts_judul = $this->generateBatasWaktu($this->input->post('bts_judul'),1);
				$bts_kelompok = $this->generateBatasWaktu($this->input->post('bts_kelompok'),2);
				$bts_proposal = $this->generateBatasWaktu($this->input->post('bts_proposal'),3);
				$bts_revisi = $this->generateBatasWaktu($this->input->post('bts_revisi'),4);

				if ( $bts_judul[0] || $bts_kelompok[0] || $bts_proposal[0] || $bts_revisi[0] ) {
					$errorMessage = 'Batas Waktu Tidak Boleh Kurang Dari Tanggal Sekarang';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';	
				} else {
					$npp_dekan = $this->input->post('npp_dekan') ? $this->input->post('npp_dekan') : $settingData->npp_dekan;
					$nama_dekan = $this->input->post('nama_dekan') ? $this->input->post('nama_dekan') : $settingData->nama_dekan;
					$npp_kalab = $this->input->post('npp_kalab') ? $this->input->post('npp_kalab') : $settingData->npp_kalab;
					$nama_kalab = $this->input->post('nama_kalab') ? $this->input->post('nama_kalab') : $settingData->nama_kalab;

					$no_surattgs = $this->input->post('no_surattgs') ? $this->input->post('no_surattgs') : $settingData->no_surattgs;
					$tgl_surattgs = $this->input->post('tgl_surattgs') ? $this->input->post('tgl_surattgs') : $settingData->tgl_surattgs;
					$tgl_surattgs = $this->generateDateFormat($tgl_surattgs);

					$updateSetting = [
						'bts_judul'		=> $bts_judul[1],
						'bts_kelompok'	=> $bts_kelompok[1],
						'bts_proposal'	=> $bts_proposal[1],
						'bts_revisi'	=> $bts_revisi[1],
						'npp_dekan'		=> $npp_dekan,
						'nama_dekan'	=> $nama_dekan,
						'npp_kalab'		=> $npp_kalab,
						'nama_kalab'	=> $nama_kalab,
						'no_surattgs'	=> $no_surattgs,
						'tgl_surattgs'	=> $tgl_surattgs

					];

					$updateSettingProcess = $this->M_setting->update($settingData->thn_ajaran, $settingData->smt, $updateSetting);
					if ( $updateSettingProcess ) {
						$errorMessage = 'Update Periode Berhasil';
						$divClass = 'alert fresh-color alert-success alert-dismissible';
					} else {
						$errorMessage = 'Update Periode Gagal';
						$divClass = 'alert fresh-color alert-danger alert-dismissible';
					}
				}
			}
		} else {
			$errorMessage = NULL;
			$divClass = NULL;
		}

		$settingDataNew = $this->M_setting->getSetting()->row();
		$data = [
			'content' 				=> 'admin/setting/system',
			'pesan'					=> 'Halaman Setting System Admin',
			'pagetitle' 			=> 'Pengaturan Sistem',
			'navbartitle' 			=> 'Pengaturan Sistem',
			'settingData'			=> $settingDataNew,
			'errorMessage'  		=> $errorMessage,
			'divClass'				=> $divClass,
			'current_thn_ajaran'	=> $current_thn_ajaran,
			'current_smt'			=> $current_smt
		];

		$this->load->view('template',$data);
	}

	private function generateBatasWaktu($input = NULL, $batasApa = NULL) {
		$getSettingData = $this->M_setting->getSetting()->row();

		if ( $batasApa == 1 )
			$btsnya = $getSettingData->bts_judul;
		else if ( $batasApa == 2 )
			$btsnya = $getSettingData->bts_kelompok;
		else if ( $batasApa == 3 )
			$btsnya = $getSettingData->bts_proposal;
		else 
			$btsnya = $getSettingData->bts_revisi;

		if ( $input ) {
			$now = date('Y-m-d');
			$bts_waktu_cek = $this->generateDateFormat($input);

			if ( $bts_waktu_cek < $now ) {
				$errorBtsWaktu = 1;
				$bts_waktu = $btsnya;
			} else {
				$errorBtsWaktu = 0;
				$bts_waktu = $bts_waktu_cek;
			}
		} else {
			$errorBtsWaktu = 0;
			$bts_waktu = $btsnya;
		}

		$data = [ 0 => $errorBtsWaktu, 1 => $bts_waktu ];
		return $data;
	}

	private function generateBatasWaktuCreate($input = NULL) {
		$getSettingData = $this->M_setting->getSetting()->row();
		$now = date('Y-m-d');
		$btsnya = $now;

		if ( $input ) {
			$bts_waktu_cek = $this->generateDateFormat($input);

			if ( $bts_waktu_cek < $now ) {
				$errorBtsWaktu = 1;
				$bts_waktu = $btsnya;
			} else {
				$errorBtsWaktu = 0;
				$bts_waktu = $bts_waktu_cek;
			}
		} else {
			$errorBtsWaktu = 0;
			$bts_waktu = $btsnya;
		}

		$data = [ 0 => $errorBtsWaktu, 1 => $bts_waktu ];
		return $data;
	}

	public function profile() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$data = [
			'content' => 'admin/setting/profile'
		];
	}

}


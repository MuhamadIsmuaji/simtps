<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		redirect('admin/data/schedule/hearingSchedule','refresh');

	}

	public function hearingSchedule() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$jadwal = $this->M_jadwal->getScheduleList($setting->thn_ajaran,$setting->smt)->result();

		$data = [
			'settingData'	=> $setting,
			'jadwal'		=> $jadwal,
			'content' 		=> 'admin/data/schedule/hearing/hearing_schedule_lists',
			'pagetitle' 	=> 'Jadwal Sidang',
			'navbartitle' 	=> 'Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

	public function hearingScheduleEdit($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $moderator = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL || $ruang == NULL || $tgl == NULL || $mulai == NULL || $akhir == NULL || $moderator == NULL ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();

		if ( $thn_ajaran != $setting->thn_ajaran && $thn_ajaran != $setting->smt ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$identitasJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran, $smt, $ruang, $moderator, $tgl, $mulai, $akhir)->row();
		$detailJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran, $smt, $ruang, $moderator, $tgl, $mulai, $akhir)->result();
		if ( !$identitasJadwal || !$detailJadwal ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$moderator = $this->M_dosen->getDosenByNpp($identitasJadwal->moderator)->row();
		$penguji1 = $this->M_dosen->getDosenByNpp($identitasJadwal->penguji1)->row()->nama;
		$penguji2 = $this->M_dosen->getDosenByNpp($identitasJadwal->penguji2)->row()->nama;
		$dataDoping = $this->M_dosen->getDosenActive()->result();

		$data = [
			'settingData'		=> $setting,
			'moderator'			=> $moderator,
			'penguji1'			=> $penguji1,
			'penguji2'			=> $penguji2,
			'dataDoping'		=> $dataDoping,
			'identitasJadwal'	=> $identitasJadwal,
			'detailJadwal'		=> $detailJadwal,
			'content' 			=> 'admin/data/schedule/hearing/hearing_schedule_edit',
			'pagetitle' 		=> 'Edit Jadwal Sidang',
			'navbartitle' 		=> 'Edit Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

	public function hearingScheduleCreate() {
		$setting = $this->M_setting->getSetting()->row();
		$dataDoping = $this->M_dosen->getDosenActive()->result();

		$data = [
			'settingData'	=> $setting,
			'dataDoping'	=> $dataDoping,
			'content' 		=> 'admin/data/schedule/hearing/hearing_schedule_create',
			'pagetitle' 	=> 'Buat Jadwal Sidang',
			'navbartitle' 	=> 'Buat Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

	public function hearingScheduleDetail($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $moderator = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL || $ruang == NULL || $tgl == NULL || $mulai == NULL || $akhir == NULL || $moderator == NULL ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();

		if ( $thn_ajaran != $setting->thn_ajaran && $thn_ajaran != $setting->smt ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$identitasJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran, $smt, $ruang, $moderator, $tgl, $mulai, $akhir)->row();
		$detailJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran, $smt, $ruang, $moderator, $tgl, $mulai, $akhir)->result();
		if ( !$identitasJadwal || !$detailJadwal ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$moderator = $this->M_dosen->getDosenByNpp($identitasJadwal->moderator)->row()->nama;
		$penguji1 = $this->M_dosen->getDosenByNpp($identitasJadwal->penguji1)->row()->nama;
		$penguji2 = $this->M_dosen->getDosenByNpp($identitasJadwal->penguji2)->row()->nama;

		$data = [
			'settingData'		=> $setting,
			'moderator'			=> $moderator,
			'penguji1'			=> $penguji1,
			'penguji2'			=> $penguji2,
			'identitasJadwal'	=> $identitasJadwal,
			'detailJadwal'		=> $detailJadwal,
			'content' 			=> 'admin/data/schedule/hearing/hearing_schedule_detail',
			'pagetitle' 		=> 'Detail Jadwal Sidang',
			'navbartitle' 		=> 'Detail Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

	private function generateDateFormat($date = null) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$getDate = new DateTime($date);
		return  $getDate->format('Y-m-d');
	}

	public function hearingScheduleEditProcess() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if (!empty($_GET)) {
			// data lama
			$old_tgl = $this->generateDateFormat($this->input->get('old_tgl'));
			$old_ruang = strtoupper($this->input->get('old_ruang'));
			$old_mulai = $this->input->get('old_mulai');
			$old_akhir = $this->input->get('old_akhir');
			$old_penguji1 = $this->input->get('old_penguji1');
			$old_penguji2 = $this->input->get('old_penguji2');
			$setting = $this->M_setting->getSetting()->row();

			// data baru
			$tgl = $this->generateDateFormat($this->input->get('tgl'));
			$ruang = strtoupper($this->input->get('ruang'));
			$mulai = $this->input->get('mulai');
			$akhir = $this->input->get('akhir');
			$moderator = $this->input->get('moderator');
			$penguji1 = $this->input->get('penguji1');
			$penguji2 = $this->input->get('penguji2');
			$validasi = $this->input->get('validasi');
			$now = date('Y-m-d');

			if ( $tgl <= $now ) { // Cek tgl apakah lebih dari tanggal sekarang
				echo "<script>alert('Tanggal Sidang Harus Lebih Dari Tanggal Sekarang')</script>";
				redirect('admin/data/schedule/hearingScheduleCreate','refresh');
			} else { // jika tgl memenuhi syarat

				if ( $mulai >= $akhir ) { // jam mulai harus lebih dari jam berakhir
					echo "<script>alert('Kesalahan Dalam Memilih Jam Mulai dan Jam Berakhir')</script>";
					redirect('admin/data/schedule/hearingScheduleCreate','refresh');
				} else {
					// dosen hanya bisa jadi moderator / penguji 1 / penguji 2
					if ( $moderator == $penguji1 || $moderator == $penguji2 || $penguji1 == $penguji2) { 
						echo "<script>alert('Satu Dosen Hanya Boleh Menjadi Moderator/Penguji 1/Penguji 2')</script>";
						redirect('admin/data/schedule/hearingScheduleCreate','refresh');
					} else { // process tambah jadwal sidang

						//jika tidak ada perubahan
						if ( $penguji1 == $old_penguji1 && $penguji2 == $old_penguji2 && $ruang == $old_ruang && $tgl == $old_tgl && $mulai == $old_mulai && $akhir == $old_akhir ) {
							//Data jadwal yang ada akan dihapus sesuai jadwal dan akan dibuat ulang
							$delete = $this->M_jadwal->deleteBySchedule($setting->thn_ajaran, $setting->smt, $ruang, $moderator, $tgl, $mulai, $akhir);

							for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
					            $kode_kel = $this->input->get('kode_kel'.$i);
					            $scheduleData = [
					            	'thn_ajaran'	=> $setting->thn_ajaran,
					            	'smt'			=> $setting->smt,
					            	'kode_kel'		=> $kode_kel,
					            	'ruang'			=> $ruang,
					            	'moderator'		=> $moderator,
					            	'penguji1'		=> $penguji1,
					            	'penguji2'		=> $penguji2,
					            	'validasi'		=> $validasi,
					            	'tgl'			=> $tgl,
					            	'mulai'			=> $mulai,
					            	'akhir'			=> $akhir
					            ];

					            $insertProcess = $this->M_jadwal->insert($scheduleData);
					        }
					        if ( $insertProcess ) {
								echo "<script>alert('Jadwal Sidang Berhasil Diubah');</script>";
								redirect('admin/data/schedule/hearingSchedule','refresh');
					        } else {
					        	echo "<script>alert('Jadwal Sidang Gagal Diubah');</script>";
								redirect('admin/data/schedule/hearingSchedule','refresh');
					        }
														
						} else { // Jika ada perubahan

							// cek jadwal ruang
							if ( $tgl == $old_tgl && $mulai == $old_mulai && $akhir == $old_akhir ) {
								$cekJadwalRuang = 0;
								$jadwalPenguji1 = 0;
								$jadwalPenguji2 = 0;
							} else {
								// $cekJadwalRuang = $this->cekJadwalRuang($setting->thn_ajaran, $setting->smt, $ruang, $tgl, $mulai, $akhir);
								// $jadwalPenguji1 = $this->cekJadwalDosen($setting->thn_ajaran, $setting->smt, $penguji1, $tgl, $mulai, $akhir);
								// $jadwalPenguji2 = $this->cekJadwalDosen($setting->thn_ajaran, $setting->smt, $penguji2, $tgl, $mulai, $akhir);

								$cekJadwalRuang = 0;
								$jadwalPenguji1 = 0;
								$jadwalPenguji2 = 0;

							}

							if ( $cekJadwalRuang > 0 ) {
								echo "<script>alert('Jadwal Ruang Crash')</script>";
								redirect('admin/data/schedule/hearingSchedule','refresh');
							} else if ( $jadwalPenguji1 > 0 || $jadwalPenguji2 > 0 ) {
								echo "<script>alert('Jadwal Dosen Crash')</script>";
								redirect('admin/data/schedule/hearingSchedule','refresh');
							} else {
								//Data jadwal yang ada akan dihapus sesuai jadwal dan akan dibuat ulang
								$delete = $this->M_jadwal->deleteBySchedule($setting->thn_ajaran, $setting->smt, $old_ruang, $moderator, $old_tgl, $old_mulai, $old_akhir);

								for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
						            $kode_kel = $this->input->get('kode_kel'.$i);
						            $scheduleData = [
						            	'thn_ajaran'	=> $setting->thn_ajaran,
						            	'smt'			=> $setting->smt,
						            	'kode_kel'		=> $kode_kel,
						            	'ruang'			=> $ruang,
						            	'moderator'		=> $moderator,
						            	'penguji1'		=> $penguji1,
						            	'penguji2'		=> $penguji2,
						            	'validasi'		=> $validasi,
						            	'tgl'			=> $tgl,
						            	'mulai'			=> $mulai,
						            	'akhir'			=> $akhir
						            ];

						            $insertProcess = $this->M_jadwal->insert($scheduleData);
						        }
						        if ( $insertProcess ) {
									echo "<script>alert('Jadwal Sidang Berhasil Diubah');</script>";
									redirect('admin/data/schedule/hearingSchedule','refresh');
						        } else {
						        	echo "<script>alert('Jadwal Sidang Gagal Diubah');</script>";
									redirect('admin/data/schedule/hearingSchedule','refresh');
						        }
							}
							
						}
						
					}
				}
			
			}
			
		}

		redirect('admin/data/schedule/hearingSchedule','refresh');
	}

	public function hearingScheduleCreateProcess() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if (!empty($_GET)) {
			$tgl = $this->generateDateFormat($this->input->get('tgl'));
			$ruang = strtoupper($this->input->get('ruang'));
			$mulai = $this->input->get('mulai');
			$akhir = $this->input->get('akhir');
			$moderator = $this->input->get('moderator');
			$penguji1 = $this->input->get('penguji1');
			$penguji2 = $this->input->get('penguji2');
			$validasi = $this->input->get('validasi');
			$now = date('Y-m-d');

			if ( $tgl <= $now ) { // Cek tgl apakah lebih dari tanggal sekarang
				echo "<script>alert('Tanggal Sidang Harus Lebih Dari Tanggal Sekarang')</script>";
				redirect('admin/data/schedule/hearingScheduleCreate','refresh');
			} else { // jika tgl memenuhi syarat

				if ( $mulai >= $akhir ) { // jam mulai harus lebih dari jam berakhir
					echo "<script>alert('Kesalahan Dalam Memilih Jam Mulai dan Jam Berakhir')</script>";
					redirect('admin/data/schedule/hearingScheduleCreate','refresh');
				} else {
					// dosen hanya bisa jadi moderator / penguji 1 / penguji 2
					if ( $moderator == $penguji1 || $moderator == $penguji2 || $penguji1 == $penguji2) { 
						echo "<script>alert('Satu Dosen Hanya Boleh Menjadi Moderator/Penguji 1/Penguji 2')</script>";
						redirect('admin/data/schedule/hearingScheduleCreate','refresh');
					} else { // process tambah jadwal sidang
						$setting = $this->M_setting->getSetting()->row();
						// $cekJadwalRuang = $this->cekJadwalRuang($setting->thn_ajaran, $setting->smt, $ruang, $tgl, $mulai, $akhir);
						$cekJadwalRuang = 0;

						if ( $cekJadwalRuang > 0 ) {
							echo "<script>alert('Jadwal Ruang Crash')</script>";
							redirect('admin/data/schedule/hearingScheduleCreate','refresh');
						} else {
							// $jadwalModerator = $this->cekJadwalDosen($setting->thn_ajaran, $setting->smt, $moderator, $tgl, $mulai, $akhir);
							// $jadwalPenguji1 = $this->cekJadwalDosen($setting->thn_ajaran, $setting->smt, $penguji1, $tgl, $mulai, $akhir);
							// $jadwalPenguji2 = $this->cekJadwalDosen($setting->thn_ajaran, $setting->smt, $penguji2, $tgl, $mulai, $akhir);

							$jadwalModerator = 0;
							$jadwalPenguji1 = 0;
							$jadwalPenguji2 = 0;	

							if ( $jadwalModerator > 0 || $jadwalPenguji1 > 0 || $jadwalPenguji2 > 0) {
								echo "<script>alert('Jadwal Dosen Crash')</script>";
								redirect('admin/data/schedule/hearingScheduleCreate','refresh');
							} else {
								for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
						            $kode_kel = $this->input->get('kode_kel'.$i);
						            $scheduleData = [
						            	'thn_ajaran'	=> $setting->thn_ajaran,
						            	'smt'			=> $setting->smt,
						            	'kode_kel'		=> $kode_kel,
						            	'ruang'			=> $ruang,
						            	'moderator'		=> $moderator,
						            	'penguji1'		=> $penguji1,
						            	'penguji2'		=> $penguji2,
						            	'validasi'		=> $validasi,
						            	'tgl'			=> $tgl,
						            	'mulai'			=> $mulai,
						            	'akhir'			=> $akhir
						            ];

						            $insertProcess = $this->M_jadwal->insert($scheduleData);
						        }
						        if ( $insertProcess ) {
									echo "<script>alert('Jadwal Sidang Berhasil Dibuat');</script>";
									redirect('admin/data/schedule/hearingSchedule','refresh');
						        } else {
						        	echo "<script>alert('Jadwal Sidang Gagal Dibuat');</script>";
									redirect('admin/data/schedule/hearingSchedule','refresh');
						        }
							}
						}
					}
				}
			}
		}

		redirect('admin/data/schedule/hearingScheduleCreate','refresh');
	}

	public function hearingScheduleDeleteProcess() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if (!empty($_POST)) {
			$thn_ajaran = $this->input->post('thn_ajaran');
			$smt = $this->input->post('smt');
			$ruang = $this->input->post('ruang');
			$moderator = $this->input->post('moderator');
			$tgl = $this->input->post('tgl');
			$mulai = $this->input->post('mulai');
			$akhir = $this->input->post('akhir');

			$delete = $this->M_jadwal->deleteBySchedule($thn_ajaran, $smt, $ruang, $moderator, $tgl, $mulai, $akhir);
			
			if ( $delete ) 
				echo json_encode(1);
			else 
				echo json_encode(0);
		}

		redirect('admin/data/schedule/hearingSchedule','refresh');

	}

	public function getGroupList() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/data/schedule/hearingScheduleCreate','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$doping = $this->input->post('moderator');
		$group = $this->M_kelompok->getActiveGroupWithDoping($setting->thn_ajaran,$setting->smt,$doping)->result();

		$dataGroup = array();
		$many = 0;
		foreach ($group as $value) {
			// cek apakah kelompok sudah disusun jadwal atau belum
			$isAnySchedule = $this->M_jadwal->getGroupScheduleByCode($setting->thn_ajaran,$setting->smt,$value->kode_kel)->num_rows();
			if ($isAnySchedule == 0) {
				$many++;
				$dataGroup[] = $value->kode_kel;
			}			
		}		
		echo json_encode(['many' => $many, 'list' => $dataGroup]);
	}

	public function getGroupListEdit() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/data/schedule/hearingSchedule','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$doping = $this->input->post('moderator');
		$ruang = $this->input->post('old_ruang');
		$mulai = $this->input->post('old_mulai');
		$akhir = $this->input->post('old_akhir');
		$tgl = $this->input->post('old_tgl');
		
		// grup yang sudah ada di jadwal
		$groupWithSchedule = $this->M_jadwal->getJadwalByIdentitas($setting->thn_ajaran, $setting->smt, $ruang, $doping, $tgl, $mulai, $akhir)->result_array();

		$group = $this->M_kelompok->getActiveGroupWithDoping($setting->thn_ajaran,$setting->smt,$doping)->result();
		
		$dataGroup = array();
		$many = 0;
		$index = 0;

		foreach ($group as $value) {
			$data = array();
			if ( $index < count($groupWithSchedule) ) {
				// cek apakah group sudah di jadwal, jika sudah maka checkbox akan checked
				if ( $value->kode_kel == $groupWithSchedule[$index]['kode_kel'] ) { 
					$data[] = 1;
					$data[] = $value->kode_kel;
					$index++;

					$many++;
					$dataGroup[] = $data;

				}
			} else {
				$punyaJadwal = $this->M_jadwal->getGroupScheduleByCode($setting->thn_ajaran,$setting->smt, $value->kode_kel)->num_rows();
				// Untuk mencegah tampil di list ketika grup sudah ada jadwal di tempat lain
				if ( $punyaJadwal == 0 ) {
					$data[] = 0;
					$data[] = $value->kode_kel;
					$many++;
					$dataGroup[] = $data;
				}
			}			
		}
		echo json_encode(['many' => $many, 'list' => $dataGroup]);
	}

	private function cekJadwalRuang($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $tgl = NULL, $awal = NULL, $akhir = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$cekRuang = $this->M_jadwal->getRoomSchedule($thn_ajaran,$smt,$ruang,$tgl)->result();
		$adaJadwal = 0;

		if ( $cekRuang ) {

			foreach ($cekRuang as $value) {
				if ( $awal >= $value->mulai && $akhir <= $value->akhir ) {
					$adaJadwal++;	
				} else if ( $awal <= $value->mulai && $akhir >= $value->akhir )  {
					$adaJadwal++;
				} else if ( $awal <= $value->mulai && $akhir <= $value->akhir) {
					if ( $akhir >= $value->mulai )
						$adaJadwal++;
				} else if ( $awal >= $value->mulai && $akhir >= $value->akhir) {
					if ( $awal <= $value->akhir )
						$adaJadwal++;

				} else {}
			}

		} else {
			$adaJadwal = 0;
		}

		return $adaJadwal;
	}

	private function cekJadwalDosen($thn_ajaran = NULL, $smt = NULL, $npp = NULL, $tgl = NULL, $awal = NULL, $akhir = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$cekk = $this->M_jadwal->getDopingSchedule($thn_ajaran,$smt,$npp,$tgl)->result();
		$ada = 0;

		if ( $cekk ) {

			foreach ($cekk as $value) {
				if ( $awal >= $value->mulai && $akhir <= $value->akhir ) {
					$ada++;	
				} else if ( $awal <= $value->mulai && $akhir >= $value->akhir )  {
					$ada++;
				} else if ( $awal <= $value->mulai && $akhir <= $value->akhir) {
					if ( $akhir >= $value->mulai )
						$ada++;
				} else if ( $awal >= $value->mulai && $akhir >= $value->akhir) {
					if ( $awal <= $value->akhir )
						$ada++;

				} else {}
			}

		} else {
			$ada = 0;
		}

		return $ada;
	}

}

/* End of file Schedule.php */
/* Location: ./application/controllers/admin/data/Schedule.php */
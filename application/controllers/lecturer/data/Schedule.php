<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		redirect('lecturer/data/schedule/hearingSchedule','refresh');

	}

	public function hearingSchedule() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$jadwal = $this->M_jadwal->getScheduleDosen($setting->thn_ajaran,$setting->smt, $this->session->userdata('npp'))->result();

		$dataJadwal = [];
		
		foreach ($jadwal as $value) {
			$jadwal_n = [];
			
			// jadwal
			$moderator = $this->M_dosen->getDosenBynpp($value->moderator)->row()->nama;
			$penguji1 = $this->M_dosen->getDosenBynpp($value->penguji1)->row()->nama;
			$penguji2 = $this->M_dosen->getDosenBynpp($value->penguji2)->row()->nama;
			$tgl = new DateTime($value->tgl);
			$mulai = $value->mulai <= 9 ? '0'. $value->mulai .':00' : $value->mulai .':00';
			$akhir = $value->akhir <= 9 ? '0'. $value->akhir .':00' : $value->akhir .':00';
			$waktu = $mulai.' - '.$akhir;

			// anggota
			$anggota = $this->M_anggota->getAnggotaByKodeKelJoinMhs($setting->thn_ajaran, $setting->smt, $value->kode_kel)->result();

			$anggotanya = [];
			foreach ($anggota as $dataAnggota) {
				$anggota_n = [];

				$anggota_n = [
					'nbi'	=> $dataAnggota->nbi,
					'nama'	=> $dataAnggota->nama
				];

				$anggotanya[] = $anggota_n;
			}

			$jadwal_n = [
				'tanggal'		=> $tgl->format('d-m-Y'),
				'waktu'			=> $waktu,
				'ruang'			=> $value->ruang, 
				'moderator'		=> $moderator,
				'penguji1'		=> $penguji1,
				'penguji2'		=> $penguji2,
				'kode_kel'		=> $value->kode_kel,
				'anggotanya'	=> $anggotanya
			];

			$dataJadwal[] = $jadwal_n;
		}

		$data = [
			'settingData'		=> $setting,
			'dataJadwal'		=> $dataJadwal,
			'content' 			=> 'lecturer/data/schedule/hearing_schedule_lists',
			'pagetitle' 		=> 'Jadwal Sidang',
			'navbartitle' 		=> 'Jadwal Sidang',
		];

		$this->load->view('template',$data);
	}

}

/* End of file Schedule.php */
/* Location: ./application/controllers/lecturer/data/Schedule.php */
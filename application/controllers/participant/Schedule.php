<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		redirect('participant/schedule/hearingSchedule','refresh');
	}

	public function hearingSchedule() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $setting->thn_ajaran;
		$smt = $setting->smt;
		$kode_kel = $this->M_anggota->getAnggotaByPeriode($thn_ajaran,$smt,$this->session->userdata('nbi'))->row()->kode_kel;

		$jad_kelompok = $this->M_jadwal->getGroupScheduleByCode($thn_ajaran,$smt,$kode_kel)->row();
		$jadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran,$smt,$jad_kelompok->ruang,$jad_kelompok->tgl,$jad_kelompok->mulai,$jad_kelompok->akhir)->result();


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
			'content' 			=> 'participant/schedule/hearing_schedule_lists',
			'pagetitle' 		=> 'Jadwal Sidang',
			'navbartitle' 		=> 'Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}
}

/* End of file Schedule.php */
/* Location: ./application/controllers/participant/Schedule.php */
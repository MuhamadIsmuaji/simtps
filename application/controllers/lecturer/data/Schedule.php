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
		$jadwal = $this->M_jadwal->getScheduleList($setting->thn_ajaran,$setting->smt)->result();

		$data = [
			'settingData'	=> $setting,
			'jadwal'		=> $jadwal,
			'content' 		=> 'lecturer/data/schedule/hearing_schedule_lists',
			'pagetitle' 	=> 'Jadwal Sidang',
			'navbartitle' 	=> 'Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

	public function hearingScheduleDetail($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL || $ruang == NULL || $tgl == NULL || $mulai == NULL || $akhir == NULL  ) {
			redirect('lecturer/data/schedule/hearingSchedule','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();

		if ( $thn_ajaran != $setting->thn_ajaran && $thn_ajaran != $setting->smt ) {
			redirect('lecturer/data/schedule/hearingSchedule','refresh');
		}

		$identitasJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran,$smt,$ruang,$tgl,$mulai,$akhir)->row();
		$detailJadwal = $this->M_jadwal->getJadwalByIdentitas($thn_ajaran,$smt,$ruang,$tgl,$mulai,$akhir)->result();
		if ( !$identitasJadwal || !$detailJadwal ) {
			redirect('lecturer/data/schedule/hearingSchedule','refresh');
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
			'content' 			=> 'lecturer/data/schedule/hearing_schedule_detail',
			'pagetitle' 		=> 'Detail Jadwal Sidang',
			'navbartitle' 		=> 'Detail Jadwal Sidang'
		];

		$this->load->view('template',$data);
	}

}

/* End of file Schedule.php */
/* Location: ./application/controllers/lecturer/data/Schedule.php */
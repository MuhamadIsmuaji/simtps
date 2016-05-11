<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$data = [
			'content' 		=> 'lecturer/index',
			'pesan'			=> 'Halaman Home Dosen',
			'pagetitle' 	=> 'Dashboard Dosen',
			'navbartitle' 	=> 'Dashboard'
		];

		$this->load->view('template',$data);
	}

}

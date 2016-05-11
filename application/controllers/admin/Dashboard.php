<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$data = [
			'content' 		=> 'admin/index',
			'pesan'			=> 'Halaman Home Admin',
			'pagetitle' 	=> 'Dashboard Admin',
			'navbartitle' 	=> 'Dashboard'
		];

		$this->load->view('template',$data);
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		redirect('lecturer/dashboard','refresh');
	}

}

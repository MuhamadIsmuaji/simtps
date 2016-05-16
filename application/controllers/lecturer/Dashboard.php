<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		redirect('lecturer/data/group','refresh');
	}

}

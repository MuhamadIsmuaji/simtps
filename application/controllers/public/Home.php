<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{

	function construct() {
		parent::__construct();
	}

	public function index() {

		$dateNow = date('Y-m-d');
		$news = $this->M_pengumuman->getNewestNews($dateNow)->row();
		$check = $this->M_pengumuman->getNewestNews($dateNow)->num_rows();

		$this->session->unset_userdata('tmpParticipantTps');

		$data = [
			'content' 		=> 'public/index',
			'pesan'			=> 'Selamat Datang',
			'pagetitle' 	=> 'Lab. RPL Untag Surabaya',
			'navbartitle' 	=> 'Lab. RPL Untag Surabaya',
			'news'			=> $news,
			'check'			=> $check
		];

		$this->load->view('template',$data);
	}
}

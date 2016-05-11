<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		$data = [
			'content' 	=> 'coba_view',
			'pesan'		=> 'hello',
			'pagetitle' => 'index'
		];

		$this->load->view('template',$data);
	}

	public function menu() {

		$data = [
			'content' => 'admin/data/loa/loa_print',
			'pesan' => 'hello2',
			'pagetitle' => 'menu'
		];

		 $this->load->view('admin/data/loa/loa_print',$data );
	}

	function pdf_welcome_message(){
        // load dompdf
        $this->load->helper('dompdf');
        //load content html
        $html = $this->load->view('welcome_message', '', true);
        // create pdf using dompdf
        $filename = 'Message';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);
    }
}
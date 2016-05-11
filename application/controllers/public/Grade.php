<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		redirect('public/grade/gradeCheck','refresh');
	}

	public function gradeCheck() {

		if (!empty($_POST)) {
			$nbi = $this->input->post('nbi');
			$row = $this->M_anggota->getAnggotaByNbi($nbi)->num_rows();
			echo json_encode($row);
		}

		$data = [
			'content' 	=> 'public/grade_check',
			'pesan'		=> 'Ini halaman grade check',
			'pagetitle' => 'Grade Check',
			'navbartitle' 	=> 'Lab. RPL Untag Surabaya'
			
		];

		$this->load->view('template',$data);
	}

	public function checkProcess(){
			$nbi = $this->input->post('nbi');
			$row = $this->M_anggota->getAnggotaByNbi($nbi)->num_rows();
			$data = $this->M_anggota->getAnggotaByNbi($nbi)->result_object();

			$output = [
				'status' => $row,
				'data'	=> $data
			];
			
			echo json_encode($output);
	}
}

/* End of file Grade.php */
/* Location: ./application/controllers/public/Grade.php */
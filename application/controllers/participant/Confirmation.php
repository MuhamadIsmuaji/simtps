<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmation extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( ! $this->session->userdata('tmpParticipantTps') ) {

			if ( $this->session->userdata('isParticipantTps') ) {
				redirect('participant/home','refresh');				
			} else {
				redirect('public/home','refresh');
			}
		}

		$this->load->view('participant/confirmation');
	}

	public function confirmationProcess() {

		if ( ! $this->session->userdata('tmpParticipantTps') ) {

			if ( $this->session->userdata('isParticipantTps') ) {
				redirect('participant/home','refresh');				
			} else {
				redirect('public/home','refresh');
			}
		}

		if ( ! empty($_POST) ) {

			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('pwd', 'Password Baru', 'trim|required|alpha_numeric|min_length[4]|max_length[11]');
			$this->form_validation->set_rules('pwdconf', 'Ulangi Password Baru', 'trim|required|alpha_numeric|matches[pwd]');
			$this->form_validation->set_error_delimiters('<i style="color: red">', '</i>');

			$this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			$this->form_validation->set_message('required', 'Field wajib diisi');
			$this->form_validation->set_message('alpha_numeric', 'Hanya boleh mengandung karakter alpha numerik');
			$this->form_validation->set_message('matches', 'Ulangi password baru tidak sesuai');
			$this->form_validation->set_message('min_length', 'Minimal terdiri dari 4 karakter');
			$this->form_validation->set_message('max_length', 'Maksimal terdiri dari 9 karakter');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('participant/confirmation');
			} else {
				$mhsData = [
					'email'		=> $this->input->post('email'),
					'pwd'		=> $this->input->post('pwdconf'),
					'akses'		=> 1

				];

				$update = $this->M_mhs->update($this->session->userdata('nbi'), $mhsData);

				if ( $update ) {
					echo "<script>alert('Konfirmasi Sukses')</script>";

					$sessionParticipant = [
						'nbi'				=> $this->session->userdata('nbi'),
						'nama'				=> $this->session->userdata('nama'),
						'isParticipantTps'	=> 1
					];

					$this->session->unset_userdata('tmpParticipantTps');
					$this->session->set_userdata($sessionParticipant);
					redirect('participant/dashboard','refresh');
				} else {
					echo "<script>alert('Konfirmasi Gagal')</script>";
					$this->session->unset_userdata('tmpParticipantTps');

					redirect('public/home','refresh');
				}
				
			}

		} else {
			redirect('public/home','refresh');
		}		
	}

}

/* End of file Confirmation.php */
/* Location: ./application/controllers/participant/Confirmation.php */
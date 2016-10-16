 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

		redirect('participant/dashboard','refresh');
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/participant/Home.php */
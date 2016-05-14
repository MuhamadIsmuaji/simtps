<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturer extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$data = [
			'content' 		=> 'admin/data/lecturer/lecturer_lists',
			'pagetitle' 	=> 'Data Dosen',
			'navbartitle' 	=> 'Data Dosen'
		];

		$this->load->view('template',$data);
	}

	public function processLecturer() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/data/lecturer','refresh');
		}

		$old_npp = $this->input->post('old_npp');
		$new_npp = $this->input->post('npp');
		$nama = $this->input->post('nama');
		$pwd = $this->input->post('pwd');
		$akses = $this->input->post('akses');
		$isAnyLecturer = $this->M_dosen->getDosenBynpp($new_npp)->row();	

		$lecturerData = [
			'npp'	=> $new_npp,
			'nama'	=> $nama,
			'pwd'	=> $pwd,
			'akses'	=> $akses
		];

		if ( $old_npp == null ) { //insert dari awal
			if ( $isAnyLecturer ) {
				echo json_encode(0); // npp sudah ada
			} else {
				$insertProcess = $this->M_dosen->insert($lecturerData);
				echo json_encode(1); // sukses insert
			}
		} else {
			if ( $old_npp != null && $old_npp == $new_npp ) { //update saat nbi tidak dirubah
				$updateProcess = $this->M_dosen->update($old_npp, $lecturerData); 
				echo json_encode(2); //sukses update tapi nbi tidak dirubah
			} else { //update saat nbi dirubah
				if ( $isAnyLecturer ) {
					echo json_encode(0); // npp sudah ada
				} else {
					$updateProcess = $this->M_dosen->update($old_npp, $lecturerData);
					echo json_encode(2); // sukses update tabi nbi dirubah
				} 

			}
		}
	}

	/*Datatable data dosen di admin*/
	public function lecturerListsAdmin() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/dashboard','refresh');
		}

		$list = $this->M_dosen->lecturerListsAdmin();
        $no = $this->input->post('start');
        $data = array();
        $no_cb = 1;

        foreach ($list as $lecturer) {
            $no++;
            $row = array();
            $isPembimbing = $this->M_kelompok->isPembimbing($lecturer->npp)->num_rows();

            if ( $isPembimbing > 0 || $lecturer->akses == 2 ) { // Jika dia pembimbing atau dia admin maka dia tidak bisa dihapus
				$row[] = '';				
            } else { // Jika dia bukan pembimbing maka dia bisa dihapus
				$row[] = '<input type="checkbox" id="cbLecturer'. $no_cb .'" value="'. $lecturer->npp .'" onchange="checkLecturerSelected()">';
            	$no_cb++;
            }
         	
            $row[] = $lecturer->npp;
            $row[] = $lecturer->nama;
            
            if ( $lecturer->akses == 2 ){
            	$akses = 'Dosen Pembimbing';
            	$aksi = 'Admin';

            }else if ( $lecturer->akses == 1 ){
            	$akses = 'Dosen Pembimbing';
            	$aksi = '<button class="btn btn-success" onclick="show(this)"
            				data-npp="'.$lecturer->npp.'" data-nama="'.$lecturer->nama.'" data-pwd="'.$lecturer->pwd.'" 
            				data-akses="'.$lecturer->akses.'" data-old="'.$lecturer->npp.'"
            			><span class="icon fa fa-eye fa-lg"></span>
            			</button>';
            }else{
            	$akses = 'Dosen';
            	$aksi = '<button class="btn btn-block btn-success" onclick="show(this)"
            				data-npp="'.$lecturer->npp.'" data-nama="'.$lecturer->nama.'" data-pwd="'.$lecturer->pwd.'" 
            				data-akses="'.$lecturer->akses.'" data-old="'.$lecturer->npp.'"
            			><span class="icon fa fa-eye fa-lg"></span>	
            			</button>';
            }

            $row[] = $akses;
            $row[] = $aksi;
            
            $data[] = $row;
        }
        $output = array(
            "draw"  			=> $this->input->post('draw'),
            "recordsTotal"      => $this->M_dosen->countAll(),
            "recordsFiltered"   => $this->M_dosen->countFiltered(),
            "data"              => $data,
        );

        echo json_encode($output);
	}
	/*Datatable data dosen di admin*/

	public function processDeleteLecturer() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_GET) ) {
			redirect('admin/data/lecturer','refresh');
		}

		for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $npp = $this->input->get('npp'.$i);
            $deleteProcess = $this->M_dosen->delete($npp);
        }

        if ($deleteProcess){
        	echo json_encode('Hapus Data Dosen Berhasil..');
        } else {
        	echo json_encode('Terjadi Kesalahan.. Reload Browser Anda...');
        }
	}

	public function getLecturerAutoComplete() {

		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_GET) ) {
			redirect('admin/data/lecturer','refresh');
		}

		$admin = $this->session->userdata('npp'); // supaya admin tidak bisa edit di form data dosen
		$lecturerData = $this->M_dosen->getLecturerAutoComplete( $this->input->get('term'),$admin )->result();
		

		 foreach ($lecturerData as $value) {
            $data[] = array(
                'label' => $value->npp, //suggest (wajib bernama label)
                'value' => $value->npp,//value, yang muncul di input box (wajib bernama value)
                'npp'  => $value->npp, //(opsional, jk diperlukan)
                'nama'  => $value->nama, //(opsional, jk diperlukan)
                'pwd'  => $value->pwd, //(opsional, jk diperlukan)
                'akses' => $value->akses
            );
        }

        echo json_encode($data);
	}

	public function getLecturerAutoCompleteName() {

		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_GET) ) {
			redirect('admin/data/lecturer','refresh');
		}

		$admin = $this->session->userdata('npp'); // supaya admin tidak bisa edit di form data dosen
		$lecturerData = $this->M_dosen->getLecturerAutoCompleteName( $this->input->get('term'),$admin )->result();
		

		 foreach ($lecturerData as $value) {
            $data[] = array(
                'label' => $value->npp, //suggest (wajib bernama label)
                'value' => $value->nama,//value, yang muncul di input box (wajib bernama value)
                'npp'  => $value->npp, //(opsional, jk diperlukan)
                'nama'  => $value->nama, //(opsional, jk diperlukan)
                'pwd'  => $value->pwd, //(opsional, jk diperlukan)
                'akses' => $value->akses
            );
        }

        echo json_encode($data);
	}

}

/* End of file lecturer.php */
/* Location: ./application/controllers/lecturer.php */
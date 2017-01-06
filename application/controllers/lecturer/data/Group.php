<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {

		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();

		$data = [
			'settingData'	=> $setting,
			'content' 		=> 'lecturer/data/group/group_lists',
			'pagetitle' 	=> 'Daftar Kelompok',
			'navbartitle' 	=> 'Daftar Kelompok'
		];

		$this->load->view('template',$data);
	}

    /*Datatable data kelompok berdasarkan pembimbing*/
	public function groupListsLecturer() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
            redirect('lecturer/dashboard','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $npp = $this->session->userdata('npp');
        $list = $this->M_kelompok->groupListsLecturer($setting->thn_ajaran, $setting->smt, $npp);
        $no = $this->input->post('start');
        $data = array();
        $no_cb = 1;
        foreach ($list as $group) {

        	$judul = $group->judul == NULL ? '-' : $group->judul;
        	$proposal = $group->proposal == NULL ? '-' : $group->proposal;
        	$revisi = $group->revisi == NULL ? '-' : $group->revisi;
        	$validasi = $group->validasi == 1 ? 'Disetujui' : 'Belum Disetujui'; 

        	$action = '<a href="'. 
        				base_url('lecturer/data/group/detailGroup/'.$group->thn_ajaran .'/'.$group->smt.'/'. $group->kode_kel) .'" target="_blank" class="btn btn-primary">
        				<i class="fa fa-eye fa-lg"></i>&nbsp;
        				<strong>Detail</strong>
        			</a>';

            $row = array();
            $no++;
            $row[] = $group->kode_kel;
            $row[] = $judul;
            $row[] = $validasi;
            $row[] = $action;

            $data[] = $row;
        }
        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_kelompok->countAllLecturer(),
            "recordsFiltered"   => $this->M_kelompok->countFilteredLecturer($setting->thn_ajaran, $setting->smt,$npp),
            "data"              => $data,
        );

        echo json_encode($output);


	}
    /*Datatable data kelompok berdasarkan pembimbing*/

    public function detailGroup($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
    	if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL || $kode_kel == NULL ) {
			redirect('lecturer/data/group','refresh');
		}

        $setting = $this->M_setting->getSetting()->row();

       	// jika parameter thn_ajaran dan smt tidak sesuai dengan thn_ajaran dan smt yang aktif
       	if ( $setting->thn_ajaran != $thn_ajaran || $setting->smt != $smt ) {
			redirect('lecturer/data/group','refresh');
       	}

		$group = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

		if ( $group ) { // jika group yang di maksud ada 
			if ( $group->npp != $this->session->userdata('npp') ) { // jika group tidak sesuai dopingnya
				redirect('lecturer/data/group','refresh');
			} else {
				// data anggota group
				$groupMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$group->kode_kel)->result();
				
				$data = [
					'settingData'	=> $setting,
					'dataGroup'		=> $group,
					'groupMember'	=> $groupMember,
					'content' 		=> 'lecturer/data/group/group_detail',
					'pagetitle' 	=> 'Detail Kelompok',
					'navbartitle' 	=> 'Detail Kelompok'
				];

				$this->load->view('template',$data);
			}

		} else { // jika group yang dimaksud tidak ada
			redirect('lecturer/data/group','refresh');
		}
    }

    public function groupGuidance($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL ) {
    	if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL || $kode_kel == NULL ) {
			redirect('lecturer/data/group','refresh');
		}

        $setting = $this->M_setting->getSetting()->row();

       	// jika parameter thn_ajaran dan smt tidak sesuai dengan thn_ajaran dan smt yang aktif
       	if ( $setting->thn_ajaran != $thn_ajaran || $setting->smt != $smt ) {
			redirect('lecturer/data/group','refresh');
       	}

		$group = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

		if ( $group ) { // jika group yang di maksud ada 
			if ( $group->npp != $this->session->userdata('npp') ) { // jika group tidak sesuai dopingnya
				redirect('lecturer/data/group','refresh');
			} else {
				$groupMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$group->kode_kel)->result();
				// data bimbingan group
				$guidanceData = $this->M_bimbingan->getGuidanceByKodeKel($thn_ajaran, $smt, $group->kode_kel)->result();
				$data = [
					'guidanceData'	=> $guidanceData,
					'settingData'	=> $setting,
					'dataGroup'		=> $group,
					'groupMember'	=> $groupMember,
					'content' 		=> 'lecturer/data/group/group_guidance',
					'pagetitle' 	=> 'Bimbingan Kelompok',
					'navbartitle' 	=> 'Bimbingan Kelompok'
				];

				$this->load->view('template',$data);
			}

		} else { // jika group yang dimaksud tidak ada
			redirect('lecturer/data/group','refresh');
		}
    }

    public function guidanceValidationProcess() {
    	if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}
    	
    	if ( empty($_GET) ) {
			redirect('lecturer/data/group','refresh');
		}

		$setting = $this->M_setting->getSetting()->row();
		$thn_ajaran = $this->input->get('thn_ajaran');
		$smt = $this->input->get('smt');
		$kode_kel = $this->input->get('kode_kel');

       	// jika parameter thn_ajaran dan smt tidak sesuai dengan thn_ajaran dan smt yang aktif
       	if ( $setting->thn_ajaran != $thn_ajaran || $setting->smt != $smt ) {
			redirect('lecturer/data/group','refresh');
       	}

		for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $nou_ke = $this->input->get('nou'.$i);
            $guidanceData = ['validasi' => 1];
            $updateProcess = $this->M_bimbingan->update($thn_ajaran, $smt, $kode_kel, $nou_ke, $guidanceData);
        }

        if ($updateProcess){
        	echo "<script>alert('Validasi Bimbingan Berhasil')</script>";
			redirect('lecturer/data/group/groupGuidance/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel, 'refresh');
        } else {
        	echo "<script>alert('Validasi Bimbingan Gagal')</script>";
			redirect('lecturer/data/group/groupGuidance/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel, 'refresh');
        }
    }

    // Untuk download dokumen kelompok
    // Param fileName untuk nama file
    // Param code untuk jenis file proposal / revisi proposal
    public function downloadGroupDocument($code = NULL, $fileName = NULL) {
        if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( $code == NULL || $fileName == NULL ) {
            redirect('lecturer/data/group','refresh');        
        }

        if ( $code == 1 || $code == 2 ) {
            $file_path = $code == 1 ? 'assets/files/proposal/'.$fileName : 'assets/files/revisi_proposal/'.$fileName;

            if ( file_exists($file_path) ) {
                $this->load->helper('download');
                $file = file_get_contents($file_path);
                force_download($fileName, $file);
            } else {
                //not found page
                redirect('lecturer/data/group','refresh');
            }
        } else {
            redirect('lecturer/data/group','refresh');        
        }
    }

    public function addUraian($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nou = NULL) {
        if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( $thn_ajaran == NULL || $smt == NULL || $kode_kel == NULL || $nou == NULL ) {
            redirect('public/home','refresh');
        }

        if ( !empty($_POST) ) { // jika simpan uraian disimpan

            $updateData = [
                'uraian_dosen'    => $this->input->post('uraian')
            ];

            $updateProcess = $this->M_bimbingan->update($thn_ajaran,$smt,$kode_kel,$nou,$updateData);

            if ( $updateProcess ) {
                redirect('lecturer/data/group/groupGuidance/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel,'refresh');
            } else {
                echo '<script>alert("Maaf kesalhan proses data")</script>';
                redirect('lecturer/data/group/groupGuidance/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel,'refresh');
            }

        } else {

            $filter = [
                'thn_ajaran'    => $thn_ajaran,
                'smt'           => $smt,
                'kode_kel'      => $kode_kel,
                'nou'           => $nou
            ];

            $guidanceData = $this->M_bimbingan->getGuidance($filter)->row();

            $data = [
                'content'       => 'lecturer/data/group/add_uraian',
                'guidanceData'  => $guidanceData,
                'pagetitle'     => 'Tambah Uraian Dosen',
                'navbartitle'   => 'Tambah Uraian Dosen'
            ];

            $this->load->view('template',$data);
        }
    }

    // Untuk validasi dan unvalidasi judul kelompok di dosen
    public function validateTitle() {
        if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('lecturer/data/group','refresh');
        } else {
            $thn_ajaran_validate = $this->input->post('thn_ajaran');
            $smt_validate = $this->input->post('smt');
            $kode_kel_validate = $this->input->post('kode_kel');
            $status = $this->input->post('status');

            $validateData = ['validasi' => $status];

            $validate = $this->M_kelompok->update($thn_ajaran_validate,$smt_validate,$kode_kel_validate,$validateData);
            
            if ( $validate )
                echo json_encode(1);
            else 
                echo json_encode(0);
        }
    }

}

/* End of file Group.php */
/* Location: ./application/controllers/lecturer/data/Group.php */
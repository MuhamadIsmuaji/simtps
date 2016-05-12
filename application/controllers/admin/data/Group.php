<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
       
        $data = [
            'content'       => 'admin/data/group/group_lists',
            'pagetitle'     => 'Data Kelompok',
            'navbartitle'   => 'Data Kelompok',
            'settingData'   => $setting
        ];

        $this->load->view('template',$data);	
	}

    /*Datatable data kelompok di admin*/
    public function groupListsAdmin() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/dashboard','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $list = $this->M_kelompok->groupListsAdmin($setting->thn_ajaran, $setting->smt);
        $no = $this->input->post('start');
        $data = array();
        $no_cb = 1;
        foreach ($list as $group) {
            $row = array();
            $no++;
            $action = '<button id="participant-detail" class="btn btn-primary" style="margin:0px" onclick="show(this)"
                        data-kode_kel="'. $group->kode_kel.'" data-npp= "'. $group->npp .'" data-nmdosen= "'. $group->nama .'">
                        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>&nbsp; Edit
                    </button>

                    <a href="'. base_url('admin/data/group/detailGroup/'.$group->kode_kel) .'" 
                        target="_blank" class="btn btn-success" style="margin:0px">
                        <i class="fa fa-eye fa-lg" aria-hidden="true"></i>&nbsp; Detail
                    </a>';

            $isHaveMember = $this->M_anggota->getAnggotaByKodeKel($setting->thn_ajaran, $setting->smt, $group->kode_kel)->num_rows();
            if ( $isHaveMember > 0 ) {
                $row[] = '';
            } else {
                $row[] = '<input type="checkbox" id="cbGroup'. $no_cb .'" value="'. $group->kode_kel .'" onchange="checkGroupSelected()">';
                $no_cb++;
            }
            $row[] = $group->kode_kel;
            $row[] = $group->thn_ajaran;
            $row[] = $action;
            //$row[] = $group->smt;
            $data[] = $row;
        }
        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_kelompok->countAll(),
            "recordsFiltered"   => $this->M_kelompok->countFiltered($setting->thn_ajaran, $setting->smt),
            "data"              => $data,
        );

        echo json_encode($output);
    }
    /*Datatable data kelompok di admin*/

    public function detailGroup($kode_kelompok = NULL) {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( $kode_kelompok == NULL ) {
            redirect('admin/data/group','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $thn_ajaran = $setting->thn_ajaran;
        $smt = $setting->smt;
        $kode_kel = $kode_kelompok;

        $cekGroup = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

        if ( $cekGroup ) {
            $dataMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();
            $data = [
                'content'       => 'admin/data/group/group_detail',
                'pagetitle'     => 'Detail Data Kelompok',
                'navbartitle'   => 'Detail Data Kelompok',
                'settingData'   => $setting,
                'dataGroup'     => $cekGroup,
                'dataMember'    => $dataMember
            ];

            $this->load->view('template',$data);
        } else {
            redirect('admin/data/group','refresh');
        }           
    }

    public function getParticipantAutoComplete() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('admin/data/group','refresh');
        }

        $nbinama = $this->input->get('term');
        $participantData = $this->M_mhs->getParticipantAutoCompleteInviteNBI($nbinama)->result();
        $setting = $this->M_setting->getSetting()->row();
        
        foreach ($participantData as $participant) {
            $filter = [
                'thn_ajaran' => $setting->thn_ajaran,
                'smt' => $setting->smt,
                'nbi' => $participant->nbi,
            ];

            $isHave = $this->M_anggota->getAnggota($filter)->row();

            if ( $isHave->kode_kel == '0' ) {
                $data[] = array(
                    'label' => $participant->nbi,
                    'value' => $participant->nbi,
                    'nama'  => $participant->nama
                );
            }
        }
        
        echo json_encode($data); 
    }

    // Untuk mengubah nilai huruf oleh admin
    public function changePoint() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
        } else {
            $fields = ['thn_ajaran','smt','kode_kel','nbi','nilai_huruf'];

            foreach ($fields as $field) {
                
                foreach ($_POST[$field] as $key => $value) {
                    $datanya[$key][$field] = $value;    
                }

            }
            
            // Proses update nilai huruf oleh admin
            foreach ($datanya as $participant) {
                $thn_ajaran = $participant['thn_ajaran'];
                $smt = $participant['smt'];
                $kode_kel = $participant['kode_kel'];
                $nbi = $participant['nbi'];
                $nilai_huruf = $participant['nilai_huruf'];

                $updateData = ['nilai_huruf' => $nilai_huruf];

                $updatePoint = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$updateData);

            }            

            redirect('admin/data/group/detailGroup/'.$kode_kel,'refresh');
        }

    }

    // Untuk menambah anggota kelompok oleh admin
    public function addMember() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $kode_kel_add = $this->input->post('kode_kel_add');
        $nbinya = $this->input->post('nbinya');

        $memberFilter = [
            'thn_ajaran'    => $setting->thn_ajaran,
            'smt'           => $setting->smt,
            'nbi'           => $nbinya,
            'kode_kel'      => '0'
        ];

        $findMember = $this->M_anggota->getAnggota($memberFilter)->row();

        if ( $findMember ) {
            $addData = ['kode_kel' => $kode_kel_add, 'konfirmasi' => 2];
            $addProcess = $this->M_anggota->update($setting->thn_ajaran,$setting->smt,'0',$nbinya,$addData);

            if ( $addProcess )
                $statusErrorAdd = 0; // proses add berhasil 
            else 
                $statusErrorAdd = 1; // proses add gagal 

        } else { // data peserta tidak ditemukan
            $statusErrorAdd = 1; 
        }
        //echo json_encode($kode_kel_add);
        echo json_encode($statusErrorAdd);

    }

    // Untuk menghapus anggota kelompok oleh admin
    public function deleteMemberFromGroup() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
        }

        $thn_ajaran = $this->input->post('thn_ajaran');
        $smt = $this->input->post('smt');
        $kode_kel = $this->input->post('kode_kel');
        $nbi = $this->input->post('nbi');

        $exitMember = [
            'kode_kel'      => '0',
            'konfirmasi'    => 0
        ];

        $exitProcess = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$exitMember);

        if ( $exitProcess )
            echo json_encode(1);
        else
            echo json_encode(0);

    }

    public function processGroup() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
        } else {
            $kode_kel = $this->input->post('kode_kel');
            $npp = $this->input->post('npp');
            $setting = $this->M_setting->getSetting()->row();
            $isGroup = $this->M_kelompok->getActiveGroup($setting->thn_ajaran, $setting->smt, $kode_kel)->num_rows();
            // cek dosen valid atau tidak
            $isLectuter = $this->M_dosen->getDosenActiveBynpp($npp)->num_rows();
            // Proses edit
            if ($isGroup > 0) {
                if ( $isLectuter > 0 ) { // dosen valid
                    $dataGroup = [ 'npp' => $npp ];

                    $updateProcess = $this->M_kelompok->update($setting->thn_ajaran, $setting->smt, $kode_kel, $dataGroup);

                    if ($updateProcess) // update berhasil
                        echo json_encode(1);
                    else // update gagal
                        echo json_encode(0);

                } else { // dosen tidak valid
                    echo json_encode(0);
                }
            } else { // Proses insert
                if ( $isLectuter > 0 ) { // dosen valid
                    $dataGroup = [
                        'thn_ajaran'    => $setting->thn_ajaran,
                        'smt'           => $setting->smt,  
                        'kode_kel'      => $kode_kel,
                        'npp'           => $npp,
                        'judul'         => NULL,
                        'proposal'      => NULL,
                        'revisi'        => NULL,
                        'validasi'      => 0
                    ];

                    $insertProcess = $this->M_kelompok->insert($dataGroup);

                    if ($insertProcess) // insert berhasil
                        echo json_encode(1);
                    else // insert gagal
                        echo json_encode(0);

                } else { // dosen tidak valid
                    echo json_encode(0);
                }
            }
                
        }
    }

    // Untuk autocomplete dosen dihalaman kelompok di admin
    public function getLecturerAutoComplete() {

        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('admin/data/group','refresh');
        }

        $lecturerData = $this->M_dosen->getLecturerAutoCompleteGroup($this->input->get('term'))->result();

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

    // Untuk mencari kode kelompok maksimal
    public function getMaxCode() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $max = ltrim($this->M_kelompok->getMaxCode($setting->thn_ajaran, $setting->smt), 'TPS');
        if ( $max ) {
            $max = $max + 1 ;

            $max = $max <= 9 ? '0'.$max : $max;     
        
        } else {
            $max = '01';
        }

        echo json_encode($max);
    }

    public function createManyGroup() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $countDoping = $this->M_dosen->getDosenActive()->num_rows();
        $doping = $this->M_dosen->getDosenActive()->result_array();
        $batas = $this->input->post('many') / $countDoping > 0 ? ceil($this->input->post('many') / $countDoping) : 1 ;
        $groupnya = 1;
        $pos = 0;

        // Proses pembagian dosen pembimbing
        while ( $groupnya <= $this->input->post('many') ) {

            $i = 1;
            while ( $i<= $batas && $groupnya <= $this->input->post('many')) {
                $max = ltrim($this->M_kelompok->getMaxCode($setting->thn_ajaran, $setting->smt), 'TPS');
                $kode_kel = 'TPS';

                if ( $max ) {
                    $max = $max + 1;
                    $kode_kel = $max <= 9 ? $kode_kel.'0'.$max : $kode_kel.$max;             
                } else {
                    $max = '01';
                    $kode_kel = $kode_kel.$max;
                }

                $dataGroup = [
                    'thn_ajaran'    => $setting->thn_ajaran,
                    'smt'           => $setting->smt,  
                    'kode_kel'      => $kode_kel,
                    'npp'           => $doping[$pos]['npp'],
                    'judul'         => NULL,
                    'proposal'      => NULL,
                    'revisi'        => NULL,
                    'validasi'      => 0
                ];

                $insertProcess = $this->M_kelompok->insert($dataGroup);
                $groupnya++;
                $i++;
            }
            $pos++;
        }
        // Proses pembagian dosen pembimbing

        if ($insertProcess) // insert berhasil
            echo json_encode(1);
        else // insert gagal
            echo json_encode(0);
    }

    public function processDeleteGroup() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('admin/data/group','refresh');
        }
        
        $setting = $this->M_setting->getSetting()->row();

        for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $kode_kel = $this->input->get('kode_kel'.$i);
            $deleteProcess = $this->M_kelompok->delete($setting->thn_ajaran, $setting->smt, $kode_kel); // Hapus di tb_kelompok
        }

        if ($deleteProcess) {
            echo json_encode('Hapus Data Kelompok Praktikum Berhasil..');
        } else {
            echo json_encode('Terjadi Kesalahan.. Reload Browser Anda...');
        }
    }

    public function countMakeGroup() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $numberOfGroupActive = $this->M_kelompok->getAllGroup($setting->thn_ajaran, $setting->smt)->num_rows();
        $numberOfParticipant = $this->M_anggota->getAnggotaByKodeKel($setting->thn_ajaran, $setting->smt, 0)->num_rows();

        $participantPerGroup = 3;
        $numberOfGroup = $numberOfParticipant/$participantPerGroup;
        $numberOfGroup = ceil($numberOfGroup); // Pembulatan ke atas
        
        if ($numberOfGroup == $numberOfGroupActive || $numberOfGroup < $numberOfGroupActive) {
            $numberOfGroup = 0;
        } else {
            $numberOfGroup -= $numberOfGroupActive;
        }

        echo $numberOfGroup;
    }

}

/* End of file Group.php */
/* Location: ./application/controllers/admin/data/Group.php */
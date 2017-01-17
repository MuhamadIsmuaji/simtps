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
            $action = '<button id="participant-detail" class="btn btn-primary btn-sm" style="margin:0px" onclick="show(this)"
                        data-kode_kel="'. $group->kode_kel.'" data-npp= "'. $group->npp .'" data-nmdosen= "'. $group->nama .'">
                        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>&nbsp; <strong>Edit</strong>
                    </button>

                    <a href="'. base_url('admin/data/group/detailGroup/'.$group->kode_kel) .'" 
                        target="_blank" class="btn btn-success btn-sm" style="margin:0px">
                        <i class="fa fa-eye fa-lg" aria-hidden="true"></i>&nbsp; <strong>Detail</strong>
                    </a>';

            $isHaveMember = $this->M_anggota->getAnggotaByKodeKel($setting->thn_ajaran, $setting->smt, $group->kode_kel)->num_rows();
            $isScheduledGroup = $this->M_jadwal->isScheduleGroup($setting->thn_ajaran, $setting->smt, $group->kode_kel)->num_rows();
            if ( $isHaveMember > 0 || $isScheduledGroup > 0 ) {
                $row[] = '';
            } else {
                $row[] = '<input type="checkbox" id="cbGroup'. $no_cb .'" value="'. $group->kode_kel .'" onchange="checkGroupSelected()">';
                $no_cb++;
            }
            $row[] = $group->kode_kel;
            // $next = $group->thn_ajaran+1;
            // $thn_ajaran = $group->thn_ajaran.' / '.$next;
            $row[] = $group->nama;
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

    // Untuk detail kelompok di halaman admin
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
        $bimbingan = $this->M_bimbingan->getGuidanceByKodeKel($thn_ajaran,$smt,$kode_kel)->result();

        $cekGroup = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

        if ( $cekGroup ) {
            // $dataMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();

            // foreach($dataMember as $par) :
            //     $this->generateNilaiAkhir($par->thn_ajaran,$par->smt,$par->kode_kel,$par->nbi);
            //     $this->generateNilaiHuruf($par->thn_ajaran,$par->smt,$par->kode_kel,$par->nbi);
            // endforeach;

            $dataMemberUpdated = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();

            $data = [
                'content'       => 'admin/data/group/group_detail',
                'pagetitle'     => 'Detail Data Kelompok',
                'navbartitle'   => 'Detail Data Kelompok',
                'settingData'   => $setting,
                'dataGroup'     => $cekGroup,
                'dataMember'    => $dataMemberUpdated,
                'bimbingan'     => $bimbingan
            ];

            $this->load->view('template',$data);
        } else {
            redirect('admin/data/group','refresh');
        }           
    }

    // Untuk validasi dan unvalidasi judul kelompok di admin
    public function validateTitle() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/group','refresh');
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

    // Untuk download dokumen kelompok
    // Param fileName untuk nama file
    // Param code untuk jenis file proposal / revisi proposal
    public function downloadGroupDocument($code = NULL, $fileName = NULL) {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( $code == NULL || $fileName == NULL ) {
            redirect('admin/data/group','refresh');        
        }

        if ( $code == 1 || $code == 2 ) {
            $file_path = $code == 1 ? 'assets/files/proposal/'.$fileName : 'assets/files/revisi_proposal/'.$fileName;

            if ( file_exists($file_path) ) {
                $this->load->helper('download');
                $file = file_get_contents($file_path);
                force_download($fileName, $file);
            } else {
                //not found page
                redirect('admin/data/group','refresh');
            }
        } else {
            redirect('admin/data/group','refresh');        
        }
    }

    // Untuk autocomplete peserta di admin
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

            if ($_POST['n_point'] == '0') :
                redirect('admin/data/group');         
            endif;
            

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

                    // ketika pembimbing kelompok diganti, jadwal sidang kelompok harus di hapus
                    $deleteScheduledGroup = $this->M_jadwal->deleteByKel($setting->thn_ajaran, $setting->smt, $kode_kel);

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
        $max = $this->generateGroupCode($setting->thn_ajaran, $setting->smt);
        // $max = ltrim($this->M_kelompok->getMaxCode($setting->thn_ajaran, $setting->smt), 'TPS');
        // if ( $max ) {
        //     $max = $max + 1 ;

        //     $max = $max <= 9 ? '0'.$max : $max;     
        
        // } else {
        //     $max = '01';
        // }

        echo json_encode($max);
    }

    private function generateGroupCode($thn_ajaran, $smt) {
    
        $maxId = $this->M_kelompok->getMaxCode($thn_ajaran, $smt)[0]->maxColumns;

        if ($maxId != NULL) {
            $nextId = $maxId + 1;
            $newId = $nextId <= 9 ? 'TPS0'. $nextId : 'TPS'. $nextId;
        } else {
            $newId = 'TPS01';
        }
        
        return $newId;
    
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
                // $max = ltrim($this->M_kelompok->getMaxCode($setting->thn_ajaran, $setting->smt), 'TPS');
                // $kode_kel = 'TPS';
                $kode_kel = $this->generateGroupCode($setting->thn_ajaran, $setting->smt);

                // if ( $max ) {
                //     $max = $max + 1;
                //     $kode_kel = $max <= 9 ? $kode_kel.'0'.$max : $kode_kel.$max;             
                // } else {
                //     $max = '01';
                //     $kode_kel = $kode_kel.$max;
                // }

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

    // Proses generate nilai akhir
    private function generateNilaiAkhir($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nbi = NULL) {
        if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $dataFilter = [
            'thn_ajaran'    => $thn_ajaran,
            'smt'           => $smt,
            'kode_kel'      => $kode_kel,
            'nbi'           => $nbi
        ];

        $dataAnggota = $this->M_anggota->getAnggota($dataFilter)->row();

        if ( $dataAnggota ) {
            
            $setting = $this->M_setting->getSetting()->row();

            // Bobot masing masing nilai
            $bobot_bimbingan = $setting->bobot_bimbingan;
            $bobot_moderator = $setting->bobot_moderator;
            $bobot_penguji1 = $setting->bobot_penguji1;
            $bobot_penguji2 = $setting->bobot_penguji2;
            $kom_a = $setting->kom_a;
            $kom_b = $setting->kom_b;
            $kom_c = $setting->kom_c;
            $kom_d = $setting->kom_d;
            // Bobot masing masing nilai

            // nilai bimbingan
            $bimb = ( $bobot_bimbingan/100 ) * $dataAnggota->nilai_bimb;
            // nilai bimbingan

            // nilai moderator
            $kom_a_mod = ( $kom_a/100 ) * $dataAnggota->nilai_11;
            $kom_b_mod = ( $kom_b/100 ) * $dataAnggota->nilai_12;
            $kom_c_mod = ( $kom_c/100 ) * $dataAnggota->nilai_13;
            $kom_d_mod = ( $kom_d/100 ) * $dataAnggota->nilai_14;

            $tot_mod = ( $kom_a_mod + $kom_b_mod + $kom_c_mod + $kom_d_mod ) * ( $bobot_moderator/100 );
            // nilai moderator
            
            // nilai penguji 1
            $kom_a_p1 = ( $kom_a/100 ) * $dataAnggota->nilai_21;
            $kom_b_p1 = ( $kom_b/100 ) * $dataAnggota->nilai_22;
            $kom_c_p1 = ( $kom_c/100 ) * $dataAnggota->nilai_23;
            $kom_d_p1 = ( $kom_d/100 ) * $dataAnggota->nilai_24;

            $tot_p1 = ( $kom_a_p1 + $kom_b_p1 + $kom_c_p1 + $kom_d_p1 ) * ( $bobot_penguji1/100 );
            // nilai penguji 1
             
            // nilai penguji 2
            $kom_a_p2 = ( $kom_a/100 ) * $dataAnggota->nilai_31;
            $kom_b_p2 = ( $kom_b/100 ) * $dataAnggota->nilai_32;
            $kom_c_p2 = ( $kom_c/100 ) * $dataAnggota->nilai_33;
            $kom_d_p2 = ( $kom_d/100 ) * $dataAnggota->nilai_34;

            $tot_p2 = ( $kom_a_p2 + $kom_b_p2 + $kom_c_p2 + $kom_d_p2 ) * ( $bobot_penguji2/100 );
            // nilai penguji 2

            // Perhitungan nilai kahir
            $totalNilai = $bimb + $tot_mod + $tot_p1 + $tot_p2;
            // Perhitungan nilai kahir
            
            $dataUpdate = ['nilai_akhir' => $totalNilai];
            $updateNilaiAkhir = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$dataUpdate);

            if ( $updateNilaiAkhir ) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    // Proses generate nilai huruf
    private function generateNilaiHuruf($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nbi = NULL) {
        if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $dataFilter = [
            'thn_ajaran'    => $thn_ajaran,
            'smt'           => $smt,
            'kode_kel'      => $kode_kel,
            'nbi'           => $nbi
        ];

        $dataAnggota = $this->M_anggota->getAnggota($dataFilter)->row();

        if ( $dataAnggota ) {

            // Perhitungan Nilai Huruf
            if ( $dataAnggota->nilai_akhir > 85 )
                $nilaiHuruf = 'A';
            else if ( $dataAnggota->nilai_akhir > 80 && $dataAnggota->nilai_akhir <= 85 )
                $nilaiHuruf = 'A-';
            else if ( $dataAnggota->nilai_akhir > 75 && $dataAnggota->nilai_akhir <= 80 )
                $nilaiHuruf = 'AB';
            else if ( $dataAnggota->nilai_akhir > 70 && $dataAnggota->nilai_akhir <= 75 )
                $nilaiHuruf = 'B+';
            else if ( $dataAnggota->nilai_akhir > 65 && $dataAnggota->nilai_akhir <= 70 )
                $nilaiHuruf = 'B';
            else if ( $dataAnggota->nilai_akhir > 60 && $dataAnggota->nilai_akhir <= 65 )
                $nilaiHuruf = 'B-';
            else if ( $dataAnggota->nilai_akhir > 55 && $dataAnggota->nilai_akhir <= 60 )
                $nilaiHuruf = 'BC';
            else if ( $dataAnggota->nilai_akhir > 50 && $dataAnggota->nilai_akhir <= 55 )
                $nilaiHuruf = 'C+';
            else if ( $dataAnggota->nilai_akhir > 45 && $dataAnggota->nilai_akhir <= 50 )
                $nilaiHuruf = 'C';
            else if ( $dataAnggota->nilai_akhir > 40 && $dataAnggota->nilai_akhir <= 45 )
                $nilaiHuruf = 'C-';
            else if ( $dataAnggota->nilai_akhir > 35 && $dataAnggota->nilai_akhir <= 40 )
                $nilaiHuruf = 'CD';
            else if ( $dataAnggota->nilai_akhir > 30 && $dataAnggota->nilai_akhir <= 35 )
                $nilaiHuruf = 'D';
            else if ( $dataAnggota->nilai_akhir >= 0 && $dataAnggota->nilai_akhir <=30 )
                $nilaiHuruf = 'E';
            else
                $nilaiHuruf = 'F';
            // Perhitungan Nilai Huruf

            $dataUpdate = ['nilai_huruf' => $nilaiHuruf];
            $updateHuruf = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$dataUpdate);

            if ( $updateHuruf ) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

}

/* End of file Group.php */
/* Location: ./application/controllers/admin/data/Group.php */
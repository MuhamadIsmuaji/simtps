 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		
		if ( ! $this->session->userdata('isParticipantTps') ) {
			redirect('public/home','refresh');
		}

        $setting = $this->M_setting->getSetting()->row();
        $thn_ajaran = $setting->thn_ajaran;
        $smt = $setting->smt;
        $nbi = $this->session->userdata('nbi');

   		$participant = $this->M_anggota->getAnggotaByPeriode($setting->thn_ajaran, $setting->smt, $nbi)->row();

        if ( $participant->kode_kel != '0' && $participant->konfirmasi == 1 ) {
        	// mhs memiliki request gabung di suatu kelompok
            redirect('participant/request','refresh');
        } else {

        	if ( $participant->kode_kel == '0' && $participant->konfirmasi == 0 ) {
        		// mhs belum memiliki anggota kelompok
        		$data = [
					'content' 		=> 'participant/group_lists',
                    'settingData'   => $setting,
					'pesan'			=> 'Halaman Home Peserta',
					'pagetitle' 	=> 'Dashboard Peserta',
					'navbartitle' 	=> 'Dashboard Peserta'
				];

				$this->load->view('template',$data);

        	} else if ( $participant->kode_kel != '0' && $participant->konfirmasi == 2 )  {
        		// mhs sudah memiliki anggota kelompok
        		$kode_kel = $participant->kode_kel;
        		$kelompok = $this->M_kelompok->getGroupByCodeJoinLecturer($thn_ajaran, $smt, $kode_kel)->row();
                
                $banyak = $this->M_anggota->getAnggotaByKodeKel($thn_ajaran,$smt,$kelompok->kode_kel)->num_rows();

                $dataMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();

        		$data = [
        			'settingData'	=> $setting,
        			'kode_kel'		=> $kode_kel,
        			'kelompok'		=> $kelompok,
                    'dataMember'    => $dataMember,
                    'banyak'        => $banyak,
					'content' 		=> 'participant/detail_group',
					'pesan'			=> 'Halaman Home Peserta',
					'pagetitle' 	=> 'Dashboard Peserta',
					'navbartitle' 	=> 'Dashboard Peserta'
				];

				$this->load->view('template',$data);

        	} else { 
        		//do nothing 
        	}
        }
	}

    public function groupListsParticipant() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/dashboard','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $now = date('Y-m-d');
        $list = $this->M_kelompok->groupListsParticipant($setting->thn_ajaran, $setting->smt);
        $no = $this->input->post('start');
        $data = array();

        foreach ($list as $group) {
            $no++;
            $row = array();

            if ( $setting->bts_kelompok >= $now ) {
                $join = '<button class="btn btn-primary" onclick="showModalDetailGroup(this)" 
                            data-kode_kel="'. $group->kode_kel .'" data-thn_ajaran="'. $group->thn_ajaran .'"
                            data-smt="'. $group->smt .'" >
                            <span class="icon fa fa-eye"></span>
                        </button>';;
            } else {

                $isHaveMember = $this->M_anggota->getAnggotaByKodeKel($setting->thn_ajaran, $setting->smt, $group->kode_kel)->num_rows();
                
                if ($isHaveMember == 3) {
                    $join = 'Kelompok Penuh';                
                } else {
                    $join = '-';                
                }

            }


            $row[] = $group->kode_kel;
            $row[] = $group->nama;
            $row[] = $join;
            $data[] = $row;
        }

        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_kelompok->countAllParticipant(),
            "recordsFiltered"   => $this->M_kelompok->countFilteredParticipant($setting->thn_ajaran, $setting->smt),
            "data"              => $data,
        );

        echo json_encode($output);
    }

    public function getDetailGroup() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/dashboard','refresh');
        }
        
        $kode_kel = $this->input->post('kode_kel');
        $thn_ajaran = $this->input->post('thn_ajaran'); 
        $smt = $this->input->post('smt');

        $dataKelompok = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();
        $dataDoping = $this->M_dosen->getDosenBynpp($dataKelompok->npp)->row();
        $dataMember = $this->M_anggota->getAnggotaByKodeKelJoinMhs($thn_ajaran,$smt,$kode_kel)->result();

        $data = [
            'dataDoping'    => $dataDoping->nama,
            'dataMember'    => $dataMember
        ];

        echo json_encode($data);
    }

    public function registeringOnGroup() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/dashboard','refresh');
        }

        $kode_kel = $this->input->post('kode_kel');
        $thn_ajaran = $this->input->post('thn_ajaran'); 
        $smt = $this->input->post('smt');
        $nbi = $this->input->post('nbi');

        $banyak = $this->M_anggota->getAnggotaByKodeKel($thn_ajaran,$smt,$kode_kel)->num_rows();

        if ( $banyak < 3 ) { // jika anggota < 3 maka bisa join group
            $updateAnggota = ['kode_kel' => $kode_kel, 'konfirmasi' => 2];

            $updateProcess = $this->M_anggota->update($thn_ajaran,$smt,'0',$nbi,$updateAnggota);

            if ( $updateProcess )
                $gagal = 0; // proses gabung berhasil
            else
                $gagal = 2; // proses gabung gagal

        } else { // jika anggota => 3 tdk bisa join group
            $gagal = 1; // proses gabung gagal karena group sudah penuh
        }

        echo json_encode($gagal);
    }

    public function exitGroup() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/dashboard','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $now = date('Y-m-d');
        $kode_kel = $this->input->post('kode_kel');
        $thn_ajaran = $this->input->post('thn_ajaran'); 
        $smt = $this->input->post('smt');
        $nbi = $this->input->post('nbi');

        if ( $setting->bts_kelompok >= $now ) { // jika batas waktu masih ada
            $updateAnggota = ['kode_kel' => '0', 'konfirmasi' => 0];
            $updateProcess = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$updateAnggota);

            if ( $updateProcess ) 
                $errorStatus = 0; // keluar kelompok sukses 
            else 
                $errorStatus = 2; // keluar kelompok gagal ketika proses update

        } else { // bts waktu pilih kelompok sudah habis
            $errorStatus = 1;
        }

        echo json_encode($errorStatus);
    }

    public function getParticipantAutoCompleteInviteNBI() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('participant/dashboard','refresh');
        }
        
        $nbi = $this->input->get('term'); 
        $participantData = $this->M_mhs->getParticipantAutoCompleteInviteNBI($nbi)->result();
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

    public function inviteMember() {
        if ( ! $this->session->userdata('isParticipantTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('participant/dashboard','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();
        $nbijoin = $this->input->post('nbijoin');
        $kode_kel = $this->input->post('kode_kel');

        $memberFilter = [
            'thn_ajaran'    => $setting->thn_ajaran,
            'smt'           => $setting->smt,
            'nbi'           => $nbijoin,
            'kode_kel'      => '0'
        ];

        $findMember = $this->M_anggota->getAnggota($memberFilter)->row();

        if ( $findMember ) {
            $inviteData = ['kode_kel' => $kode_kel, 'konfirmasi' => 1];
            $inviteProcess = $this->M_anggota->update($setting->thn_ajaran,$setting->smt,'0',$nbijoin,$inviteData);

            if ( $inviteProcess )
                $statusErrorInvite = 0; // proses invite berhasil 
            else 
                $statusErrorInvite = 1; // proses invite gagal 

        } else { // data peserta tidak ditemukan
            $statusErrorInvite = 1; 
        }
        
        echo json_encode($statusErrorInvite);
    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/participant/Dashboard.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participant extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
	   if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }
    
        $setting = $this->M_setting->getSetting()->row();
        
        $data = [
            'content'       => 'admin/data/participant/participant_lists',
            'pagetitle'     => 'Data Peserta',
            'navbartitle'   => 'Data Peserta',
            'settingData'   => $setting
        ];

        $this->load->view('template',$data);	
	}

    public function countParticipant() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $setting = $this->M_setting->getSetting()->row();

        echo json_encode($this->M_anggota->countParticipant($setting->thn_ajaran, $setting->smt)->num_rows());   
    }

    public function participantListsAdmin() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/participant','refresh');
        }
        
        $setting = $this->M_setting->getSetting()->row();
        
        $list = $this->M_anggota->participantListsAdmin($setting->thn_ajaran, $setting->smt);
        $no = $this->input->post('start');
        $data = array();
        $no_cb = 1;

        foreach ($list as $participant) {
            $cb = '<input type="checkbox" id="cbParticipant'. $no_cb .'" value="'. $participant->nbi .'" onchange="checkParticipantSelected()">';
            $no_cb++;

            $akses = $participant->akses == 1 || $participant->akses == 9 ? 'Aktif' : 'Non Aktif';
            $kelompok = $participant->kode_kel == '0' ? 'Belum Memiliki Kelompok' : $participant->kode_kel;
            // $participantDetail = '<button id="participant-detail" class="btn btn-success btn-sm btn-detail" style="margin:0px"><i class="fa fa-certificate fa-lg"></i></button>';
            $action = '<button id="participant-detail" class="btn btn-primary btn-sm " style="margin:0px" onclick="show(this)"
                        data-nbi="'. $participant->nbi.'" data-old_nbi="'. $participant->nbi.'" data-email="'. $participant->email.'"
                        data-nama="'. $participant->nama.'" data-pwd="'. $participant->pwd.'" data-akses="'. $participant->akses.'" 
                        >
                        <i class="fa fa-pencil fa-lg"></i>
            </button>';

            $no++;
            $row = array();

            $row[] = $cb;
            $kode_kel = $participant->kode_kel == '0' ? 'Belum Memiliki Kelompok' : $participant->kode_kel; 
            $row[] = $kode_kel;
            $row[] = $participant->nbi;
            $row[] = $participant->nama;
            $row[] = $akses;
            $row[] = $action;
            $row[] = $kelompok;
            $row[] = $participant->nilai_huruf;
            $data[] = $row;
        }
        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_anggota->countAll(),
            "recordsFiltered"   => $this->M_anggota->countFiltered($setting->thn_ajaran, $setting->smt),
            "data"              => $data,
        );

        echo json_encode($output);
    }

    public function processParticipant() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) { // Jika tidak ada proses submit di form
            redirect('admin/data/participant','refresh');
        } else {
            $setting = $this->M_setting->getSetting()->row();
            $new_nbi = $this->input->post('nbi');
            $old_nbi = $this->input->post('old_nbi');
            $nama = $this->input->post('nama');
            $pwd = $this->input->post('pwd');
            //$pwd_baru = $this->generateStrongPassword();
            $email = $this->input->post('email');
            
            $isMhs = $this->M_mhs->getMhsByNbi($new_nbi)->row();

            if ( $old_nbi == NULL ) { // Jika create peserta dari awal
                if ( $isMhs ) { // Jika mhs sudah ada di tb_mhs
                    if ( $isMhs->akses == 1 || $isMhs->akses == 9 ) {
                        echo json_encode(0); // Mhs sudah aktif pada periode yang sedang aktif (gagal)
                    } else {
                        $mhs = $this->M_mhs->getMhsByNbi($new_nbi)->row();
                        $updateMhs = $this->updateMhs($new_nbi, $new_nbi, $nama, $new_nbi, NULL, 9); // update tb_mhs ke akses aktif
                        $insertAnggota = $this->insertAnggota($setting->thn_ajaran, $setting->smt, $new_nbi); // insert ke tb_anggota
                        echo json_encode(1); // sukses
                    }
                } else { // Jika mhs belum ada di tb_mhs
                    $insertMhs = $this->insertMhs($new_nbi, $nama, $new_nbi, NULL,9); // insert ke tb_mhs
                    $insertAnggota = $this->insertAnggota($setting->thn_ajaran, $setting->smt, $new_nbi); // insert ke tb_anggota
                    echo json_encode(1); // sukses
                }
            } else { // Jika edit peserta dari tabel
                if ( $old_nbi != NULL && $old_nbi == $new_nbi ) { // Jika nbi tidak dirubah
                    $mhs = $this->M_mhs->getMhsByNbi($old_nbi)->row();

                    if ( $mhs->akses == 1 )
                        $updateMhs = $this->updateMhs($old_nbi, $new_nbi, $nama, $pwd, $email, 1); // update tb_mhs
                    else
                        $updateMhs = $this->updateMhs($old_nbi, $new_nbi, $nama, $pwd, $email, 9); // update tb_mhs

                    echo json_encode(1); // sukses
                } else {
                    if ( $isMhs ) {  // Jika nbi yang dimasukkan masih aktif
                       if ( $isMhs->akses == 1 || $isMhs->akses == 9 ) {
                            echo json_encode(0); // Nbi sama dengan nbi mhs yang sudah aktif di tb_mhs (gagal)
                       } else {
                            $deleteAnggota = $this->deleteAnggota($setting->thn_ajaran, $setting->smt, $old_nbi); // delete data di tb_anggota dengan old_nbi
                            $insertAnggota = $this->insertAnggota($setting->thn_ajaran, $setting->smt, $new_nbi); // insert data di tb_anggota dengan new nbi
                            $mhs = $this->M_mhs->getMhsByNbi($old_nbi)->row();
                            $updateMhs1 = $this->updateMhs($old_nbi, $mhs->nbi, $mhs->nama, $mhs->pwd, $mhs->email,0); // update data mhs sebelumnya di tb_mhs menjadi non-aktif
                            
                            $updateMhs = $this->updateMhs($new_nbi, $new_nbi, $nama, $pwd, $email,9); // update data di tb_mhs menjadi aktif
                            echo json_encode(1); // Update data mhs yang belum aktif di tb_mhs
                       }
                    } else {
                        $mhs = $this->M_mhs->getMhsByNbi($old_nbi)->row();
                        $updateMhs1 = $this->updateMhs($old_nbi, $mhs->nbi, $mhs->nama, $mhs->pwd, $mhs->email,0); // update data mhs sebelumnya di tb_mhs menjadi non-aktif
                        $deleteAnggota = $this->deleteAnggota($setting->thn_ajaran, $setting->smt, $old_nbi); // delete data di tb_anggota dengan old_nbi
                        
                        $insertMhs = $this->insertMhs($new_nbi, $nama, $new_nbi, NULL,9); // insert ke tb_mhs karena mhs belum ada
                        $insertAnggota = $this->insertAnggota($setting->thn_ajaran, $setting->smt, $new_nbi); // insert data di tb_anggota dengan new nbi
                        echo json_encode(1); // update data mhs di tb_mhs dengan new nbi    
                    }
                }
            }
        }
    }

    public function processDeleteParticipant() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_GET) ) {
            redirect('admin/data/participant','refresh');
        }
        
        $setting = $this->M_setting->getSetting()->row();

        for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $nbi = $this->input->get('nbi'.$i);
            $deleteProcess = $this->M_anggota->delete($setting->thn_ajaran, $setting->smt, $nbi); // Hapus di tb_anggota

            $dataUpdate = ['akses' => 0];
            $updateToInActive = $this->M_mhs->update($nbi, $dataUpdate); // update mhs supaya non aktif
        }

        if ($deleteProcess && $updateToInActive) {
            echo json_encode('Hapus Data Peserta Berhasil..');
        } else {
            echo json_encode('Terjadi Kesalahan.. Reload Browser Anda...');
        }
    }

    private function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'ld') {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    private function deleteAnggota($thn_ajaran = NULL, $smt = NULL, $nbi = NULL) {
        $deleteProcess = $this->M_anggota->delete($thn_ajaran, $smt, $nbi);
        return $deleteProcess;
    }

    private function updateMhs($old_nbi = NULL, $new_nbi = NULL, $nama = NULL, $pwd = NULL, $email = NULL, $akses = NULL) {
        $updateData = [
            'nbi'       => $new_nbi,
            'nama'      => $nama,
            'pwd'       => $pwd,
            'email'     => $email,
            'akses'     => $akses
        ];

        $updateProcess = $this->M_mhs->update($old_nbi,$updateData);

        return $updateProcess; 
    }

    private function insertMhs($new_nbi = NULL, $nama = NULL, $pwd = NULL, $email = NULL, $akses = NULL) {
        $insertData = [
            'nbi'       => $new_nbi,
            'nama'      => $nama,
            'pwd'       => $pwd,
            'email'     => $email,
            'akses'     => $akses
        ];

        $insertProcess = $this->M_mhs->insert($insertData);

        return $insertProcess; 
    }

    private function insertAnggota($thn_ajaran = NULL, $smt = NULL, $new_nbi = NULL) {
        $insertData = [
            'thn_ajaran' => $thn_ajaran,
            'smt'        => $smt,
            'nbi'        => $new_nbi
        ];

        $insertProcess = $this->M_anggota->insert($insertData);

        return $insertProcess; 
    }

    public function importParticipant() {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        if ( empty($_POST) ) {
            redirect('admin/data/participant','refresh');
        }

        $config['upload_path']          = './assets/files/import/';
        $config['allowed_types']        = 'xls|xlsx';
        $config['max_size']             = 5000; //5 MB
        $config['remove_spaces']        = TRUE;
        $config['file_ext_tolower']     = TRUE;
        $config['overwrite']            = false;
        $this->load->library('upload', $config);

        // File excel diupload terlebih dahulu ke server
        if ( !$this->upload->do_upload('excel_participant') ) { // Jika terjadi kegagalan upload file excel
            echo "<script>alert('Pastikan file sesuai dengan ketentuan')</script>";
            redirect('admin/data/participant','refresh');
        } else { // Upload file sesuai
            $excelFile = './assets/files/import/'. $this->upload->data('file_name');
            // echo "<script>alert('". $excelFile ."')</script>";
            // redirect('admin/data/participant','refresh');
            $this->load->library('Excel/PHPExcel');

            // Pembacaan excel
            try {
                $inputFileType = PHPExcel_IOFactory::identify($excelFile);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($excelFile);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($excelFile,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            // Pembacaan excel

            // Mendapatkan dimensi pada excel
            $sheet = $objPHPExcel->getSheet(0); // Sheet
            $highestRow = $sheet->getHighestRow(); // Baris tertinggi
            $highestColumn = $sheet->getHighestColumn(); // Kolom tertinggi
            // Mendapatkan dimensi pada excel

            $setting = $this->M_setting->getSetting()->row();

            // Perulangan untuk memasukkan data tiap baris
            // Dibuat row = 2 karena data dimulai baris ke dua
            for ($row = 2; $row <= $highestRow; $row++) {          
                
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );

                $isParticipant = $this->M_anggota->getAnggotaByPeriode($setting->thn_ajaran, $setting->smt, $rowData[0][1])->row();

                if ( !$isParticipant ) { // Jika peserta belum ada pada periode yang sedang aktif
                    $isMhs = $this->M_mhs->getMhsByNbi($rowData[0][1])->row();

                    // Proses di tb_mhs
                    if ( $isMhs ) { // Jika mhs sudah ada di master tb_mhs
                        // update data mhs yang ada
                        $this->updateMhs($isMhs->nbi, $rowData[0][1], $rowData[0][2], $rowData[0][1], NULL, 9);

                    } else { // Jika mhs belum ada di master tb_mhs
                        // insert data mhs baru
                        $this->insertMhs($rowData[0][1], $rowData[0][2], $rowData[0][1], NULL, 9);

                    }
                    // Proses di tb_mhs

                    // Proses di tb_anggota
                    $this->insertAnggota($setting->thn_ajaran, $setting->smt, $rowData[0][1]);                    
                    // Proses di tb_anggota

                } else {
                    // Jika peserta sudah ada pada periode yang sedang aktif
                    // Tidak dilakukan proses pemasukkan data dari excel
                }
            }
            // Perulangan untuk memasukkan data tiap baris

            unlink($excelFile);
            redirect('admin/data/participant','refresh');
     
        }
    }

	public function cobaEmail() {
	

		$this->load->view('coba_email/form');
	}

	public function kirimEmail() {
			$pesannya = $this->input->post('pesan');
			$data['pesan'] = $this->input->post('pesan');
			$email = 'muhamadismuaji@gmail.com';
			$data['layout'] = 'isi';
            //$data['layout'] = 'mail_reset_pass_view';
            //$data['link'] = 'umum/reset_password';
            $data['title'] = 'coba email';
            $this->load->view('coba_email/message_email', $data, true);
            $mailView = $this->load->view('coba_email/message_email', $data, true);

            require_once APPPATH . 'third_party/mandrill/src/Mandrill.php';            
                try {
                    $mandrill = new \Mandrill(MANDRILLKEY);
                 
                    // Mail it
                    $message = array(
                        'html' => $mailView,
                        'subject' => 'Percobaan SIM TPS',
                        'from_email' => HELPMAIL,
                        'from_name' => HELPNAME,
                        'to' => array(
                            array(
                                'email' => $email,
                                'type' => 'to'
                            )
                        ),
                        'headers' => array('Reply-To' => 'email'),
                        'preserve_recipients' => true
                    );
                    $result = $mandrill->messages->send($message, false, null, null);
                   	echo "sukses";
                } catch (\Mandrill_Error $ex) {
                    echo 'A mandrill error occurred: ' . get_class($ex) . ' - ' . $ex->getMessage();
                }
	}


}

/* End of file Participant.php */
/* Location: ./application/controllers/admin/data/Participant.php */
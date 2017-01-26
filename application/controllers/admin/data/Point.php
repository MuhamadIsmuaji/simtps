<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0); // limit waktu eksekusi

class Point extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

        $setting = $this->M_setting->getSetting()->row();
        $distinct = $this->M_setting->getTahunAjaran()->result_array();
        $minThnAjaran = $distinct[0]['thn_ajaran'];
        $maxThnAjaran = $distinct[count($distinct)-1] ['thn_ajaran'];

		$data = [
            'content'       		=> 'admin/data/point/point_lists',
            'pagetitle'     		=> 'Daftar Nilai',
            'navbartitle'   		=> 'Daftar Nilai',
            'current_thn_ajaran'	=> $setting->thn_ajaran,
            'current_smt'			=> $setting->smt,
            'minThnAjaran'			=> $minThnAjaran,
            'maxThnAjaran'			=> $maxThnAjaran
        ];

        $this->load->view('template',$data);		

	}

	public function pointListAdmin($thn_ajaran = NULL, $smt = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
            redirect('admin/data/point','refresh');
        }

        $list = $this->M_anggota->participantListsAdmin($thn_ajaran, $smt);
        $no = $this->input->post('start');
        $data = array();

        foreach ($list as $participant) {

            $no++;
            $row = array();

            if ($participant->kode_kel != '0') :
                 $arrKeterangan = [];

                $arrNilaiBimb = [
                    $participant->nilai_bimb, 
                ];

                $arrNilaiMod = [
                    $participant->nilai_11, $participant->nilai_12, $participant->nilai_13, $participant->nilai_14,
                ];

                $arrNilaiP1 = [
                    $participant->nilai_21, $participant->nilai_22, $participant->nilai_23, $participant->nilai_24,
                ];

                $arrNilaiP2 = [
                    $participant->nilai_31, $participant->nilai_32, $participant->nilai_33, $participant->nilai_34,
                ];

                if (in_array(0, $arrNilaiBimb)) :
                    $arrKeterangan[] = 'Bimbingan';
                endif;

                if (in_array(0, $arrNilaiMod)) :
                    $arrKeterangan[] = 'Moderator';
                endif;

                if (in_array(0, $arrNilaiP1)) :
                    $arrKeterangan[] = 'Penguji 1';
                endif;

                if (in_array(0, $arrNilaiP2)) :
                    $arrKeterangan[] = 'Penguji 2';
                endif;

                
                if (count($arrKeterangan) > 0) :
                    $keterangan = 'Nilai : ';
                    
                    for($i=0; $i<count($arrKeterangan);$i++) :
                        if ($i==count($arrKeterangan)-1) :
                            $keterangan = $keterangan.$arrKeterangan[$i];
                        else :
                            $keterangan = $keterangan.$arrKeterangan[$i].', ';
                        endif;
                    endfor;

                    $keterangan = $keterangan.' ada yang belum diisi.';
                else :
                    $keterangan = '-';
                endif;
            else :
                $keterangan = 'Belum Memilih Kelompok';
            endif;

            $row[] = '<p class="text-center">'.$participant->nbi.'</p>';
            $row[] = $participant->nama;
            $row[] = '<p class="text-center">'.$participant->nilai_huruf.'</p>';
            $row[] = $keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $this->M_anggota->countAll(),
            "recordsFiltered"   => $this->M_anggota->countFiltered($thn_ajaran, $smt),
            "data"              => $data,
        );

        echo json_encode($output);
	} 

	public function printPointList($thn_ajaran = NULL, $smt = NULL) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $thn_ajaran == NULL || $smt == NULL) {
            redirect('admin/data/point','refresh');
        }

        $pointList = $this->M_anggota->getAnggotaPeriodePointPrint($thn_ajaran, $smt)->result();
        $setting = $this->M_setting->getSetting()->row();
        $when = $this->generateIndoTime(date('Y-m-d'));
        $next = $thn_ajaran+1;
        $smt = $smt == 1 ? 'Ganjil' : 'Genap';

        // load dompdf
        $this->load->helper('dompdf');
        //load content html
        $data = [
            'pointList'     => $pointList,
            'thn_ajaran'    => $thn_ajaran,
            'smt'           => $smt,
            'next'          => $next,
            'when'          => $when,
            'settingData'   => $setting
        ];

        $html = $this->load->view('admin/data/point/point_print',$data,true);
        // create pdf using dompdf
        
        $filename = 'Daftar Nilai Tugas Perancangan Sistem TA '.$thn_ajaran.'-'.$next.' Semester '.$smt;
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create_point($html, $filename, $paper, $orientation);

	}


    // Untuk generate waktu indonesia waktu cetak daftar nilai
    private function generateIndoTime($date) {
        if ( !$this->session->userdata('isAdminTps') ) {
            redirect('public/home','refresh');
        }

        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
     
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);
     
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;     
        return($result);
    }

}

/* End of file Point.php */
/* Location: ./application/controllers/admin/data/Point.php */
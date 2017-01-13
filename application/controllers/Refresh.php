<?php

set_time_limit(0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function refreshNilai() {
		$setting = $this->M_setting->getSetting()->row();
        $thn_ajaran = $setting->thn_ajaran;
        $smt = $setting->smt;

		$dataMember = $this->M_anggota->getAnggotaPeriode($thn_ajaran,$smt)->result();

        foreach($dataMember as $par) :
            $this->generateNilaiAkhir($par->thn_ajaran,$par->smt,$par->kode_kel,$par->nbi);
            $this->generateNilaiHuruf($par->thn_ajaran,$par->smt,$par->kode_kel,$par->nbi);
			// set_time_limit(5);

        endforeach;

        echo "done";
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
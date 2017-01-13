<?php
defined('BASEPATH') OR exit('No direct script access allowed');

set_time_limit(0);


class Penilaian extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}
		
		redirect('public/home','refresh');
	}

	// Untuk proses penilaian bimbingan
	public function penilaianBimbingan() {
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

		$group = $this->M_kelompok->getActiveGroup($thn_ajaran,$smt,$kode_kel)->row();

		if ( $group ) { // jika group yang di maksud ada 
			if ( $group->npp != $this->session->userdata('npp') ) { // jika group tidak sesuai dopingnya
				redirect('lecturer/data/group','refresh');
			} else {
				
		       	for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
		            
		            $datanya = explode(',',$this->input->get('data'.$i));
		            $nbi = $datanya[0];
		            $nilaiBimbingan = $datanya[1];
		            
		            $dataUpdate = [ 'nilai_bimb' => $nilaiBimbingan];
		            $updateNilai = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$dataUpdate);

		            $getNilaiAKhir = $this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi);
		            $getNilaiHuruf = $this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);
		        }

		        if ($getNilaiAKhir && $getNilaiHuruf){
		        	echo "<script>alert('Penilaian Bimbingan Berhasil Disimpan')</script>";
					redirect('lecturer/data/group/detailGroup/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel,'refresh');
		        } else {
		        	echo "<script>alert('Penilaian Bimbingan Gagal Disimpan')</script>";
					redirect('lecturer/data/group/detailGroup/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel,'refresh');
		       	}

			}

		} else { // jika group yang dimaksud tidak ada
			redirect('lecturer/data/group','refresh');
		}
	}

	// Untuk proses penilaian sidang
	public function penilaianSidang() {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( !empty($_POST) ) {

			if (count($_POST) == 1) :
				redirect('lecturer/data/review','refresh');			
			endif;

			$fields = ['thn_ajaran','smt','kode_kel','nbi','point','kom_a','kom_b','kom_c','kom_d'];

			foreach ($fields as $field) {

				foreach ($_POST[$field] as $key => $value) {

					$datanya[$key][$field] = $value;
				}

			} // end foreach

			foreach ($datanya as $mhs) {

				$thn_ajaran = $mhs['thn_ajaran'];
				$smt = $mhs['smt'];
				$kode_kel = $mhs['kode_kel'];
				$nbi = $mhs['nbi'];

				if ( $mhs['point'] == 1 ) { // penilaian moderator
				
					$kom_a = 'nilai_11';
					$kom_b = 'nilai_12';
					$kom_c = 'nilai_13';
					$kom_d = 'nilai_14';

				} else if ( $mhs['point'] == 2 ) { // penilaian penguji 1

					$kom_a = 'nilai_21';
					$kom_b = 'nilai_22';
					$kom_c = 'nilai_23';
					$kom_d = 'nilai_24';
				
				} else { // penilaian penguji 2

					$kom_a = 'nilai_31';
					$kom_b = 'nilai_32';
					$kom_c = 'nilai_33';
					$kom_d = 'nilai_34';

				}

				$dataUpdate = [ 
					$kom_a => $mhs['kom_a'],
					$kom_b => $mhs['kom_b'],
					$kom_c => $mhs['kom_c'],
					$kom_d => $mhs['kom_d'],
				];

		        $updateNilai = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$dataUpdate);

		        $getNilaiAKhir = $this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi);
		        $getNilaiHuruf = $this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);

			} // end foreach

			if ($getNilaiAKhir && $getNilaiHuruf){
	        	echo "<script>alert('Nilai Review Sidang Berhasil Disimpan')</script>";
				redirect('lecturer/data/review','refresh');
	        } else {
	        	echo "<script>alert('Nilai Review Sidang Berhasil Disimpan')</script>";
				redirect('lecturer/data/review','refresh');
	       	}

		} else {
			redirect('lecturer/data/review','refresh');			
		}
	}


	// Proses generate nilai akhir
	private function generateNilaiAkhir($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nbi = NULL) {
		if ( !$this->session->userdata('isLecturerTps') && !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$dataFilter = [
			'thn_ajaran'	=> $thn_ajaran,
			'smt'			=> $smt,
			'kode_kel'		=> $kode_kel,
			'nbi'			=> $nbi
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
			'thn_ajaran'	=> $thn_ajaran,
			'smt'			=> $smt,
			'kode_kel'		=> $kode_kel,
			'nbi'			=> $nbi
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

/* End of file Penilaian.php */
/* Location: ./application/controllers/Penilaian.php */
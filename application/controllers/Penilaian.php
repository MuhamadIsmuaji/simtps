<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		            $jenis_nilai = 'nilai_bimb';
		            $getNilaiAKhir = $this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$nilaiBimbingan,$jenis_nilai);
		            $getNilaiHuruf = $this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);
		        }

		        if ($getNilaiAKhir && $getNilaiHuruf){
		        	echo "<script>alert('Berhasil')</script>";
					redirect('lecturer/data/group/detailGroup/'.$thn_ajaran.'/'.$smt.'/'.$kode_kel,'refresh');
		        }
		       	else {
		        	echo "<script>alert('Gagal')</script>";
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

		if ( ! empty($_POST) ) {
			if ( $this->input->post('btnSimpanNilaiModerator') ) { // Proses penilaian oleh moderator
				
				$fields = ['nbi','kode_kel','thn_ajaran','smt','nilai_11','nilai_12','nilai_13','nilai_14'];

				foreach ($fields as $field) {

					foreach ($_POST[$field] as $key => $value) {
						
						$datanya[$key][$field] = $value;
					}

				}

				// Proses update nilai moderator dan nilai huruf
				foreach ($datanya as $value) {
					$thn_ajaran = $value['thn_ajaran'];
					$smt = $value['smt'];
					$kode_kel = $value['kode_kel'];
					$nbi = $value['nbi'];

					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_11'],'nilai_11');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_12'],'nilai_12');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_13'],'nilai_13');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_14'],'nilai_14');

					$this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);
				}


			} else if ( $this->input->post('btnSimpanNilaiPenguji1') ) { // Proses penilaian oleh penguji 1

				$fields = ['nbi','kode_kel','thn_ajaran','smt','nilai_21','nilai_22','nilai_23','nilai_24'];

				foreach ($fields as $field) {

					foreach ($_POST[$field] as $key => $value) {
						
						$datanya[$key][$field] = $value;
					}

				}

				// Proses update nilai moderator dan nilai huruf
				foreach ($datanya as $value) {
					$thn_ajaran = $value['thn_ajaran'];
					$smt = $value['smt'];
					$kode_kel = $value['kode_kel'];
					$nbi = $value['nbi'];

					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_21'],'nilai_21');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_22'],'nilai_22');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_23'],'nilai_23');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_24'],'nilai_24');

					$this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);
				}


			} else if ( $this->input->post('btnSimpanNilaiPenguji2') ) { // Proses penilaian oleh penguji 2

				$fields = ['nbi','kode_kel','thn_ajaran','smt','nilai_31','nilai_32','nilai_33','nilai_34'];

				foreach ($fields as $field) {

					foreach ($_POST[$field] as $key => $value) {
						
						$datanya[$key][$field] = $value;
					}

				}

				// Proses update nilai moderator dan nilai huruf
				foreach ($datanya as $value) {
					$thn_ajaran = $value['thn_ajaran'];
					$smt = $value['smt'];
					$kode_kel = $value['kode_kel'];
					$nbi = $value['nbi'];

					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_31'],'nilai_31');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_32'],'nilai_32');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_33'],'nilai_33');
					$this->generateNilaiAkhir($thn_ajaran,$smt,$kode_kel,$nbi,$value['nilai_34'],'nilai_34');

					$this->generateNilaiHuruf($thn_ajaran,$smt,$kode_kel,$nbi);
				}

			} else {
				redirect('lecturer/data/review','refresh');			
			}

			redirect('lecturer/data/review','refresh');			

		} else {
			redirect('lecturer/data/review','refresh');
		}

	}


	// Proses generate nilai akhir
	private function generateNilaiAkhir($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nbi = NULL, $nilaiBimb = NULL, $jenis_nilai = NULL) {
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
			$dataUpdate = [ $jenis_nilai => $nilaiBimb];
			$updateNilai = $this->M_anggota->update($thn_ajaran,$smt,$kode_kel,$nbi,$dataUpdate);

			if ( $updateNilai ) {
				// Perhitungan nilai kahir
				//$totalNilai = $dataAnggota->nilai_11 + $nilaiBimb;
				$totalNilai = 0;
				
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
			$nilaiHuruf = $dataAnggota->nilai_akhir <= 50 ? 'C' : 'A';

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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Point Print</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/download_daftar_nilai.css') ?>">
</head>
<body>
	<!-- header -->
	<header>
		<div class="identity">
			<div>
				<p class="labname">
					Laboratorium Rekayasa Perangkat Lunak	
				</p>
			</div>
			<div>
				<p class="consname">
					Teknik Informatika Universitas 17 Agustus 1945 Surabaya				
				</p>
			</div>
		</div>

		<div class="identity2">
			<div>
				<p class="pointlist">
					Daftar Nilai
				</p>
			</div>
			<div>
				<p class="taskname">
					Tugas Perancangan Sistem
				</p>
			</div>
			<div>
				<p class="date">
					Tahun Ajaran <?= $thn_ajaran.'/'.$next.' ' ?> Semeseter <?= $smt ?>
				</p>
			</div>
		</div>
	</header>	
	<!-- header -->

	<!-- content -->
	<div class="Table">
	    <div class="Heading">
	        <div class="Cell no">
	            <p>No</p>
	        </div>
	        <div class="Cell nbi">
	            <p>NBI</p>
	        </div>
	        <div class="Cell nama">
	            <p>Nama</p>
	        </div>
	        <div class="Cell nilai">
	            <p>Nilai</p>
	        </div>
	        <div class="Cell keterangan">
	            <p>Keterangan</p>
	        </div>
	    </div>
	</div>
	
	<?php 
		$no = 1;
		foreach ($pointList as $point) {

			if ($point->kode_kel != '0') :
                 $arrKeterangan = [];

                $arrNilaiBimb = [
                    $point->nilai_bimb, 
                ];

                $arrNilaiMod = [
                    $point->nilai_11, $point->nilai_12, $point->nilai_13, $point->nilai_14,
                ];

                $arrNilaiP1 = [
                    $point->nilai_21, $point->nilai_22, $point->nilai_23, $point->nilai_24,
                ];

                $arrNilaiP2 = [
                    $point->nilai_31, $point->nilai_32, $point->nilai_33, $point->nilai_34,
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
	?>
			<div class="tableRow" style="page-break-inside:auto;">
				<div class="container">
					<div class="cellRow no-row">
						<p><?= $no ?></p>
					</div>
					<div class="cellRow nbi-row">
						<p><?= $point->nbi ?></p>
					</div>
					<div class="cellRow nama-row">
						<p><?= $point->nama ?></p>
					</div>
					<div class="cellRow nilai-row">
						<p><?= $point->nilai_huruf ?></p>
					</div>
					<div class="cellRow keterangan-row">
						<p><?= $keterangan ?></p>
					</div>
				</div>
			</div>
	<?php
			$no++;
		}
	?>

	<div class="kalabSign" style="page-break-inside: avoid;">
		<p class="when">
			Surabaya, <?= $when ?>
		</p>
		<p class="kalab">Kalab RPL,</p>
		<p class="who"><?= $settingData->nama_kalab ?></p>
		<hr>
		<p class="whonpp">
			<?php
				$first = substr($settingData->npp_kalab,0,5);
				$second = substr($settingData->npp_kalab,5,2);
				$third = substr($settingData->npp_kalab,7);		
				echo "NPP. ".$first.'.'.$second.'.'.$third;
			?>
		</p>
	</div>
	<!-- content -->
	
</body>
</html>
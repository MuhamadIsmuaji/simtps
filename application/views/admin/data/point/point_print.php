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
	    </div>
	</div>
	
	<?php 
		$no = 1;
		foreach ($pointList as $point) {
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
		<p class="who"><?= $settingData->nama_dekan ?></p>
		<hr>
		<p class="whonpp">NPP : <?= $settingData->npp_kalab ?></p>
	</div>
	<!-- content -->
	
</body>
</html>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Guidance Print</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lembar_bimbingan.css') ?>">
</head>
<body>
	<!-- header -->
	<header>

		<div class="title">
			<p>Lembar Kontrol Bimbingan</p>
			<p>Tugas Praktikum Perancangan Sistem</p>
			<p>Tahun Ajaran 
				<?php
					$smt = $guidance[0]->smt == 1 ? 'Ganjil' : 'Genap';
					$next = $guidance[0]->thn_ajaran+1; 
					echo $guidance[0]->thn_ajaran.'/'.$next.' Semester '.$smt; 
				?>
			</p>
		</div>	

		<hr class="top">
		<hr class="bottom">
	
		<div class="identity">
			<table class="identity">
				<tr>
					<td class="rowtitle">Judul</td>
					<td class="rowdotted">:</td>
					<td><?= $group->judul ?></td>
				</tr>
				<tr>
					<td class="rowtitle">Kelompok</td>
					<td class="rowdotted">:</td>
					<td><?= $group->kode_kel ?></td>
				</tr>
				<tr>
					<td class="rowtitle">Dosen Pembimbing</td>
					<td class="rowdotted">:</td>
					<td><?= $group->nama ?></td>
				</tr>
				<tr>
					<td class="rowtitle">Anggota</td>
					<td class="rowdotted">:</td>
					<td>
						<table cellspacing="0" cellpadding="0" style="font-size: 14px;">
							<?php
								foreach ($member as $value) {
							?>
									<tr>
										<td><?= $value->nbi.' - '.$value->nama ?></td>
									</tr>
							<?php 
								}
							?>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</header>
	<!-- header -->

	<!-- Tablehead -->
	<div class="Table">
	    <div class="Heading">
	        <div class="Cell no">
	            <p>No</p>
	        </div>
	        <div class="Cell tgl">
	            <p>
	            	Tanggal
	            </p>
	        </div>
	        <div class="Cell uraian">
	            <p>
	            	Uraian
	            </p>
	        </div>
	        <div class="Cell validasi">
	            <p>Validasi Dosen Pembimbing</p>
	        </div>
	    </div>
	</div>
	<!-- Tablehead -->

	<!-- Tablerow -->
	<?php 
		foreach ($guidance as $data) {
			$validasi = $data->validasi == 1 ? 'Valid' : 'Belum Valid';
			$tgl = new DateTime($data->tgl);
	?>
		<div class="tableRow" style="page-break-inside: avoid;">
			<table class="tableRow" cellspacing="0">
			  <tr>
			    <td><?= $data->nou ?></td>
			    <td><?= $tgl->format('d-m-Y') ?></td>
			    <td><?= $data->uraian ?></td>
			    <td><?= $validasi ?></td>
			  </tr>
			</table>
		</div>

	<?php 
		}
	?>
	<!-- Tablerow -->
</body>
</html>
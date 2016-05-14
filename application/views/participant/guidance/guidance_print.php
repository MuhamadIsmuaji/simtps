<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Guidance Print</title>
	<style type="text/css">
	/*Body*/
	body {
		color : black;
		font-family: "Times New Roman";
		margin: 0px;
	    padding: 0px;
	}
	/*Body*/

	/*header*/
	
	/*title*/
	div.title {
		font-size: 18px;
		text-align: center;
		text-transform: uppercase;
	}

	div.title p {
		margin-top: 0px;
		margin-bottom: 5px;
	}
	/*title*/

	/*identity*/
	div.identity {
		margin-top: 20px;
		width: 100%;
		height: auto;
		font-size: 14px;
	}

	table.identity {
	  	margin: 0px;
	  	table-layout: fixed;
	  	width: 100%; /* must have this set */
		font-size: 14px;
	}

	table.identity td.rowtitle {
		width: 18%;
		vertical-align: top;
	}

	table.identity td.rowdotted {
		width: 1%;
		vertical-align: top;
	}

	table.identity td:nth-child(3) {
		word-wrap: break-word;
	}
	/*identity*/
	
	hr.top {
		margin-top: -8px;
		margin-bottom: 0px;
		height: 2.5px;
		background-color: black;
	}

	hr.bottom {
		margin-top: 3px;
		height: 0.5px;
		background-color: black;
	}

	/*header*/

	/*Table Head*/
	.Table {
    	display: table;
	    width: 100%;
	    margin-top: 15px;
	}

	.Heading {
	    display: table-row;
	    font-weight: bold;
	    font-size: 16px;
	    text-align: center;
	}

	.Cell {
	    display: table-cell;
	    border: 1px solid black;
	    height: 1px;
	}

	div.Cell p {
	    margin: 5px 0px 5px 0px;
	}

	div.no {
		width: 35px;
		border-right: 0px;
		padding-top: 6px;
	}

	div.uraian {
		width: 520px;
		border-right: 0px;
		padding-top: 6px;
	}

	div.validasi {
	    border-width: thin;
	}
	/*Table Head*/

	/*Table Row*/
	div.tableRow {
		width: 100%;
		height: auto;
		padding: 0px;
		margin-top: -1px;
		margin-bottom: -1px;
	}

	table.tableRow {
	  	margin: 0px;
	  	border: 1px solid black;
	  	table-layout: fixed;
	  	width: 100%; /* must have this set */
		font-size: 14px;
	}

	table.tableRow td {
 		border: 1px solid black;
	}

	table.tableRow td:nth-child(1) {
		width: 5%;
		text-align: center;
	}

	table.tableRow td:nth-child(2) {
		width: 74.4%;
		word-wrap: break-word;
		padding: 5px;
	}

	table.tableRow td:nth-child(3) {
		text-align: center;
	}
	/*Table Row*/

	
	</style>
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
	?>
		<div class="tableRow" style="page-break-inside: avoid;">
			<table class="tableRow" cellspacing="0">
			  <tr>
			    <td><?= $data->nou ?></td>
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
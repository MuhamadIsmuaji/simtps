<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Loa Print</title>
	<style type="text/css">
		/*Body*/
		body {
			color : black;
			font-family: "Times New Roman";
			line-height:0.9;!important
			margin: 0px;
            padding: 0px;
		}
		/*Body*/

		/*Header*/
		header p.univname {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 10px;
		}

		header p.facultyname {
			text-align: center;
			font-size: 22px;
			font-weight: bold;
			letter-spacing: 4px;
			margin-bottom: 5px;
			margin-top: 0px;
		}

		header p.address {
			text-align: center;
			font-size: 12px;
			margin-top: 0px;
		}

		div.prodi {
			width: 575px;
			height: auto;
			margin-left: 64px;
			margin-bottom: -10px;
			font-size: 15px;
		}
		
		div.prodiLeft {
			width: 287.5px;
			padding-top: -10px;
		}

		div.prodiLeft p {
			padding-top: -7px;
		}

		div.prodiRight {
			width: 287.5px;
			margin-left: 287.5px;
			position: absolute;
			padding-top: -102px;

		}

		div.prodiRight p {
			padding-top: -7px;
			padding-left: 40px;

		}
		
		hr.top {
			margin-top: -8px;
			margin-bottom: 0px;
			height: 3px;
			background-color: black;
		}

		hr.bottom {
			margin-top: 2px;
			height: 1px;
			background-color: black;
		}
		/*Header*/

		/*content*/
		
		/*main*/

		/*Letter number*/
		div.title {
			width: 100%;
			height: auto;
			margin-top: 2px;
		}

		div.title p {
			text-transform: uppercase;
			text-decoration: underline;
			letter-spacing: 1px;
			text-align: center;
			font-weight: bold;
			font-size: 26px;
			margin-bottom: 0px;
		}

		div.letternumber p {
			text-align: center;
			font-weight: bold;
			font-size: 14px;
			margin-top: 10px;
			letter-spacing: 1px;
		}
		/*Letter number*/

		/*Table main*/
		div.tablemain {
			width: 100%;
			height: auto;
			margin-top: 10px;
		}
		/*Table main*/

		/*givetask*/
		div.givetaskcontainer {
			margin-bottom: 0px;
			border: 1px solid black;
			width: 100%;
			height: auto;
			padding-left: 10px;
			padding-bottom: 10px;
			padding-top: 5px;
		}

		div.givetaskcontainer p.title {
			font-size: 14px;
			margin-bottom: 0px;
		}
		
		div.givetaskcontainer table.content {
			font-size: 14px;
			margin-top: 5px;
			margin-left: 30px;
		}

		div.givetaskcontainer table.onecontent {
			font-size: 14px;
			margin-top: 5px;
			margin-left: -1px;
		}
		/*givetask*/
		
		/*closing*/
		div.closing {
			font-size: 14px;
		}
		/*closing*/

		/*Kalab Sign*/
		div.kalabSign {
			width: 325px;
			height: 200px;
			margin: 5px 0px -10px 375px;
		}

		p.when {
			text-align: center;
			font-size: 14px;
		}

		p.kalab {
			text-align: center;
			font-size: 14px;
		}


		p.who {
			text-align: center;
			font-size: 14px;
			margin-top: 85px;
			margin-bottom: 0px;
		}

		hr.kalabSign {
			width: 65%;
			margin-top: 0px;
			margin-bottom: 0px;
		}

		p.whonpp {
			text-align: center;
			font-size: 14px;
			margin-bottom: 0px;
			margin-top: 0px;
			padding-top: 0px;
		}
		/*Kalab Sign*/
		
		/*Tembusan*/
		div.tembusan {
			font-size: 14px;
			margin-top: -10px;
		}

		div.tembusan p.title {
			font-weight: bold;
			text-decoration: underline;
		}
		/*Tembusan*/

		/*main*/

		/*content*/

	</style>
</head>
<body>
	<!-- header -->
	<header>
		<p class="univname">UNIVERSITAS 17 AGUSTUS 1945 (UNTAG) SURABAYA</p>
		<p class="facultyname">FAKULTAS TEKNIK</p>
		<p class="address">
			<strong>Kampus</strong>
			Jl. Semolowaru No.45 Surabaya 60118.
			<strong>Telepon :</strong> 5931800 (hunting), 5921516 (Direct).
			<strong>Fax :</strong> (031) 5921516
		</p>
		
		<div class="prodi">
			<div class="prodiLeft">
				<p>- Program Studi Teknik Industri</p>
				<p>- Program Studi Teknik Sipil</p>
				<p>- Program Studi Teknik Elektro</p>
				<p>- Program Studi Teknik Mesin</p>
			</div>
			<div class="prodiRight">
				<p>- Program Studi Teknik Arsitektur</p>
				<p>- Program Studi Teknik Informatika</p>
				<p>- Program Studi Magister Teknik Sipil</p>
			</div>
		</div>

		<hr class="top">
		<hr class="bottom">
	</header>
	<!-- header -->
	
	<!-- content -->
	<div class="main">
		<div class="title">
			<p>Surat Tugas</p>
		</div>
		<div class="letternumber">
			<p>Nomor : <?= $settingData->no_surattgs ?></p>
		</div>
		<div class="tablemain">

			<div class="givetaskcontainer">
				<p class="title">1.&nbsp;&nbsp;&nbsp;Pemberi Tugas</p>
				<table class="content" border="0px" cellspacing="5px;">
					<tr>
						<td width="205px">Nama</td>
						<td>:</td>
						<td><?= $settingData->nama_dekan ?></td>
					</tr>
					<tr>
						<td width="205px">NPP</td>
						<td>:</td>
						<td>
							<?php 
								$first = substr($settingData->npp_dekan,0,5);
								$second = substr($settingData->npp_dekan,6,2);
								$third = substr($settingData->npp_dekan,8);
								echo $first.'.'.$second.'.'.$third;	
							?>
						</td>
					</tr>
					<tr>
						<td width="205px">Jabatan</td>
						<td>:</td>
						<td>Dekan Fakultas Teknik</td>
					</tr>
				</table>
			</div>
			
			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" width="252px">2.&nbsp;&nbsp;&nbsp;Memberi Tugas Kepada</td>
						<td>:</td>
						<td>&nbsp;Nama terlampir</td>
					</tr>
				</table>
			</div>

			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" width="252px">3.&nbsp;&nbsp;&nbsp;Waktu</td>
						<td>:</td>
						<td>
							<?php 
								$next = $settingData->thn_ajaran+1;
								$smt = $settingData->smt == 1 ? 'Gasal' : 'Genap';
								echo '&nbsp;<strong>Periode Semester '.$smt.' Tahun '.$settingData->thn_ajaran.'-'.$next.'</strong>';
							?>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" width="252px" style="vertical-align: top;" rowspan="3">4.&nbsp;&nbsp;&nbsp;Tujuan</td>
						<td align="top" rowspan="3" style="vertical-align: top;">:</td>
						<td style="vertical-align: top;">
							&nbsp;Program Studi Teknik Informatika
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;">
							&nbsp;Fakultas Teknik Universitas 17 Agustus 1945 Surabaya
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;">
							&nbsp;Jl. Semolowaru 45 Surabaya
						</td>
					</tr>

				</table>
			</div>

			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" width="252px" style="vertical-align: top;" rowspan="2"	>5.&nbsp;&nbsp;&nbsp;Keperluan</td>
						<td align="top" rowspan="2" style="vertical-align: top;">:</td>
						<td style="vertical-align: top;">
							&nbsp;Sebagai Pembimbing
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;">
							<strong>&nbsp;1.&nbsp;&nbsp;&nbsp;Praktikum Tugas Perancangan Sistem</strong>
						</td>
					</tr>
				</table>
			</div>

			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" width="252px">6.&nbsp;&nbsp;&nbsp;Pengikut</td>
						<td>:</td>
						<td>&nbsp;<strong><?= $pengikut ?> Orang</strong></td>
					</tr>
				</table>
			</div>

			<div class="givetaskcontainer">
				<table class="onecontent" border="0px">
					<tr>
						<td align="left" style="vertical-align: top;" width="252px">7.&nbsp;&nbsp;&nbsp;Keterangan</td>
						<td style="vertical-align: top;">:</td>
						<td>&nbsp;Setelah bertugas melaporkan kegiatan kepada Dekan</td>
					</tr>
				</table>
			</div>
		
		</div>

		<div class="closing">
			<p>Demikian Surat Tugas ini diterbitkan dan untuk dipergunakan sebagaimana mestinya</p>	
		</div>

		<div class="kalabSign">
			<p class="when">
				Surabaya, <?= $when ?>
			</p>
			<p class="kalab">Dekan,</p>
			<p class="who"><?= $settingData->nama_dekan ?></p>
			<hr class="kalabSign">
			<p class="whonpp">
				<?php
					$first = substr($settingData->npp_dekan,0,5);
					$second = substr($settingData->npp_dekan,6,2);
					$third = substr($settingData->npp_dekan,8);		
					echo "NPP. ".$first.'.'.$second.'.'.$third;
				?>
			</p>
		</div>

		<div class="tembusan">
			<p class="title">Tembusan :</p>
			<p class="content">1.&nbsp;Arsip</p>
		</div>
	</div>
	<!-- content -->
</body>
</html>
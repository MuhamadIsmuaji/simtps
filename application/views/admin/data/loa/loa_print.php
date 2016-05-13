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
		div.title {
			width: 100%;
			height: auto;
			margin-top: 5px;
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
	</div>
	<!-- content -->


</body>
</html>
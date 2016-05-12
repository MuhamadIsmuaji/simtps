<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Point Print</title>
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
		header div.identity {
			line-height:0.1;!important
			font-size: 17px;
		}

		header p.labname {
			text-align: center;
			font-weight: bold;
		}

		header p.consname {
			margin-top: 5px;
			text-align: center;
			font-weight: bold;
		}

		header div.identity2 {
			margin-top: 7px;
			line-height:0.1;!important
			font-size: 17px;
		}

		header p.pointlist {
			text-align: center;
			font-weight: bold;
			text-transform: uppercase;
		}

		header p.taskname {
			margin-top: 7px;
			text-align: center;
			font-weight: bold;
		}

		header p.date {
			margin-top: 5px;
			text-align: center;
			font-weight: bold;
		}
		/*header*/

		/*content*/
		
		/*Table Head*/
		.Table {
	        display: table;
	        width: 100%;
	    }

	    .Heading {
	        display: table-row;
	        font-weight: bold;
	        font-size: 14px;
	        text-align: center;
	    }

	    .Cell {
	        display: table-cell;
	        border: solid;
	        border-width: thin;
	        height: 1px;
	    }

	    div.Cell p {
	        margin: 5px 0px 5px 0px;
	    }

	    div.no {
	    	width: 55px;
	    	border-right: 0px;
	    }

	    div.nbi {
	    	width: 145px;
	    	border-right: 0px;
	    }

	    div.nama {
	    	width: 400px;
	    	border-right: 0px;
	    }
		/*Table Head*/

		/*Table Row*/
		.tableRow {
			width: 100%;
			height: 20px;
			display: table;
		}

		.container {
	        display: table-row;
	        font-size: 12px;
	    }

	    .cellRow {
	        display: table-cell;
	        border: solid;
	        border-width: thin;
	        height: 1px;
	    }

	    div.cellRow p {
	        margin: 5px 0px 5px 0px;
	    }

	    div.no-row {
	    	width: 55px;
	    	border-right: 0px;
	        text-align: center;
	    }

	    div.nbi-row {
	    	width: 135px;
	    	border-right: 0px;
	        text-align: left;
	        padding-left: 10px;
	    }

	    div.nama-row {
	    	width: 390px;
	    	border-right: 0px;
	        text-align: left;
	        padding-left: 10px;

	    }

	    div.nilai-row {
	        text-align: center;
	    }

		/*Table Row*/

		/*Kalab Sign*/
		div.kalabSign {
			width: 250px;
			height: 200px;
			margin: 20px 0px 0px 450px;
		}

		p.when {
			text-align: center;
			font-size: 16px;
		}

		p.who {
			text-align: center;
			font-size: 16px;
			margin-top: 100px;
			margin-bottom: 0px;
		}

		hr {
			width: 90%;
			margin-top: 0px;
			margin-bottom: 0px;
		}

		p.whonpp {
			text-align: center;
			font-size: 16px;
			margin-bottom: 0px;
			margin-top: 0px;
			padding-top: 0px;
		}
		/*Kalab Sign*/
		
		/*content*/

		/*17 + 7 + 50 */

	</style>
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
		<p class="who"><?= $settingData->nama_kalab ?></p>
		<hr>
		<p class="whonpp">NPP : <?= $settingData->npp_kalab ?></p>
	</div>
	<!-- content -->
	
</body>
</html>
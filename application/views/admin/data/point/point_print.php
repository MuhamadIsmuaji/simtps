<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Loa Print</title>
	<style type="text/css">
		body {
			color : black;
			font-family: "Times New Roman";
			line-height:0.9;!important
			margin: 0px;
            padding: 0px;
		}

		header p.univname {
			text-align: center;
			font-size: 16px;
			font-weight: bold;
		}

		header p.facultyname {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: -10px;
		}

		header p.address {
			text-align: center;
			font-size: 11px;
		}

		table.tProdi {
			font-size: 12px;
		}

	</style>
</head>
<body>
	<?php 
		foreach ($pointList as $value) {
			echo $value->nama.'<br/>';
		}
	?>	
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?= base_url('lecturer/data/review/action') ?>" method="POST">
		Ani <br/>
		<input type="text" name="nama[]" value="ani" readonly />
		<input type="text" name="nilai_11[]" /> &nbsp <input type="text" name="nilai_12[]" /> &nbsp <input type="text" name="nilai_13[]" /> <br/>
		Budi <br/>
		<input type="text" name="nama[]" value="budi" readonly />
		<input type="text" name="nilai_11[]" /> &nbsp <input type="text" name="nilai_12[]" /> &nbsp <input type="text" name="nilai_13[]" /> <br/>
		Dwi <br/>
		<input type="text" name="nama[]" value="dwi" readonly />
		<input type="text" name="nilai_11[]" /> &nbsp <input type="text" name="nilai_12[]" /> &nbsp <input type="text" name="nilai_13[]" /> <br/>
		<input type="submit" />
	</form>
</body>
</html>
<?php 
	$next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    //echo 25/100;
?>

<div class="page-title">
   <div class="row">
         <div class="col-md-8">
            <span class="title">Review Sidang</span>
            <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
            <input type="hidden" id="bobot_kom_a" name="bobot_kom_a" value="<?= $settingData->kom_a ?>" />
            <input type="hidden" id="bobot_kom_b" name="bobot_kom_b" value="<?= $settingData->kom_b ?>" />
            <input type="hidden" id="bobot_kom_c" name="bobot_kom_c" value="<?= $settingData->kom_c ?>" />
            <input type="hidden" id="bobot_kom_d" name="bobot_kom_d" value="<?= $settingData->kom_d?>" />
         </div>
   </div>
</div>
<div class="row">
    <div class="col-xs-12">
    	<div class="card">
    		<div class="card-header">
                <div class="card-title">
                    <div class="title">
                    	Dosen : <?= $this->session->userdata('nama'); ?> 
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
	        <form action="<?= base_url('penilaian/penilaianSidang') ?>" method="POST">
	    		<table id="tbReview" class="table table-striped" cellspacing="0" width="100%">
	                <thead>
	                    <tr >
	                        <th style="text-align: center;" >NBI</th>
	                        <th style="text-align: center;" >Nama</th>
	                        <th style="text-align: center;" >Kelompok</th>
	                        <th style="text-align: center;" >Review Sebagai</th>
	                        <th style="text-align: center;" >Presentasi</th>
	                        <th style="text-align: center;" >Kejelasan Rancangan</th>
	                        <th style="text-align: center;" >Kejelasan Uji Coba</th>
	                        <th style="text-align: center;" >Kelengkapan Dokumen</th>
	                        <th style="text-align: center;" >Total</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php 
	                		foreach ($dataMhs as $value) {
	                	?>
							<tr id="kom">
								<td style="text-align: center;" ><?= $value['nbi'] ?></td>
								<td style="text-align: center;" ><?= $value['nama'] ?></td>
								<td style="text-align: center;" ><?= $value['kode_kel'] ?></td>
								<td style="text-align: center;" ><?= $value['review_as'] ?></td>
								<td style="text-align: center;" >
									<input type="text" name="kom_a[]" id="kom_a" value="<?= $value['kom_a'] ?>" style="text-align: center;" onkeyup="generateTotal(this);" onfocus="generateTotal(this);"
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_b[]" id="kom_b" value="<?= $value['kom_b'] ?>" style="text-align: center;" onkeyup="generateTotal(this);" onfocus="generateTotal(this);"
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_c[]" id="kom_c" value="<?= $value['kom_c'] ?>" style="text-align: center;" onkeyup="generateTotal(this);" onfocus="generateTotal(this);"
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_d[]" id="kom_d" value="<?= $value['kom_d'] ?>" style="text-align: center;" onkeyup="generateTotal(this);" onfocus="generateTotal(this);"
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="total[]" id="total" value="E" style="text-align: center;" size="5" disabled />
									<input type="hidden" name="thn_ajaran[]" value="<?= $value['thn_ajaran'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="smt[]" value="<?= $value['smt'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="kode_kel[]" value="<?= $value['kode_kel'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="nbi[]" value="<?= $value['nbi'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="point[]" value="<?= $value['point'] ?>" style="text-align: center;" size="5" />
								</td>
							</tr>
	                	<?php 
	                		}
	                	?>
	                </tbody>
				</table>
			</div>
			<div class="sub-title"></div>
	        <div class="text-indent">
	            <input type="submit" name="btnStartReview" class="btn btn-primary btn-block" value="Simpan" />
	        </div>
	        </form>	
            </div>
    	</div>
    </div>
</div>

<script type="text/javascript">
	var bobot_kom_a,bobot_kom_b,bobot_kom_c,bobot_kom_d = '';

	$(function(){
		bobot_kom_a = ( parseFloat($('#bobot_kom_a').val())/100 );
		bobot_kom_b = ( parseFloat($('#bobot_kom_b').val())/100 );
		bobot_kom_c = ( parseFloat($('#bobot_kom_c').val())/100 );
		bobot_kom_d = ( parseFloat($('#bobot_kom_d').val())/100 );

		// refresh nilai huruf di tabel
		$('tr#kom').each(function(){
			var kom_a_tb = parseFloat($(this).find('input[name="kom_a[]"]').val());
			var kom_b_tb = parseFloat($(this).find('input[name="kom_b[]"]').val());
			var kom_c_tb = parseFloat($(this).find('input[name="kom_c[]"]').val());
			var kom_d_tb = parseFloat($(this).find('input[name="kom_d[]"]').val());

			kom_a_tb = isNaN(kom_a_tb) ? 0 : kom_a_tb;
			kom_b_tb = isNaN(kom_b_tb) ? 0 : kom_b_tb;
			kom_c_tb = isNaN(kom_c_tb) ? 0 : kom_c_tb;
			kom_d_tb = isNaN(kom_d_tb) ? 0 : kom_d_tb;

			total_tb = (kom_a_tb * bobot_kom_a) + (kom_b_tb * bobot_kom_b) + (kom_c_tb * bobot_kom_c) + (kom_d_tb * bobot_kom_d);
			$(this).find('input[name="total[]"]').val(grade(total_tb));
		});
		// refresh nilai huruf di tabel

	});

	function generateTotal(obj) {
		var kom_a = parseFloat($(obj).parents("tr").find('input[name="kom_a[]"]').val());
		var kom_b = parseFloat($(obj).parents("tr").find('input[name="kom_b[]"]').val());
		var kom_c = parseFloat($(obj).parents("tr").find('input[name="kom_c[]"]').val());
		var kom_d = parseFloat($(obj).parents("tr").find('input[name="kom_d[]"]').val());

		kom_a = isNaN(kom_a) ? 0 : kom_a;
		kom_b = isNaN(kom_b) ? 0 : kom_b;
		kom_c = isNaN(kom_c) ? 0 : kom_c;
		kom_d = isNaN(kom_d) ? 0 : kom_d;

		total = (kom_a * bobot_kom_a) + (kom_b * bobot_kom_b) + (kom_c * bobot_kom_c) + (kom_d * bobot_kom_d);
		$(obj).parents("tr").find('input[name="total[]"]').val(grade(total));
	}

	function grade(Na) {
		var Grade = null;
	    if(Na > 85)
	        Grade='A';
	    else if(Na > 80 && Na <=85)
	        Grade='A-';
	    else if(Na > 75 && Na <=80)
	        Grade='AB';
	    else if(Na > 70 && Na <=75)
	        Grade='B+';
	    else if(Na > 65 && Na <=70)
	        Grade='B';
	    else if(Na > 60 && Na <=65)
	        Grade='B-';
	    else if(Na > 55 && Na <=60)
	        Grade='BC';
	    else if(Na > 50 && Na <=55)
	        Grade='C+';
	    else if(Na > 45 && Na <=50)
	        Grade='C';
	    else if(Na > 40 && Na <=45)
	        Grade='C-';
	    else if(Na > 35 && Na <=40)
	        Grade='CD';
	    else if(Na > 30 && Na <=35)
	        Grade='D';
	    else if(Na >=0 && Na <=30)
	        Grade='E';
	    else
	        Grade='F';

	    return Grade;
	}


</script>
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
            <input type="hidden" id="bobot_bimbingan" name="bobot_bimbingan" value="<?= $settingData->bobot_bimbingan ?>" />
            <input type="hidden" id="bobot_moderator" name="bobot_moderator" value="<?= $settingData->bobot_moderator ?>" />
            <input type="hidden" id="bobot_penguji1" name="bobot_penguji1" value="<?= $settingData->bobot_penguji1 ?>" />
            <input type="hidden" id="bobot_penguji2" name="bobot_penguji2" value="<?= $settingData->bobot_penguji2 ?>" />
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
                    	Muhamad Ismuaji 
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
							<tr>
								<td style="text-align: center;" ><?= $value['nbi'] ?></td>
								<td style="text-align: center;" ><?= $value['nama'] ?></td>
								<td style="text-align: center;" ><?= $value['kode_kel'] ?></td>
								<td style="text-align: center;" ><?= $value['review_as'] ?></td>
								<td style="text-align: center;" >
									<input type="text" name="kom_a[]" id="kom_a" value="<?= $value['kom_a'] ?>" style="text-align: center;" 
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_b[]" id="kom_b" value="<?= $value['kom_b'] ?>" style="text-align: center;" 
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_c[]" id="kom_c" value="<?= $value['kom_c'] ?>" style="text-align: center;" 
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" name="kom_d[]" id="kom_d" value="<?= $value['kom_d'] ?>" style="text-align: center;" 
										size="5" onkeypress="return numbersonly(this,event)" required />
								</td>
								<td style="text-align: center;" >
									<input type="text" id="total" value="E" style="text-align: center;" size="5" disabled />
									<input type="hidden" name="thn_ajaran[]" value="<?= $value['thn_ajaran'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="smt[]" value="<?= $value['smt'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="kode_kel[]" value="<?= $value['kode_kel'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="nbi[]" value="<?= $value['nbi'] ?>" style="text-align: center;" size="5" />
									<input type="hidden" name="point[]" value="<?= $value['point'] ?>" style="text-align: center;" size="5" />
							</tr>
	                	<?php 
	                		}
	                	?>
	                </tbody>
				</table>
			</div>
			<div class="sub-title"></div>
	        <div class="text-indent">
	            <input type="submit" name="btnStartReview" class="btn btn-primary" value="Simpan" />
	        </div>
	        </form>	
            </div>
    	</div>
    </div>
</div>

<script type="text/javascript">
	$(function(){

	});
</script>
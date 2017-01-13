<?php 
	$next = $settingData->thn_ajaran+1;
	$semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
	// echo "<pre>";
	// print_r($jadwal);
	// echo "</pre>";

?>

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Jadwal Sidang Tugas Perancangan Sistem</span>
    		<div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Jadwal Sidang</div>
	            </div>
	            <div class="pull-right card-action">
	        		<a href="<?= base_url('admin/data/schedule/hearingScheduleCreate') ?>" class="btn btn-primary">
	        			<i class="fa fa-plus fa-lg" aria-hidden="true"></i>&nbsp;
	        			<strong>Buat Jadwal</strong>
	        		</a>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbNewsListsAdmin" class="table table-striped table-bordered" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th style="text-align: center;">No</th>
	                            <th style="text-align: center;">Tanggal Sidang</th>
	                            <th style="text-align: center;">Waktu</th>
	                            <th style="text-align: center;">Ruang</th>
	                            <th style="text-align: center;">Moderator</th>
	                            <th style="text-align: center;">Penguji 1</th>
	                            <th style="text-align: center;">Penguji 2</th>
	                            <th style="text-align: center;">#</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php
                    			$no=1;
                    			$before = 'not-set';
	                    		foreach ($jadwal as $value) {
	                    			if ($before != 'not-set' && $before != $value['ruang']) :
	                    				echo '<tr><td colspan="8" style="background-color: rgba(125, 127, 130, 0.18);"></td></tr>';
	                    			endif;

	                    			$tgl = new DateTime($value['tgl']);
	                    			$mulai = $value['mulai'] <= 9 ? '0'. $value['mulai'] .':00' : $value['mulai'] .':00';
	                    			$akhir = $value['akhir'] <= 9 ? '0'. $value['akhir'] .':00' : $value['akhir'] .':00';
	                    			$waktu = $mulai.' - '.$akhir;
	                    			$ruang = "'".$value['ruang']."'";
	                    			$tglnya = "'".$value['tgl']."'";
	                    			$moderatornya = "'".$value['npp_moderator']."'";
	                    	?>
								<tr>
									<td style="text-align: center;"><?= $no ?></td>
									<td style="text-align: center;"><?= $tgl->format('d-m-Y') ?></td>
									<td style="text-align: center;"><?= $waktu ?></td>
									<td style="text-align: center;"><?= $value['ruang']?></td>
									<td style="text-align: left"><?= $value['nm_moderator']?></td>
									<td style="text-align: left"><?= $value['nm_penguji1']?></td>
									<td style="text-align: left"><?= $value['nm_penguji2']?></td>
									<td style="text-align: center;">
										<a href="<?= base_url('admin/data/schedule/hearingScheduleDetail/'.$value['thn_ajaran'].'/'.$value['smt'].'/'.$value['ruang'].'/'.$value['npp_moderator'].'/'.$value['tgl'].'/'.$value['mulai'].'/'.$value['akhir'])?>" class="btn btn-primary btn-sm">
											<i class="fa fa-eye fa-lg" aria-hidden="true"></i>&nbsp;
											<strong>Detail</strong>
										</a>
										<a href="#" onclick="deleteSchedule(<?= $value['thn_ajaran'].','.$value['smt'].','.$ruang.','.$moderatornya.','.$tglnya.','.$value['mulai'].','.$value['akhir'] ?>);" 
											class="btn btn-danger btn-sm">
											<i class="fa fa-trash fa-lg" aria-hidden="true"></i>&nbsp;
											<strong>Hapus</strong>
										</a>
									</td>
								</tr>
	                    	<?php
	                    			

	                    			$before = $value['ruang'];
	                    			$no++; 
	                    		}
	                    	?>
	                    </tbody>
					</table>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- Lists -->
</div>

<script type="text/javascript">
	function deleteSchedule(thn_ajaran, smt, ruang, moderator, tgl, mulai, akhir) {
		if ( confirm("Yakin Hapus Jadwal ?") ) {
			$.ajax({
	          url : "<?= base_url('admin/data/schedule/hearingScheduleDeleteProcess') ?>",
	          type : "POST",
	          data : "thn_ajaran="+thn_ajaran+"&smt="+smt+"&ruang="+ruang+"&moderator="+moderator+"&tgl="+tgl+"&mulai="+mulai+"&akhir="+akhir,
	          dataType : "JSON",
	          success : function(msg) {
	          	if ( msg ) {
	          		alert('Hapus Jadwal Berhasil');
    				window.location.href = "<?= base_url('admin/data/schedule/hearingSchedule') ?>";
	          	}
	          	else {
	          		alert('Hapus Jadwal Gagal');
	          	}
	          },
	          error : function(jqXHR, textStatus, errorThrown) {
	            alert('Terjadi Kesalahan : '+ textStatus);
	          }
	      });
		}
	}
</script>
<?php 
	$next = $settingData->thn_ajaran+1;
	$semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
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
	        		<table id="tbNewsListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>No</th>
	                            <th>Tanggal Sidang</th>
	                            <th>Waktu</th>
	                            <th>Ruang</th>
	                            <th>#</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php
                    			$no=1;
	                    		foreach ($jadwal as $value) {
	                    			$tgl = new DateTime($value->tgl);
	                    			$mulai = $value->mulai <= 9 ? '0'. $value->mulai .':00' : $value->mulai .':00';
	                    			$akhir = $value->akhir <= 9 ? '0'. $value->akhir .':00' : $value->akhir .':00';
	                    			$waktu = $mulai.' - '.$akhir;
	                    			$ruang = "'".$value->ruang."'";
	                    			$tglnya = "'".$value->tgl."'";
	                    	?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $tgl->format('d-m-Y') ?></td>
									<td><?= $waktu ?></td>
									<td><?= $value->ruang ?></td>
									<td>
										<a href="<?= base_url('admin/data/schedule/hearingScheduleDetail/'.$value->thn_ajaran.'/'.$value->smt.'/'.$value->ruang.'/'.$value->tgl.'/'.$value->mulai.'/'.$value->akhir)?>" class="btn btn-primary">
											<i class="fa fa-eye fa-lg" aria-hidden="true"></i>&nbsp;
											<strong>Detail</strong>
										</a>
										<a href="#" onclick="deleteSchedule(<?= $value->thn_ajaran.','.$value->smt.','.$ruang.','.$tglnya.','.$value->mulai.','.$value->akhir ?>);" 
											class="btn btn-danger">
											<i class="fa fa-trash fa-lg" aria-hidden="true"></i>&nbsp;
											<strong>Hapus</strong>
										</a>
									</td>
								</tr>
	                    	<?php
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
	function deleteSchedule(thn_ajaran, smt, ruang, tgl, mulai, akhir) {
		if ( confirm("Yakin Hapus Jadwal ?") ) {
			$.ajax({
	          url : "<?= base_url('admin/data/schedule/hearingScheduleDeleteProcess') ?>",
	          type : "POST",
	          data : "thn_ajaran="+thn_ajaran+"&smt="+smt+"&ruang="+ruang+"&tgl="+tgl+"&mulai="+mulai+"&akhir="+akhir,
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
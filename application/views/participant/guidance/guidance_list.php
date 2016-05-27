<?php 
	$thn_ajaran = $participant->thn_ajaran;
	$next = $thn_ajaran+1;
	$smt = $participant->smt == 1 ? 'Ganjil' : 'Genap';
	//var_dump($dataBimb);
?>

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Bimbingan Kelompok <?= $participant->kode_kel ?></span>
    		<div class="description">
    			Tahun Ajaran <?= $thn_ajaran.' / '. $next ?> 
    			Semester <?= $smt ?>
    		</div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Bimbingan</div>
	            </div>
	            <div class="pull-right card-action">
	        		<a href="javascript:void(0)" onclick="printGuidance(this)" 
	        			data-thn_ajaran="<?= $thn_ajaran ?>" data-smt="<?= $participant->smt ?>" 
	        				data-Kode_kel="<?= $participant->kode_kel ?>" class="btn btn-primary">
	        			<i class="fa fa-cloud-download fa-lg" aria-hidden="true"></i>
	        			&nbsp;Unduh Data Bimbingan
	        		</a>
	        		<a href="<?= base_url('participant/guidance/create') ?>" class="btn btn-primary">
	        			<i class="fa fa-plus fa-lg" aria-hidden="true"></i>
	        			&nbsp;Input Data Bimbingan
	        		</a>	        		
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbBimbList" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>Ke</th>
	                            <th style="width: 900px;">Uraian Peserta</th>
	                            <th style="width: 900px;">Uraian Dosen</th>
	                            <th>Tanggal Bimbingan</th>
	                            <th>Status Validasi</th>
	                            <th>#</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php 
	                    		foreach ($dataBimb as $bimbingan) {
	                    			$tgl = new DateTime($bimbingan->tgl);
	                    			$status = $bimbingan->validasi == 1 ? 'Valid' : 'Belum Valid';

	                    			if ( $bimbingan->validasi == 0 ) {
	                    				$action = '
							        		<a href="javascript:void(0)" onclick="deleteBimb(this)"
							        			data-thn_ajaran="'. $bimbingan->thn_ajaran .'"
							        			data-smt="'. $bimbingan->smt .'"
							        			data-kode_kel="'. $bimbingan->kode_kel .'"
							        			data-nou="'. $bimbingan->nou .'"        
												class="btn btn-danger"> <i class="fa fa-trash fa-lg" 
												aria-hidden="true"></i>&nbsp;
							        			Hapus
							        		</a>
	                    				';
	                    			} else {
	                    				$action = '-';
	                    			}
	                    	?>
	                    			<tr>
	                    				<td><?= $bimbingan->nou ?></td>
	                    				<td><?= $bimbingan->uraian ?></td>
	                    				<td><?= $bimbingan->uraian_dosen ?></td>
	                    				<td><?= $tgl->format('d-m-Y') ?></td>
	                    				<td><?= $status ?></td>
	                    				<td><?= $action ?></td>
	                    			</tr>
	                    	<?php 	
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
	// for delete guidance data
	// param obj to get attr
	function deleteBimb(obj) {
		thn_ajaran = obj.getAttribute('data-thn_ajaran');
		smt = obj.getAttribute('data-smt');
		kode_kel = obj.getAttribute('data-kode_kel');
		nou = obj.getAttribute('data-nou');
		
		if ( confirm('Yakin ingin hapus data bimbingan ke-'+nou+' ?') ) {
			$.ajax({
				url : "<?= base_url('participant/guidance/delete') ?>",
				data : 'thn_ajaran='+thn_ajaran+'&smt='+smt+'&nou='+nou+'&kode_kel='+kode_kel,
				method : 'POST',
				dataType : 'JSON',
				success : function(msg) {
					if ( msg == 1 ) {
						alert('Hapus data bimbingan gagal.. Silahkan ulangi lagi');
					} else {
						alert('Hapus data bimbingan berhasil..');
					}

					window.location.href = "<?= base_url('participant/guidance') ?>";
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('Reload Browser Anda');
				}
			});
		}
	}

	// for print guidance data
	// param objek to get attr
	function printGuidance(objek) {
		thn_ajaran_print = objek.getAttribute('data-thn_ajaran');
		smt_print = objek.getAttribute('data-smt');
		kode_kel_print = objek.getAttribute('data-kode_kel');
		// window.location.href = "<?= base_url('participant/guidance/guidancePrint') ?>"

    	window.location.href = "<?= base_url('participant/guidance/guidancePrint') ?>/" + thn_ajaran_print +'/'+ smt_print + '/' + kode_kel_print;
	}
</script>
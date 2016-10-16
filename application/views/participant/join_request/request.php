<div class="page-title">
   <div class="row">
   		 <div class="col-md-8 col-md-offset-2">
   		 	<span class="title">Permintaan Gabung Kelompok</span>
    		<div class="description">
    			Sistem Informasi Manajemen Tugas Perancangan Sistem Teknik Informatika Untag Surabaya
    		</div>
   		 </div>
   </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="card-body">
               <div class="thumbnail no-margin-bottom">
                    <div class="caption">
                        <h3 id="thumbnail-label">
                        	<i class="fa fa-users" aria-hidden="true"></i>&nbsp;<?= $kode_kel ?>
                        </h3>
                        <p>Daftar Anggota Kelompok :</p>
                        <div class="table-responsive">
                            <ul class="list-group">
                            	<?php 
                            		foreach ($dataMember as $member) {
                            			if ( $member->nbi != $this->session->userdata('nbi') ) {
                            				$status = $member->konfirmasi == 1 ? 'Menunggu Konfirmasi' : 'Anggota';
                            	?>
                            				<li class="list-group-item">
                            					<strong><?= $member->nbi ?></strong> - 
                            					<?= $member->nama .' (Status : '.$status. ')' ?>
                            				</li>
                            	<?php 
                            			}
                            		}
                            	?>
                               
                            </ul>
                        </div>
                        <p>
                        	<a href="javascript:void(0)" 
                        		data-kode_kel="<?= $kode_kel ?>" onclick="requestConfirmation(this)" data-status="1" 
                        		data-nbi="<?= $this->session->userdata('nbi') ?>" class="btn btn-primary" role="button">
                        		<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>&nbsp;
                        		Terima Permintaan
                        	</a> 
                        	<a href="javascript:void(0)" 
                        		data-kode_kel="<?= $kode_kel ?>" onclick="requestConfirmation(this)" data-status="0"
                        		data-nbi="<?= $this->session->userdata('nbi') ?>" class="btn btn-danger" role="button">
                        		<i class="fa fa-trash fa-lg" aria-hidden="true"></i>&nbsp;
                        		Hapus Permintaan
                        	</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	// for request confirmation
	// param obj to get attribute data
	function requestConfirmation(obj) {
		status = obj.getAttribute('data-status');
		nbi = obj.getAttribute('data-nbi');
		kode_kel = obj.getAttribute('data-kode_kel');

		if ( status == 1 ) {
			message = 'Yakin ingin gabung di kelompok '+ kode_kel +' ?';
		} else {
			message = 'Yakin ingin menghapus permintaan dari kelompok  '+ kode_kel +' ?';
		}

		if ( confirm(message) ) {

			$.ajax({
				url : "<?= base_url('participant/request/requestConfirmation') ?>",
				method : 'POST',
				data : 'nbi='+nbi+'&kode_kel='+kode_kel+'&status='+status,
				dataType : 'JSON',
				success : function(msg) {
					if ( msg == 1 ) {
						messageStatus = 'Batas waktu pemilihan kelompok sudah habis..';
					} else if ( msg == 2 ) {
						messageStatus = 'Kesalahan dalam proses.. Ulangi lagi';
					} else {
						messageStatus = 'Proses Berhasil..';
					}

					alert(messageStatus);
		            window.location.href = "<?= base_url('participant/dashboard') ?>";
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('Error : '+ textStatus);	
				}

			});
		}
	}

</script>

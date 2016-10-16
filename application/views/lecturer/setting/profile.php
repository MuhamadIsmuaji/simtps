<div class="page-title">
    <span class="title">Halaman Pengaturan Profil</span>
    <div class="description">Halaman ini digunakan untuk mengatur profil anda</div>
</div>
<div class="row">
	<div class="col-xs-12">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Profil Anda</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<?php 
					if ( isset($errorMessage) ) :
				?>
					<div class="<?= $divClass ?>" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?= $errorMessage ?>
					</div>
				<?php 
					endif;
				?>
	            <form class="form-horizontal" id="frm_update_sistem" action="<?= base_url('lecturer/setting/profile') ?>" method="post">
	                <div class="form-group">
	                    <label for="NPP" class="col-sm-2 control-label">NPP</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="npp" name="npp" placeholder="NPP" value="<?= $lecturerData->npp ?>" onkeypress="return numbersonly(this,event)" maxlength="15" required >  
	                    	<p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Nama" class="col-sm-2 control-label">Nama</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama"
								value="<?= $lecturerData->nama ?>" required>
	                    	<p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password Lama</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="pwd_lama" name="pwd_lama" placeholder="Password Lama Max 20 Karakter" maxlength="20" required>
	                    	 <p class="help-block" id="alert_pwd_lama"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password Baru</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="pwd_baru" name="pwd_baru" placeholder="Password Baru Max 20 Karakter" maxlength="20" required>
	                    	 <p class="help-block" id="alert_pwd_baru"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Ulangi Password Baru</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="repwd_baru" name="repwd_baru" placeholder="Ulangi Password Baru" maxlength="20" disabled required>
	                    	 <p class="help-block" id="alert_repwd_baru"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-sm-offset-2 col-sm-10">
	                        <button type="submit" id="btnUpdateProfile" class="btn btn-block btn-primary" disabled>Simpan</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
</div>

<script>

	$(function(){
		
		//pwd_baru
		$('#pwd_baru').on('keyup',function(){
			var pwd_baru = $(this).val();
			$('#repwd_baru').val('');
			$('#repwd_baru').prop('disabled',1);
			$('#alert_repwd_baru').html('');
			
			if ( pwd_baru.length < 1 ) {
				$('#alert_pwd_baru').html('');
				$('#btnUpdateProfile').prop('disabled',1);
				$('#repwd_baru').val('');
				$('#repwd_baru').prop('disabled',1);
			}

			var index = 0;
			while(index <= pwd_baru.length - 1) {
				if (pwd_baru.charAt(index) == ' ') {
					$('#alert_pwd_baru').html('<i style="color:red">Password tidak boleh mengandung spasi</i>');
					$('#btnUpdateProfile').prop('disabled',1);
					$('#repwd_baru').prop('disabled',1);
					$('#repwd_baru').val('');
					break;
				} else {
					$('#alert_pwd_baru').html('');
					$('#btnUpdateProfile').prop('disabled',1);
					$('#repwd_baru').prop('disabled',0);
				}
				index++;
			}
		});
		//pwd_baru

		//repwd_baru
		$('#repwd_baru').on('keyup',function(){
			var repwd_baru = $(this).val();
			var pwd = $('#pwd_baru').val();

			if ( repwd_baru != pwd ) {
				$('#btnUpdateProfile').prop('disabled',1);
				$('#alert_repwd_baru').html('<i style="color:red">Password tidak sama</i>');
			} else {
				$('#btnUpdateProfile').prop('disabled',0);
				$('#alert_repwd_baru').html('');
			}
		});
		//repwd_baru

		//form
		$('form#frm_update_sistem').on('submit',function(e){
			//e.preventDefault();
			$('#btnUpdateProfile').prop('disabled',1);
			$('#btnUpdateProfile').html('Processing...');
		});
		//form

	});// $(function)


</script>
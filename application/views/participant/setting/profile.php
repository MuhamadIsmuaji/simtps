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
	            <form class="form-horizontal"  action="<?= base_url('participant/profile') ?>" method="post">
	                <div class="form-group">
	                    <label for="#" class="col-sm-2 control-label">NBI</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nbi" name="nbi" placeholder="NBI" value="<?= $participant->nbi ?>" required />
	                        <input type="hidden" id="old_nbi" name="old_nbi" value="<?= $participant->nbi ?>" />
	                    	<p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Nama" class="col-sm-2 control-label">Nama</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required value="<?= $participant->nama ?>" />
	                    	<p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Nama" class="col-sm-2 control-label">Email</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required value="<?= $participant->email ?>" />
	                    	<p class="help-block" id="alert_email"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password Lama</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="pwd_lama" name="pwd_lama" placeholder="Password Lama Max 9 Karakter" maxlength="9" required />
	                    	 <p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password Baru</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="pwd_baru" name="pwd_baru" placeholder="Password Baru Max 9 Karakter" maxlength="11" required />
	                    	 <p class="help-block" id="alert_pwd_baru"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Ulangi Password Baru</label>
	                    <div class="col-sm-10">
	                        <input type="password" class="form-control" id="repwd_baru" name="repwd_baru" placeholder="Ulangi Password Baru" maxlength="11" disabled required />
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

<script type="text/javascript">
	var validasiEmail = 1;
	var validasiRePwd = 0;
	var validasiPwdBaru = 0;

	$(function(){

		//pwd_baru
		$('#pwd_baru').on('keyup',function(){
			var pwd_baru = $(this).val();
			$('#repwd_baru').val('');
			$('#repwd_baru').prop('disabled',1);
			$('#alert_repwd_baru').html('');
			
			if ( pwd_baru.length < 1 ) {
				$('#alert_pwd_baru').html('');
				validasiPwdBaru = 0;
				$('#repwd_baru').val('');
				$('#repwd_baru').prop('disabled',1);
			}

			var index = 0;
			while(index <= pwd_baru.length - 1) {
				if (pwd_baru.charAt(index) == ' ') {
					$('#alert_pwd_baru').html('<i style="color:red">Password tidak boleh mengandung spasi</i>');
					validasiPwdBaru = 0;
					$('#repwd_baru').prop('disabled',1);
					$('#repwd_baru').val('');
					break;
				} else {
					$('#alert_pwd_baru').html('');
					validasiPwdBaru = 1;
					$('#repwd_baru').prop('disabled',0);
				}
				index++;
			}

			checkSubmit();
		});

		$('#pwd_baru').focusout(function(){
			$('#pwd_baru').keyup();
		});
		//pwd_baru

		//repwd_baru
		$('#repwd_baru').on('keyup',function(){
			var repwd_baru = $(this).val();
			var pwd = $('#pwd_baru').val();

			if ( repwd_baru != pwd ) {
				validasiRePwd = 0;
				//$('#btnUpdateProfile').prop('disabled',1);
				$('#alert_repwd_baru').html('<i style="color:red">Password tidak sama</i>');
			} else {
				validasiRePwd = 1;
				//$('#btnUpdateProfile').prop('disabled',0);
				$('#alert_repwd_baru').html('');
			}
			checkSubmit();
		});

		$('#repwd_baru').focusout(function(){
			$('#repwd_baru').keyup();
		});
		//repwd_baru

		//form
		$('form#frm_update_sistem').on('submit',function(e){
			//e.preventDefault();
			$('#btnUpdateProfile').prop('disabled',1);
			$('#btnUpdateProfile').html('Processing...');
		});
		//form
		
		// validate email
		function validateEmail(email) {
		    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		    return re.test(email);
		}
		// validate email

		// check email field with keyup
		$('#email').keyup(function(){
			if(!$('#email').val()){
				$('#alert_email').html('');
				$('#alert_email').html('<i style="color:red">Masukkan alamat email<i>');
				validasiEmail = 0;
				//$('#btnUpdateProfile').prop('disabled',1);
			}else{
				if(validateEmail($('#email').val())){
					$('#alert_email').html('');
					validasiEmail = 1;
					//$('#btnUpdateProfile').prop('disabled',0);
				}else{
					$('#alert_email').html('');
					$('#alert_email').html('<i style="color:red">Maaf, email tidak valid<i>');
					validasiEmail = 0;
					//$('#btnUpdateProfile').prop('disabled',1);
				}
			}

			checkSubmit();
		});
		// check email field with keyup
		
		// check email with focusout
		$('#email').focusout(function(){
			$('#email').keyup();
		});
		// check email with focusout
		
		function checkSubmit() {
			if ( validasiEmail && validasiRePwd && validasiPwdBaru) {
				$('#btnUpdateProfile').prop('disabled',0);
			} else {
				$('#btnUpdateProfile').prop('disabled',1);
			}

			//console.log(validasiEmail+'-'+validasiRePwd+'-'+validasiPwdBaru);
		} 
		

	}); //$function
</script>
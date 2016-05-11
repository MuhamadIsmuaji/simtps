<style type="text/css">
	.panel-heading span {
		margin-top: -20px;
		font-size: 15px;
	}

	.clickable{
    	cursor: pointer;   
	}

	.flat-blue .panel.panel-primary .panel-heading {
		background-color: #353d47;
	}

	.panel .panel-heading {
    	border-radius: 0px;
	}

	.panel-title {
		font-size: 1.5em;
	}
</style>

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Halaman Pengaturan Sistem</span>
    		<div class="description">Halaman ini digunakan untuk mengatur sistem</div>
   		 </div>
   </div>
</div>

<div class="row">
	<!-- Detail Pengaturan Sistem -->
	<div class="col-md-4">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Detail Pengaturan Sistem</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<?php 
                    if ( isset($errorMessage) ) :
                ?>
                  	<div class="row">
		        		<div class="col-sm-12">
		        			<div class="<?= $divClass ?>" role="alert">
	                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                            </button>
	                            <?= $errorMessage ?> 
                        	</div>
		        		</div>
	        		</div>
                <?php 
                    endif;
                ?>
				<ul class="list-group">
					<li class="list-group-item active">Dekan Fakultas Teknik</li>
					<li class="list-group-item"><?= $settingData->nama_dekan ?> | NPP : <?= $settingData->npp_dekan ?></li>
					
					<li class="list-group-item active">Kepala Laboratorium</li>
					<li class="list-group-item"><?= $settingData->nama_kalab ?> | NPP : <?= $settingData->npp_kalab ?> </li>
					
					<li class="list-group-item active">Periode</li>
					<li class="list-group-item">
						Tahun Ajaran
						<?php
							$smt = $settingData->smt == 1 ? 'Ganjil' : 'Genap';
							$next = $settingData->thn_ajaran+1;
							$bts_judul = new DateTime($settingData->bts_judul);
							$bts_kelompok = new DateTime($settingData->bts_kelompok);
							$bts_proposal = new DateTime($settingData->bts_proposal);
							$bts_revisi = new DateTime($settingData->bts_revisi);
							$tgl_surattgs = new DateTime($settingData->tgl_surattgs);							
							echo $settingData->thn_ajaran .' / '. $next .' Semester '. $smt;
						?>
					</li>
					
					<li class="list-group-item active">Batas Waktu</li>
					<li class="list-group-item">Pengumpulan Judul | <?= $bts_judul->format('d-m-Y') ?></li>
					<li class="list-group-item">Pemilihan Kelompok | <?= $bts_kelompok->format('d-m-Y') ?></li>
					<li class="list-group-item">Pengumpulan Proposal | <?= $bts_proposal->format('d-m-Y') ?></li>
					<li class="list-group-item">Pengumpulan Revisi Proposal | <?= $bts_revisi->format('d-m-Y') ?></li>
					
					<li class="list-group-item active">Surat Tugas</li>
					<li class="list-group-item">Nomor Surat | <?= $settingData->no_surattgs ?></li>
					<li class="list-group-item">Tanggal Pembuatan | <?= $tgl_surattgs->format('d-m-Y') ?></li>
				</ul>
	        </div>
	    </div>
	</div>
	<!-- Detail Pengaturan Sistem -->

	<!-- Ubah Sistem -->
	<div class="col-md-8">
	    <div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Ubah Pengaturan Sistem</h3>
				<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
			</div>
			<div class="panel-body" style="display:none;">
				<form action="<?= base_url('admin/setting/system') ?>" method="POST" id="frmSettingSystem">
		        	<div class="row">
		        		<div class="col-sm-6">
	                        <div class="panel fresh-color panel-primary">
	                            <div class="panel-heading">Dekan Fakultas Teknik</div>
	                            <div class="panel-body">
	                        		<div class="form-group">
	                                    <label for="exampleInputEmail1">NPP</label>
	                                    <input type="text" class="form-control" id="npp_dekan" name="npp_dekan" placeholder="NPP" onkeypress="return numbersonly(this,event)">
	                                </div>
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Nama</label>
	                                    <input type="text" class="form-control" id="nama_dekan" name="nama_dekan" placeholder="Nama">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6">
	                        <div class="panel fresh-color panel-primary">
	                            <div class="panel-heading">Kepala Laboratorium</div>
	                            <div class="panel-body">
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">NPP</label>
	                                    <input type="text" class="form-control" id="npp_kalab" name="npp_kalab" placeholder="NPP" onkeypress="return numbersonly(this,event)">
	                                </div>
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Nama</label>
	                                    <input type="text" class="form-control" id="nama_kalab" name="nama_kalab" placeholder="Nama">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-6">
	                        <div class="panel fresh-color panel-primary">
	                            <div class="panel-heading">Periode</div>
	                            <div class="panel-body">
	                        		<div class="form-group">
	                                    <label for="exampleInputEmail1">Tahun Ajaran</label>
										<select class="form-control" name="thn_ajaran" id="thn_ajaran">
											<?php 
												$yearNow = date('Y');
												$yearBefore = $yearNow - 1;
												$yearNextTwo = $yearNow + 2;

												for ( $i=$yearBefore;$i<$yearNextTwo;$i++) {
													$next = $i+1;
													$selected = $i == $current_thn_ajaran ? 'Selected' : '';
													echo '<option value="'. $i .'"'. $selected .'>'. $i .' / '. $next .'</option>';
												}
											?>
										</select>
	                                </div>
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Semester</label>
	                                    <select class="form-control" name="smt" id="smt">
	                                    	<option value="1" <?= $current_smt == 1 ? 'Selected' : '' ?> >Semester Ganjil</option>
	                                    	<option value="2" <?= $current_smt == 2 ? 'Selected' : '' ?> >Semester Genap</option>
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-sm-6">
	                        <div class="panel fresh-color panel-primary">
	                            <div class="panel-heading">Surat Tugas</div>
	                            <div class="panel-body">
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Nomor Surat</label>
	                                    <input type="text" class="form-control" id="no_surattgs" name="no_surattgs" placeholder="Nomor Surat">
	                                </div>
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Tanggal Surat</label>
	                                    <input type="text" class="form-control" id="tgl_surattgs" name="tgl_surattgs" placeholder="Tanggal Surat">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-12">
	                        <div class="panel fresh-color panel-primary">
	                            <div class="panel-heading">Batas Waktu</div>
	                            <div class="panel-body">
	                        		<div class="row">
	                        			<div class="col-sm-6">
	                        				<div class="form-group">
			                                    <label for="exampleInputEmail1">Pengumpulan Judul</label>
			                                    <input type="text" class="form-control" id="bts_judul" name="bts_judul" placeholder="Pengumpulan Judul">
			                                </div>
	                        			</div>
	                        			<div class="col-sm-6">
	                        				<div class="form-group">
			                                    <label for="exampleInputEmail1">Pemilihan Kelompok</label>
			                                    <input type="text" class="form-control" id="bts_kelompok" name="bts_kelompok" placeholder="Pemilihan Kelompok">
			                                </div>
	                        			</div>
	                        		</div>
	                        		<div class="row">
	                        			<div class="col-sm-6">
	                        				<div class="form-group">
			                                    <label for="exampleInputEmail1">Pengumpulan Proposal</label>
			                                    <input type="text" class="form-control" id="bts_proposal" name="bts_proposal" placeholder="Pengumpulan Proposal">
			                                </div>
	                        			</div>
	                        			<div class="col-sm-6">
	                        				<div class="form-group">
			                                    <label for="exampleInputEmail1">Pengumpulan Revisi Proposal</label>
			                                    <input type="text" class="form-control" id="bts_revisi" name="bts_revisi" placeholder="Pengumpulan Revisi Proposal">
			                                </div>
	                        			</div>
	                        		</div>
	                            </div>
	                        </div>
	                    </div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-6"><input type="submit" name="btnCreatePeriode" class="btn btn-block btn-primary" value="Buat Periode"></div>
		        		<div class="col-sm-6"><input type="submit" name="btnSavePeriode" class="btn btn-block btn-primary" value="Simpan Periode"></div>
		        	</div>
	        	</form>
			</div>
		</div>
	</div>
	<!-- Ubah Sistem -->
</div>

<script>
	$(function(){

		// panel form edit
		$('.panel-heading span.clickable').on('click',function(){
			var $this = $(this);
			if(!$this.hasClass('panel-collapsed')) {
				$this.parents('.panel').find('.panel-body').slideUp();
				$this.addClass('panel-collapsed');
				$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
			} else {
				$this.parents('.panel').find('.panel-body').slideDown();
				$this.removeClass('panel-collapsed');
				$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
			}
		});
		// panel form edit
		
		// datepicker
			$('#tgl_surattgs').datetimepicker({
				format : 'DD-MM-YYYY'
			})

			$('#bts_judul').datetimepicker({
				format : 'DD-MM-YYYY'
			});

			$('#bts_kelompok').datetimepicker({
				format : 'DD-MM-YYYY'
			});

			$('#bts_proposal').datetimepicker({
				format : 'DD-MM-YYYY'
			});

			$('#bts_revisi').datetimepicker({
				format : 'DD-MM-YYYY'
			});
		// datepicker

	});// $ function
</script>



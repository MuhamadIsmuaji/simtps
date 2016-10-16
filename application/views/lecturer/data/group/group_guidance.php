<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    $judul = $dataGroup->judul == NULL ? '-' : $dataGroup->judul;
	$proposal = $dataGroup->proposal == NULL ? '-' : $dataGroup->proposal;
	$revisi = $dataGroup->revisi == NULL ? '-' : $dataGroup->revisi;
	$validasi = $dataGroup->validasi == 1 ? 'Disetujui' : 'Belum Disetujui'; 
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                    	<?= $dataGroup->kode_kel.' - Tahun Ajaran '.$settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="step">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="step" class="active">
                            <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                <div class="icon fa fa-list-alt"></div>
                                <div class="step-title">
                                    <div class="title">Data Bimbingan</div>
                                    <div class="description">Validasi bimbingan dan Detail Bimbingan.</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-star"></div>
                                <div class="step-title">
                                    <div class="title">Penilaian Bimbingan</div>
                                    <div class="description">Penilaian Dari Aktivitas Bimbingan.</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                            <div class="table-responsive">
				        		<table id="tbGroupListsLecturer" class="table table-hover" cellspacing="0" width="100%">
				                    <thead>
				                        <tr>
				                            <th>Ke</th>
				                            <th>Uraian Peserta</th>
				                            <th>Uraian Dosen</th>
				                            <th>Tanggal</th>
				                            <th>#</th>
				                            <th><input type="checkbox" id="cbAllGuidance" onclick="validasiAll()" /></th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    	<?php
				                    		$banyak = 0;
				                    		$cb = 1; 
				                    		foreach ($guidanceData as $guidance) {
				                    			$tgl = new DateTime($guidance->tgl);
				                    			if ( $guidance->validasi == 1 ) {
				                    				$checkGuidance = 'Valid';
				                    			} else {
				                    				$checkGuidance = '<input type="checkbox" id="cbGuidance'. $cb .'" value="'.$guidance->nou.'" onclick="checkSomeGuidance()" />'; 
				                    				$banyak++;
				                    				$cb++;
				                    			}

				                    			$uraian_dosen = '<a 
			                    					href="'. base_url('lecturer/data/group/addUraian/'.$settingData->thn_ajaran.'/'.$settingData->smt.'/'.$guidance->kode_kel.'/'.$guidance->nou) .'"
			                    					class="btn btn-primary" >
													<strong>Uraian Dosen</strong>
			                    				</a>';
				                    	?>
											<tr>
												<td><?= $guidance->nou ?></td>
												<td><?= $guidance->uraian ?></td>
												<td><?= $guidance->uraian_dosen ?></td>
												<td><?= $tgl->format('d-m-Y') ?></td>
												<td><?= $uraian_dosen ?></td>
												<td><?= $checkGuidance ?></td>
											</tr>
				                    	<?php 
				                    		}
				                    	?>
				                    </tbody>
								</table>
								<input type="hidden" id="banyak" value="<?= $banyak ?>" />
								<input type="hidden" id="kode_kel" value="<?= $dataGroup->kode_kel ?>" />
								<input type="hidden" id="thn_ajaran" value="<?= $dataGroup->thn_ajaran ?>" />
								<input type="hidden" id="smt" value="<?= $dataGroup->smt ?>" />
	        				</div>
	        				<div class="sub-title"></div>
			                <div class="text-indent">
			                    <button type="button" id="validasi" onclick="validasi()" class="btn btn-primary" disabled>
			                    	<i class="fa fa-check-square fa-lg" aria-hidden="true"></i>&nbsp;
			                    	<strong>Validasi Bimbingan</strong>
			                    </button>
			                </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">
                            <div class="table-responsive">
				        		<table id="tbGroupListsLecturer" class="table table-striped" cellspacing="0" width="100%">
				                    <thead>
				                        <tr>
				                            <th>NBI</th>
				                            <th>Nama</th>
				                            <th>Nilai Bimbingan</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    	<?php 
				                    		$input_nilai = 1;
				                    		$banyak_nilai = 0;
			                         		foreach ($groupMember as $member) {
			                         	?>
											<tr>
												<td><?= $member->nbi ?></td>
												<td><?= $member->nama ?></td>
												<td>
													<input type="text" data-nbi="<?= $member->nbi ?>" 
													id="inputNilai<?= $input_nilai ?>" value="<?= $member->nilai_bimb ?>"onkeypress="return numbersonly(this,event)" size="4" 
													style="text-align: center;" />
												</td>
											</tr>
			                         	<?php
			                         			$input_nilai++; 
			                         			$banyak_nilai++;
			                         		}
			                         	?>
				                    </tbody>
								</table>
								<input type="hidden" id="banyak_nilai" value="<?= $banyak_nilai ?>" />
	        				</div>
	        				<div class="sub-title"></div>
			                <div class="text-indent">
			                    <button type="button" id="simpanNilai" onclick="nilai();" class="btn btn-primary" >
			                    	<strong>Simpan Nilai</strong>
			                    </button>
			                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var total_data;
	var total_data_nilai;

	$(function(){
		/*Data Bimbingan*/
			total_data = $('#banyak').val();
			total_data_nilai = $('#banyak_nilai').val();

			if ( total_data == 0 ) {
				$('#cbAllGuidance').prop('disabled',1);
			}
			else {
				$('#cbAllGuidance').prop('disabled',0);
			}

			$('#validasi').prop('disabled',1);
		/*Data Bimbingan*/

		/*Data Penilaian Bimbingan*/
      	$('#simpanNilai').prop('disabled',0);
      	$('#simpanNilai').html('<i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i>&nbsp;<strong>Simpan Nilai</strong>');
      	if ( total_data_nilai == 0 ) {
			$('#simpanNilai').prop('disabled',1);
		} else {
			$('#simpanNilai').prop('disabled',0);
		}
		/*Data Penilaian Bimbingan*/

	}); // $function

	/*Data Bimbingan*/
	// validation for all guidance
	function validasiAll() {
		if($('#cbAllGuidance').prop('checked')){
	      $('#validasi').prop('disabled',0);
	      for (i = 1; i <=total_data; i++) {
	        $('#cbGuidance'+i).prop('checked',true);
	      }
	    }else{
	      $('#validasi').prop('disabled',1);
	      for (i = 1; i <=total_data; i++) {
	        $('#cbGuidance'+i).prop('checked',false)
	      }
	    }
	}
	// validation for all guidance
	
	// when some validation checked
	function checkSomeGuidance() {
		status = 0
	    for(i=1; i<=total_data; i++){
	      if($('#cbGuidance'+i).prop('checked')){
	        status = eval(status)+1;
	      }
	    }
	    //console.log(status);

	    if(status == total_data){
	      $('#cbAllGuidance').prop('checked',true)
	    }else{
	      $('#cbAllGuidance').prop('checked',false) 
	    }

	    if(status>0){
	      $('#validasi').prop('disabled',0);
	    }else{
	      $('#validasi').prop('disabled',1);
	    }
	}
	// when some validation checked
	
	// when validasi bimbingan clicked
	function validasi() {
		indekId = 1;
	    total = 0
	    ids = new Array();    
	    for(i=1; i<=total_data; i++){
	      if($('#cbGuidance'+i).prop('checked')){
	        total++;
	        ids[indekId] = $('#cbGuidance'+i).val()
	        indekId++;
	      }
	    }
      
    	validationProcess(total,ids,1)
	}
	// when validasi bimbingan clicked
	
	// validation process
	function validationProcess(n, obj, status) {
		var kode_kel = $('#kode_kel').val();
		var thn_ajaran = $('#thn_ajaran').val();
		var smt = $('#smt').val();

		serializeId = 'kode_kel='+ kode_kel +'&smt='+ smt +'&thn_ajaran='+ thn_ajaran +'&jml='+n+'&';
	    for(i=1;i<=n;i++){
	      if(i==n){
	        serializeId+='nou'+(i)+'='+obj[i];
	      }else{
	        serializeId+='nou'+(i)+'='+obj[i]+'&';
	      }
	    }

    	window.location.href = "<?= base_url('lecturer/data/group/guidanceValidationProcess') ?>?" + serializeId;
	}
	// validation process        
	/*Data Bimbingan*/

	/*Data Penilaian Bimbingan*/
	function nilai() {
		var kode_kel = $('#kode_kel').val();
		var thn_ajaran = $('#thn_ajaran').val();
		var smt = $('#smt').val();

		serializeIdNilai = 'kode_kel='+ kode_kel +'&smt='+ smt +'&thn_ajaran='+ thn_ajaran +'&jml='+total_data_nilai+'&';
   
	    for(i=1; i<=total_data_nilai; i++){
	      if(i==total_data_nilai){
	        serializeIdNilai+='data'+(i)+'='+$('#inputNilai'+i).attr('data-nbi')+','+$('#inputNilai'+i).val();
	      }else{
	        serializeIdNilai+='data'+(i)+'='+$('#inputNilai'+i).attr('data-nbi')+','+$('#inputNilai'+i).val()+'&';
	      }
	    }
      	
      	$('#simpanNilai').prop('disabled',1);
      	$('#simpanNilai').html('Processing...');
    	window.location.href = "<?= base_url('penilaian/penilaianBimbingan') ?>?" + serializeIdNilai;
    	//console.log(serializeIdNilai);
	}
	/*Data Penilaian Bimbingan*/

</script>

<style type="text/css">

    .ui-autocomplete {
        max-height: 250px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        padding-right: 20px;
    }


    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    html .ui-autocomplete {
        height: 200px;
    }

</style>

<?php
	$next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    $batasJudul = new DateTime($settingData->bts_judul);
    $batasProposal = new DateTime($settingData->bts_proposal);
    $batasRevisi = new DateTime($settingData->bts_revisi);
    $batasKelompok = new DateTime($settingData->bts_kelompok);
    $now = date('Y-m-d');
    
    $judul = $kelompok->judul == NULL ? '-' : $kelompok->judul;
    $validasi = $kelompok->validasi == 1 ? 'Disetujui' : 'Belum Disetujui';

    $proposal = $kelompok->proposal == NULL ? '-' : $kelompok->proposal;
    $revisi = $kelompok->revisi == NULL ? '-' : $kelompok->revisi;

    $downloadProposal = $kelompok->proposal == NULL ? '-' : '<a href="'. base_url('participant/group/downloadGroupDocument/1/'.$kelompok->proposal).'" target="_blank"><i class="fa fa-cloud-download fa-lg"></i></a>';
    $downloadRev = $kelompok->revisi == NULL ? '-' : '<a href="'. base_url('participant/group/downloadGroupDocument/2/'.$kelompok->revisi).'" target="_blank"><i class="fa fa-cloud-download fa-lg"></i></a>';

    $uploadProposal = $settingData->bts_proposal >= $now ? '<a href="javascript:void(0)" onclick="showUploadFileModal(1)"><i class="fa fa-cloud-upload fa-lg"></i></a>' : '-';
    $uploadRev = $settingData->bts_revisi >= $now ? '<a href="javascript:void(0)" onclick="showUploadFileModal(2)"><i class="fa fa-cloud-upload fa-lg"></i></a>' : '-';

    $btnExitGroup = $settingData->bts_kelompok >= $now ?'<button type="button" id="btnExitGroup" onclick="exitGroup(this)" data-nbi="'. $this->session->userdata('nbi') .'" 
    	data-thn_ajaran = "'. $kelompok->thn_ajaran .'" data-smt = "'. $kelompok->smt .'" 
    	data-kode_kel = "'. $kelompok->kode_kel .'" class="btn btn-danger">
    	<i class="fa fa-user-times fa-lg" aria-hidden="true"></i>&nbspKeluar Dari Kelompok</button>' : ''; 

    $btnInvite = $settingData->bts_kelompok >= $now && $banyak < 3 ?'<button type="button" id="btnInvite" onclick="inviteMember()" class="btn btn-primary">
    	<i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>&nbspUndang Anggota</button>' : '';    
?>

<div class="page-title">
    <span class="title"><?= $kode_kel ?></span>
    <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
</div>
<div class="row">
	<!-- Data Kelompok -->
	<div class="col-md-6">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Kelompok</div>
	            </div>
	            <div class="pull-right card-action">
	        		<?php 
	        			if ( $settingData->bts_judul >= $now ) {
	        		?>
	        			<button type="button" id="showInputTitle" onclick="showInputTitleModal()" visible="false" class="btn btn-primary">
	        			<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>&nbsp;Input Judul
	        			</button>
	        		<?php 

	        			}
	        		?>
	            </div>
	        </div>
	        <div class="card-body">
	            <ul class="list-group">
					<li class="list-group-item active">Dosen Pemimbing</li>
					<li class="list-group-item"><?= $kelompok->nama ?></li>
					<input type="hidden" id="kode_kel" value="<?= $kode_kel ?>" />
					
					<li class="list-group-item active">Judul</li>
					<li class="list-group-item"><?= $judul ?></li>
					
					<li class="list-group-item active">Status</li>
					<li class="list-group-item"><?=  $validasi ?></li>
					<li class="list-group-item active">Batas Waktu Input Judul</li>
					<li class="list-group-item"><?= $batasJudul->format('d-m-Y') ?></li>
				</ul>
	        </div>
	    </div>
	</div>
	<!-- Data Kelompok -->	
	
	<!-- Data Dokumen Kelompok -->
	<div class="col-md-6">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Dokumen Kelompok</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbLecturerListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>No</th>
	                            <th>Jenis Dokumen</th>
	                            <th>Nama Dokumen</th>
	                            <th>Unduh</th>
	                            <th>Unggah</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<tr>
	                    		<td>1</td>
	                    		<td>Proposal</td>
	                    		<td><?= $proposal ?></td>
	                    		<td><?= $downloadProposal ?></td>
	                    		<td><?= $uploadProposal ?></td>
	                    	</tr>
	                    	<tr>
	                    		<td>2</td>
	                    		<td>Revisi Proposal</td>
	                    		<td><?= $revisi ?></td>
	                    		<td><?= $downloadRev ?></td>
	                    		<td><?= $uploadRev ?></td>
	                    	</tr>
	                    </tbody>
					</table>
	        	</div>
	        	<div class="sub-title">Batas Waktu Upload Dokumen</div>
                <div class="text-indent">
                    <ul class="list-group">
                    	<li class="list-group-item">Proposal : <?= $batasProposal->format('d-m-Y') ?></li>
                    	<li class="list-group-item">Revisi Proposal : <?= $batasRevisi->format('d-m-Y') ?></li>
                    </ul> 
                </div>
	        </div>
	    </div>
	</div>
	<!-- Data Dokumen Kelompok -->
</div>

<div class="row">
	<!-- Data Anggota Kelompok -->
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Anggota Kelompok</div>
	                <div class="title">
	                	<h5>Batas waktu pemilihan kelompok : <?= $batasKelompok->format('d-m-Y') ?>
	                	</h5>
	                </div>
	            </div>
	            <div class="pull-right card-action">
	        		<?= $btnInvite ?>
	        		<?= $btnExitGroup ?>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbLecturerListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>NO</th>
	                            <th>NBI</th>
	                            <th>Nama</th>
	                            <th>Nilai</th>
	                            <th>Status</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php 
	                    		$no = 1;
	                    		foreach ($dataMember as $member) {
							    	$status = $member->konfirmasi == 1 ? 'Menunggu konfirmasi' : 'Anggota';
	                    	?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $member->nbi ?></td>
									<td><?= $member->nama ?></td>
									<!--<td><?= $member->nilai_huruf ?></td>-->
                                  	<td><?= 'Proses Input Nilai' ?></td>
									<td><?= $status ?></td>
								</tr>
	                    	<?php
                    				$no++;
	                    		} // end foreach
	                    	?>
	                    </tbody>
					</table>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- Data Anggota Kelompok -->
</div>

<!-- Modal -->
<?php $this->load->view('participant/group_data/input_title_modal'); ?>
<?php $this->load->view('participant/group_data/input_file_modal'); ?>
<?php $this->load->view('participant/group_data/invite_member_modal'); ?>
<!-- Modal -->

<script type="text/javascript">
	$(function(){
		inviteMemberAutoComplete();

		// frmInviteMemberAction
		$('#frmInviteMember').on('submit',function(e){
			e.preventDefault();
			nbijoin = $('#nbijoin').val();
			kode_kel = $('#kode_kel_modal_invite').val();

			$.ajax({
				url : "<?= base_url('participant/dashboard/inviteMember') ?>",
				method : 'POST',
				data : 'kode_kel='+kode_kel+'&nbijoin='+nbijoin,
				dataType : 'JSON',
				success : function(msg) {
					$('#nbijoin').val('');
	                $('#namajoin').val('');

					if ( msg == 0 ) {
						$('#inviteStatus').html('<strong><i>Processing...</i></strong>');

						setTimeout(function(){ 
							$('#inviteStatus').html('<strong><i>Undang anggota berhasil...</i></strong>');
		                    $('#btnInviteModal').html('Undang');
							$('#btnInviteModal').prop('disabled',0);
			                $('#btnCancelInviteModal').prop('disabled',0);
							$('#kode_kel_modal_invite').val('');

			                window.location.href = "<?= base_url('participant/dashboard') ?>";   
		                }, 3000);
					} else {
						$('#inviteStatus').html('<strong><i style="color:red;">Data peserta tidak ditemukan...</i></strong>');

						$('#btnInviteModal').html('Undang');
						$('#btnInviteModal').prop('disabled',0);
		                $('#btnCancelInviteModal').prop('disabled',0);
					}
				},
				beforeSend : function() {
					$('#btnInviteModal').html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspProcessing...');
	                //$('#inviteStatus').html('<strong><i>Processing...</i></strong>');
	                $('#btnInviteModal').prop('disabled',1);
	                $('#btnCancelInviteModal').prop('disabled',1);
				},
				error : function(jqXHR, textStatus, errorThrown) {
					$('#btnInviteModal').html('Undang');
	                $('#inviteStatus').html('<strong><i style="color:red;">Terjadi kesalahan... Reload browser anda...</i></strong>');
	                $('#btnInviteModal').prop('disabled',0);
	                $('#btnCancelInviteModal').prop('disabled',0);
	                $('#nbijoin').val('');
	                $('#namajoin').val('');
					$('#kode_kel_modal_invite').val('');
				}
			});
		});
	}); // $function

	// for invite member autocomplete
	function inviteMemberAutoComplete() {
		$("#nbijoin").autocomplete({
            minLength : 4,
            source: "<?= base_url('participant/dashboard/getParticipantAutoCompleteInviteNBI') ?>",
            focus: function(event, ui){
            	$( "#nbijoin" ).val( ui.item.label );
        		return false;
            },
            select: function(event, ui){ //event after choose the suggest
                $("#namajoin").val(ui.item.nama);
            }

        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
	      return $( "<li>" )
	        .append( "<a><h4>" + item.label + " - " + item.nama + "</h4></a>" )
	        .appendTo( ul );
	    };
	}

	//for show invite member modal
	function inviteMember() {
		$('#kode_kel_modal_invite').val($('#kode_kel').val());
		$('#invite_member_modal').modal('show');
	}

	// for exit group action
	// param obj for get thn_ajaran,smt,nbi,kode_kel
	function exitGroup(obj) {
		thn_ajaran = obj.getAttribute('data-thn_ajaran');
		smt = obj.getAttribute('data-smt');
		nbi = obj.getAttribute('data-nbi');
		kode_kel = obj.getAttribute('data-kode_kel');
		
		if ( confirm('Yakin Ingin Keluar Dari Kelompok ' + kode_kel +' ?') ) {
			$.ajax({
				url : "<?= base_url('participant/dashboard/exitGroup') ?>",
				data : 'thn_ajaran='+thn_ajaran+'&smt='+smt+'&nbi='+nbi+'&kode_kel='+kode_kel,
				method : 'POST',
				dataType : 'JSON',
				success : function(msg) {
					if ( msg == 1 ) {
						alert('Keluar kelompok gagal.. Batas waktu pemilihan kelompok sudah habis');
					} else if ( msg == 2 ) {
						alert('Keluar kelompok gagal.. Terjadi kesalahan proses data');
					} else {
						alert('Keluar kelompok berhasil..');
					}

					window.location.href = "<?= base_url('participant/dashboard') ?>";
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('Reload Browser Anda');
				}
			});
		}
	}

	// for showing input title modal
	function showInputTitleModal() {
		$('#input_title_modal').modal('show');
		$('#kode_kel_modal_title').val($('#kode_kel').val());
	}

	// for showing upload file modal
	// param code untuk jenis file
	function showUploadFileModal(code) {
		$('#input_file_modal').modal('show');
		label = code == 1 ? 'Unggah Proposal' : 'Unggah Revisi Proposal';
		$('#myModalLabelDocument').text(label);
		$('#code').val(code);
		$('#kode_kel_modal_file').val($('#kode_kel').val());
	}

	// for check file    
    function checkFile(oInput,event) {
      if(oInput.files[0].size > 50000000){ // 50 MB
          alert('Maaf, file terlalu besar!')
          oInput.value = "";
          return false;
      }else{
          var _validFileExtensions = [".docx", ".pdf"];
          if (oInput.type == "file") {
              var sFileName = oInput.value;
              if (sFileName.length > 0) {
                  var blnValid = false;
                  for (var j = 0; j < _validFileExtensions.length; j++) {
                      var sCurExtension = _validFileExtensions[j];
                          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                          blnValid = true;
                          break;
                      }
                  }                   
                  if (!blnValid) {
                      alert("Maaf, hanya mendukung tipe: " + _validFileExtensions.join(", "));
                      oInput.value = "";
                      return false;
                  } else {
                      $('#btnSubmitInputFile').focus();
                  }
              }
          }
          return true;
        }
    }
    //check file  
</script>
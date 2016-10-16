<?php 
	$thn_ajaran = $settingData->thn_ajaran;
	$next = $thn_ajaran+1;
	$smt = $settingData->smt == 1 ? 'Ganjil' : 'Genap';
	$bts_kelompok = new DateTime($settingData->bts_kelompok);

?>

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Daftar Kelompok</span>
    		<div class="description">
    			Praktikum Tugas Perancangan Sistem Tahun Ajaran <?= $thn_ajaran.' / '.$next.' Semester '. $smt ?>
    		</div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-12">
	 	<div class="alert alert-warning" role="alert">
            <h4>
            	<strong>
            		Anda belum memiliki kelompok. Batas akhir pemilihan kelompok sampai <?= $bts_kelompok->format('d-m-Y') ?>
            	</strong>
            </h4>
        </div>

	    <div class="card">
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbGroupListParticipant" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>Kode Kelompok</th>
	                            <th>Dosen Pembimbing</th>
	                            <th>#</th>
	                        </tr>
	                    </thead>
	                    <tbody></tbody>
					</table>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- Lists -->
</div>

<!-- modal file -->
<?php $this->load->view('participant/join_group/detail_group_modal'); ?>
<!-- modal file -->

<script type="text/javascript">
	var save_method;
    var table,total_data;
    var kode_kel,smt,thn_ajaran;

	$(function(){
		/*Datatable*/
		table = $('#tbGroupListParticipant').DataTable({
    			
			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "Kode Kelompok...",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "zeroRecords": "Data Kelompok Tidak Ditemukan",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "",
                "sProcessing": '<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...',
                "oPaginate":{
                	"sPrevious": "<",
                	"sNext": ">",
                }
            },

            "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Semua"]],
            
            "processing": true,
            "serverSide": true,

            "ajax" : {
                "url": "<?php echo base_url('participant/dashboard/groupListsParticipant');?>/",
                "type": "POST",
                "dataType" : "json",
                beforeSend: function(jqXHR, settings){
                    	
				},
            },

        }); 
		/*Datatable*/
	}); // $function

	// for show modal detail group
	// param obj get attr
	function showModalDetailGroup(obj) {
		var tableDetail = $("#memberList tbody");
		kode_kel = obj.getAttribute('data-kode_kel');
		thn_ajaran = obj.getAttribute('data-thn_ajaran');
		smt = obj.getAttribute('data-smt');
		$('#myModalLabelKodeKel').text('Detail Kelompok '+ kode_kel);
		$('#detail_group_modal').modal('show');

		$('#statusRegister').html('');
		$('#btnJoin').html('Gabung');
        $('#btnJoin').prop('disabled',0);
        $('#btnCancelJoin').prop('disabled',0);

		$.ajax({
			url : "<?= base_url('participant/dashboard/getDetailGroup') ?>",
			method : 'POST',
			data : 'kode_kel='+kode_kel+'&thn_ajaran='+thn_ajaran+'&smt='+smt,
			dataType : 'JSON',
			success : function(data) {
				doping = data.dataDoping;
                $('#memberList > tbody').html('');
				setTimeout(function(){ 
                    $('#status').html('<strong>Dosen Pembimbing : '+doping+'</strong>');
                    $.each(data.dataMember, function(idx, elem){
                        tableDetail.append("<tr><td>"+elem.nbi+"</td><td>"+elem.nama+"</td></tr>");
                    });

                    $('#btnJoin').html('Gabung');
                    $('#btnJoin').prop('disabled',0);     
                }, 2000);
			},
			beforeSend : function() {
				$('#btnJoin').html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspProcessing...');
                $('#status').html('<p>Processing...</p>');
                $('#btnJoin').prop('disabled',1);
                $('#memberList > tbody').html('');
			},
			error : function(jqXHR, textStatus, errorThrown) {
				$('#status').html('<p style="color:red;">Terjadi Kesalahan... Silahkan Reload Browser Anda...</p>');
                $('#memberList > tbody').html('');
                $('#btnJoin').html('Gabung');
                $('#btnJoin').prop('disabled',1);
			}
		});

		//console.log(thn_ajaran+'||'+kode_kel+'||'+smt);
	}

	// for registering user on some group
	function registeringOnGroup() {
		var nbi = <?= $this->session->userdata('nbi') ?>;
		$.ajax({
			url : "<?= base_url('participant/dashboard/registeringOnGroup') ?>",
			method : 'POST',
			data : 'nbi='+nbi+'&kode_kel='+kode_kel+'&thn_ajaran='+thn_ajaran+'&smt='+smt,
			dataType : 'JSON',
			success : function(msg) {
				
				if ( msg == 1) { // gagal, group sudah penuh
					$('#statusRegister').html('<p style="color:red;">Gagal.. Anggota kelompok sudah penuh</p>');
					$('#btnJoin').html('Gabung');
	                $('#btnJoin').prop('disabled',0);
	                $('#btnCancelJoin').prop('disabled',0);
				} else if ( msg == 2 ) { // gagal, kesalahan proses
					$('#statusRegister').html('<p style="color:red;">Gagal.. Silahkan Ulangi Lagi</p>');
					$('#btnJoin').html('Gabung');
	                $('#btnJoin').prop('disabled',0);
	                $('#btnCancelJoin').prop('disabled',0);
				} else { // sukses
					$('#statusRegister').html('<p style="color:green;">Sukses.. Anda tergabung dalam kelompok '+ kode_kel +'</p>');
					$('#btnJoin').html('Redirecting...');
	                $('#btnJoin').prop('disabled',1);
	                $('#btnCancelJoin').prop('disabled',1);

	                setTimeout(function(){
		                window.location.href = "<?= base_url('participant/dashboard') ?>"; 
				    	$('#statusRegister').html('');
						$('#btnJoin').html('Gabung');
		                $('#btnJoin').prop('disabled',0);
		                $('#btnCancelJoin').prop('disabled',0);
	                }, 4000);
				}
			},
			beforeSend : function() {
				$('#btnJoin').html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspRegistering...');
				$('#statusRegister').html('<p>Registering...</p>');
                $('#btnJoin').prop('disabled',1);
                $('#btnCancelJoin').prop('disabled',1);
			},
			error : function(jqXHR, textStatus, errorThrown) {
				$('#statusRegister').html('<p style="color:red;">Terjadi Kesalahan... Silahkan Reload Browser Anda...</p>');
                $('#btnJoin').html('Gabung');
                $('#btnJoin').prop('disabled',1);
                $('#btnCancelJoin').prop('disabled',0);
			}
		});
	}
</script>
<style type="text/css">
	button.btn-deial {
		margin: 0;
	}
</style>

<?php 
	$next = $settingData->thn_ajaran+1;
	$semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="page-title">
    <span class="title">
    	Halaman Data Peserta Praktikum
    </span>
    <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
</div>
<div class="row">
	<!-- Form -->
	<div class="col-md-4">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Form Data Peserta Praktikum</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div id="alert_box"></div>
	            <form class="form-horizontal" id="frmProcessParticipant" action="#">
	                <div class="form-group">
	                    <label for="NBI" class="col-sm-2 control-label">NBI</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nbi" name="nbi" placeholder="NBI" onkeypress="return numbersonly(this,event)" required>  
	                        <input type="hidden" class="form-control" id="old_nbi" name="old_nbi" >  
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Nama" class="col-sm-2 control-label">Nama</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Email" class="col-sm-2 control-label">Email</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="email" name="email" readonly>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="pwd" name="pwd" readonly>
	                    	<p class="help-block"><i>Password akan dibuat otomatis saat tambah peserta baru</i></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-sm-offset-2 col-sm-10">
	                        <button type="submit" id="btnProsesPeserta" class="btn btn-block btn-primary">Proses Data Peserta</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<!-- Form -->
	
	<!-- Lists -->
	<div class="col-md-8">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Peserta Praktikum</div>
	            </div>
	            <div class="pull-right card-action">
	        		<button type="button" id="deleteParticipantSelected" onclick="deleteParticipantSelected()" 
	        			visible="false" class="btn btn-warning">
	        			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>&nbsp;
	        			<strong>Hapus Terpilih</strong>
	        		</button>
	        		<button type="button" id="btnImportParticipant" onclick="showImportParticipantModal()" 
	        			visible="false" class="btn btn-primary">
	        			<i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i>&nbsp;
	        			<strong>Import Data</strong>
	        		</button>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbParticipantListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th><input type="checkbox" id="checkAllParticipant" onclick="selectAllParticipant()"></th>
	                            <th></th>
	                            <th>NBI</th>
	                            <th>NAMA</th>
	                            <th>AKSES</th>
	                            <th>#</th>
	                        </tr>
	                    </thead>
	                    <tbody></tbody>
					</table>
	        	</div>
	        	<div cLass="pull-left card-action" id="totalParticipant"></div>
	        </div>
	    </div>
	</div>
	<!-- Lists -->
</div>

<?php $this->load->view('admin/data/participant/confirm_delete_participant_modal'); ?>
<?php $this->load->view('admin/data/participant/import_participant_modal'); ?>

<script type="text/javascript">
	var save_method;
    var table,total_data;
    var maxThnAjaran,minThnAjaran;
    var inputThnAjaran, inputSemester = '';

	$(function(){
		$('#deleteParticipantSelected').hide();
		$('#checkAllParticipant').prop('checked',false);
		processParticipant();
		getJumlah();
		
		/*Datatable*/
		table = $('#tbParticipantListsAdmin').DataTable({

			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "NBI Peserta...",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "zeroRecords": "Maaf Data Peserta Tidak Ditemukan",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "",
                "sProcessing": '<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...',
                "oPaginate":{
                	"sPrevious": "<",
                	"sNext": ">",
                }
            },

            "columns": [
	            { "data": [0][2] },
	            {
	                "className":      'details-control',
	                "orderable":      false,
	                "data":           [0][2],
	                "defaultContent": ''
	            },
	            { "data": [0][3] },
	            { "data": [0][4] },
	            { "data": [0][5] },
	            { "data": [0][6] },

	        ],

            "aLengthMenu": [[10, 15, 20], [10, 15, 20]],
            
            "processing": true,
            "serverSide": true,

            "ajax" : {
                "url": "<?php echo base_url('admin/data/participant/participantListsAdmin');?>/",
                "type": "POST",
                "dataType" : "json",
            },

        }); 

        // Add event listener for opening and closing details
	    $('#tbParticipantListsAdmin tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = table.row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	        }
	        else {
	            // Open this row
	            row.child( format(row.data()) ).show();
	        }
	    } );

		table.on( 'xhr', function () {
		    var json = table.ajax.json();
		    total_data =  json.data.length;
		    if(!total_data){
		    	$('#checkAllParticipant').prop('disabled',1)
		    }else{
		    	$('#checkAllParticipant').prop('disabled',0)
		    }
		});	
		/*Datatable*/
		
	})// $ function

	//reload datatable
	function reload_table(){		
		table.ajax.reload(null,false);
		$('#checkAllParticipant').prop('checked',false);
		$.ajax({
			url: "<?= base_url('admin/data/participant/countParticipant') ?>",
			dataType : "json",
			success : function(msg) {
				$('#totalParticipant').html('<h4><strong>Total Peserta : ' + msg +'</strong></h4>');
			}
		});
	}
	//reload datatable

	//select all participant
	function selectAllParticipant(){
    	//total_cbnya();
		if($('#checkAllParticipant').prop('checked')){
    		$('#deleteParticipantSelected').show()
    		for (i = 1; i <=total_data; i++) {
	    		$('#cbParticipant'+i).prop('checked',true)
	    	}
    	}else{
    		$('#deleteParticipantSelected').hide()
	    	for (i = 1; i <=total_data; i++) {
	    		$('#cbParticipant'+i).prop('checked',false)
	    	}
	    }
    }
	//select all participant

	// Get Jumlah peserta
	function getJumlah() {
		$.ajax({
			url: "<?= base_url('admin/data/participant/countParticipant') ?>",
			dataType : "json",
			success : function(msg) {
				$('#totalParticipant').html('<h4><strong>Total Peserta : ' + msg +'</strong></h4>');
			}
		});
	}
	// Get Jumlah Get Jumlah peserta


	// show row details
	function format (d) {
	    // `d` is the original data object for the row
	    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
	        '<tr>'+
	            '<td>Kelompok</td>'+
	            '<td>:</td>'+
	            '<td>'+d[6]+'</td>'+
	        '</tr>'+
	        '<tr>'+
	            '<td>Nilai Akhir</td>'+
	            '<td>:</td>'+
	            '<td>'+d[7]+'</td>'+
	        '</tr>'+
	    '</table>';
	}
	// show row details

	//show participant detail on form
	function show(obj) {
		$('#nbi').val(obj.getAttribute('data-nbi'));
		$('#old_nbi').val(obj.getAttribute('data-nbi'));
		$('#nama').val(obj.getAttribute('data-nama'));
		$('#pwd').val(obj.getAttribute('data-pwd'));
		$('#email').val(obj.getAttribute('data-email'));
	}
	//show participant detail on form

	//reset form
	function resetForm() {
		$('#nbi').val('');
		$('#old_nbi').val('');
		$('#nama').val('');
		$('#pwd').val('');
		$('#email').val('');

	}
	//reset form

	//when some participant selected
    function checkParticipantSelected(){
    	//total_cbnya()    	
    	status = 0
    	for(i=1; i<=total_data; i++){
    		if($('#cbParticipant'+i).prop('checked')){
    			status = eval(status)+1;
    		}
    	}

    	if(status == total_data){
    		$('#checkAllParticipant').prop('checked',true)
    	}else{
    		$('#checkAllParticipant').prop('checked',false)	
    	}

    	if(status>0){
    		$('#deleteParticipantSelected').show()
    	}else{
    		$('#deleteParticipantSelected').hide()
    	}
    }
	//when some participant selected

	//delete participant selected
	function deleteParticipantSelected(){
		indekId = 1;
		total = 0
		ids = new Array();		
		for(i=1; i<=total_data; i++){
			if($('#cbParticipant'+i).prop('checked')){
				total++;
				ids[indekId] = $('#cbParticipant'+i).val()
				indekId++;
			}
		}
		deleteData(total,ids,1)
	}
	//delete participant selected

	//process delete data
	function deleteData(n,obj,status){
		serializeId = 'jml='+n+'&';
		for(i=1;i<=n;i++){
			if(i==n){
				serializeId+='nbi'+(i)+'='+obj[i];
			}else{
				serializeId+='nbi'+(i)+'='+obj[i]+'&';
			}
		}
		$('#confirm_delete_participant_modal').modal('show');
		$('#message_delete').html('<strong>Yakin Ingin Menghapus Sebanyak '+ n +' Data Peserta</strong>');

		$('#btnDeleteParticipant').on('click',function(){
			$.ajax({
				url 	 : "<?= base_url('admin/data/participant/processDeleteParticipant') ?>",
				data 	 : serializeId,
				type     : 'get',
				dataType : "json",
				success  : function(msg) {
					$('#message_delete').html('<strong>'+ msg +'</strong>');
					setTimeout(function(){ 
						$('#confirm_delete_participant_modal').modal('hide');
						$('#btnDeleteParticipant').prop('disabled',0);
						$('#btnDeleteParticipant').html('Hapus');
						$('#deleteParticipantSelected').hide();
						$('#checkAllParticipant').prop('checked',false);
					}, 2500);
					resetForm();
					reload_table();
				},
				beforeSend : function(jqXHR, settings) {
					$('#btnDeleteParticipant').prop('disabled',1);
					$('#btnDeleteParticipant').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
					$('#btnCancelDeleteParticipant').prop('disabled',1);
					$('#deleteParticipantSelected').hide();
				},
				error : function(jqXHR, textStatus, errorThrown) {
					setTimeout(function(){ 
						$('#message_delete').html('<strong>Terjadi Kesalahan : '+ errorThrown +'</strong>');
                        window.location.href = "<?= base_url('admin/data/participant') ?>";						
					}, 4000);
					resetForm();
					$('#deleteParticipantSelected').hide();
				}
			});
		});
	}
	//process delete data

	//processParticipant
	function processParticipant() {
		$('#frmProcessParticipant').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url : "<?= base_url('admin/data/participant/processParticipant') ?>",
				method : "POST",
				data : $(this).serialize(),
				dataType : "JSON",
				success : function(msg) {
					var cLass,message = '';
					if ( msg == 1) {
						// sukses
						cLass = 'alert fresh-color alert-success alert-dismissible';
    					message = 'Proses Berhasil.';
    					resetForm();
					} else {
						//gagal
						cLass = 'alert fresh-color alert-danger alert-dismissible';
    					message = 'Proses Gagal. Peserta Sudah Ada';
					}

					$('div#alert_box').html('<div class="'+ cLass +'" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ message +'</div>');
    				reload_table();

				},error : function(jqXHR, textStatus, errorThrown) {
					alert('Error when processing data.. Please reload the page..');
				}
			});
			//console.log('a');
		});
	}
	//processParticipant

	//showImportParticipantModal
	function showImportParticipantModal() {
		$('#import_participant_modal').modal('show');
	}
	//showImportParticipantModal


</script>
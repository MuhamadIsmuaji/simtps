<?php 
	$next = $settingData->thn_ajaran+1;
	$semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="page-title">
    <span class="title">
    	Halaman Data Kelompok Praktikum
    </span>
    <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
</div>
<div class="row">
	<!-- Form -->
	<div class="col-md-4">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Form Data Kelompok Praktikum</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div id="alert_box"></div>
	             <form id="frmCreateGroup" method="" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Kelompok</label>
                        <input type="text" class="form-control" id="kode_kel" name="kode_kel" placeholder="Kode Kelompok" readonly>
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dosen Pembimbing</label>
                        <input type="text" class="form-control" id="doping" name="doping" placeholder="Dosen Pembimbing" required>
                        <input type="hidden" class="form-control" id="npp" name="npp" placeholder="Dosen Pembimbing">
                    </div>
                    <div cLass="row">
                    	<div cLass="col-sm-6">
                    		<button type="submit" id="btnProsesGroup" class="btn btn-block btn-primary">Simpan</button>
                    	</div>
                    	<div cLass="col-sm-6">
		                    <button type="reset" onclick="resetForm();" class="btn btn-block btn-primary">Reset</button>
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
	                <div class="title">Data Kelompok Praktikum</div>
	            </div>
	            <div class="pull-right card-action">
	        		<button type="button" id="deleteGroupSelected" onclick="deleteGroupSelected()" visible="false" class="btn btn-warning">Hapus Terpilih</button>
	        		<button type="button" id="btnImportParticipant" onclick="showCreateGroupModal()" visible="false" class="btn btn-primary">Buat Kelompok</button>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbGroupListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th><input type="checkbox" id="checkAllGroup" onclick="selectAllGroup()"></th>
	                            <th>Kode Kelompok</th>
	                            <th>Tahun Ajaran</th>
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

<?php $this->load->view('admin/data/group/create_group_modal'); ?>
<?php $this->load->view('admin/data/group/confirm_delete_group_modal'); ?>

<script type="text/javascript">
	var save_method;
    var table,total_data;

	$(function(){
		getLecturerAutoComplete();
		getMaxCode();
		processGroup();
		createManyGroup();
		$('#deleteGroupSelected').prop('disabled',1);
		$('#many').val('');
		
		/*Datatable*/
		table = $('#tbGroupListsAdmin').DataTable({
    			
			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "Kode Kelompok...",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "zeroRecords": "Maaf Data Kelompok Tidak Ditemukan",
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
                "url": "<?php echo base_url('admin/data/group/groupListsAdmin');?>/",
                "type": "POST",
                "dataType" : "json",
	            beforeSend: function(jqXHR, settings){
	                	$('#checkAllGroup').prop('checked',0);
			    		$('#checkAllGroup').prop('disabled',1);
			    		$('#deleteGroupSelected').prop('disabled',1);
				},
            },

        }); 
		/*Datatable*/

		table.on( 'xhr', function () {
		    var json = table.ajax.json();
		    total_data =  json.data.length;
		    if(!total_data){
		    	$('#checkAllGroup').prop('disabled',1)
		    }else{
		    	$('#checkAllGroup').prop('disabled',0)
		    }
		});	

	}); // $function

	//select all group
	function selectAllGroup(){
    	//total_cbnya();

		if($('#checkAllGroup').prop('checked')){
			$('#deleteGroupSelected').prop('disabled',0);
    		for (i = 1; i <=total_data; i++) {
	    		$('#cbGroup'+i).prop('checked',true);
	    	}
    	}else{
    		$('#deleteGroupSelected').prop('disabled',1);
	    	for (i = 1; i <=total_data; i++) {
	    		$('#cbGroup'+i).prop('checked',false)
	    	}
	    }
    }
	//select all group

	//when some group selected
    function checkGroupSelected(){
    	//total_cbnya()    	
    	status = 0
    	for(i=1; i<=total_data; i++){
    		if($('#cbGroup'+i).prop('checked')){
    			status = eval(status)+1;
    		}
    	}

    	if(status == total_data){
    		$('#checkAllGroup').prop('checked',true)
    	}else{
    		$('#checkAllGroup').prop('checked',false)	
    	}

    	if(status>0){
    		$('#deleteGroupSelected').prop('disabled',0);
    	}else{
    		$('#deleteGroupSelected').prop('disabled',1);
    	}
    }
	//when some group selected

	//delete group selected
	function deleteGroupSelected(){
		indekId = 1;
		total = 0
		ids = new Array();		
		for(i=1; i<=total_data; i++){
			if($('#cbGroup'+i).prop('checked')){
				total++;
				ids[indekId] = $('#cbGroup'+i).val()
				indekId++;
			}
		}
		deleteData(total,ids,1)
	}
	//delete group selected

	//process delete data
	function deleteData(n,obj,status){
		serializeId = 'jml='+n+'&';
		for(i=1;i<=n;i++){
			if(i==n){
				serializeId+='kode_kel'+(i)+'='+obj[i];
			}else{
				serializeId+='kode_kel'+(i)+'='+obj[i]+'&';
			}
		}

		//console.log(serializeId);
		$('#confirm_delete_group_modal').modal('show');
		$('#message_delete').html('<strong>Yakin Ingin Menghapus Sebanyak '+ n +' Data Kelompok Praktikum</strong>');
		
		$('#btnDeleteGroup').on('click',function(){
			$.ajax({
				url 	 : "<?= base_url('admin/data/group/processDeleteGroup') ?>",
				data 	 : serializeId,
				type     : 'get',
				dataType : "json",
				success  : function(msg) {
					$('#message_delete').html('<strong>'+ msg +'</strong>');
					setTimeout(function(){ 
						$('#confirm_delete_group_modal').modal('hide');
						$('#btnDeleteGroup').prop('disabled',0);
						$('#btnDeleteGroup').html('Hapus');
						$('#btnCancelDeleteGroup').prop('disabled',0);
						reload_table(); 
					}, 2500);

				},
				beforeSend : function(jqXHR, settings) {
					$('#btnDeleteGroup').prop('disabled',1);
					$('#btnDeleteGroup').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
					$('#btnCancelDeleteGroup').prop('disabled',1);
				},
				error : function(jqXHR, textStatus, errorThrown) {
					setTimeout(function(){ 
						$('#message_delete').html('<strong>Terjadi Kesalahan : '+ errorThrown +'</strong>');
                        window.location.href = "<?= base_url('admin/data/group') ?>";						
					}, 4000);
				}
			});
		});
	}
	//process delete data

	// showCreateGroupModal
	function showCreateGroupModal() {
		$('#create_group_modal').modal('show');
		$.ajax({
			url : "<?= base_url('admin/data/group/countMakeGroup') ?>",
			dataType : "JSON",
			success : function(msg){
				if ( msg == 0 ) {
					var content = '<div class="alert fresh-color alert-danger" role="alert">' +
									'<strong>Jumlah kelompok sudah memadahi</strong>'+
									'</div>';
					$('#btnCreateGroup').prop('disabled',1);
				} else {
					var content = '<div class="alert fresh-color alert-success" role="alert">' +
									'<strong><h5>Sistem akan membuat sebanyak ' + msg + ' kelompok secara otomatis</h5></strong>'+
									'</div>';
					$('#many').val(msg);
					$('#btnCreateGroup').prop('disabled',0);
				}
				$('#content').html(content);
			}
		});
	}
	// showCreateGroupModal

	// Get max code
	function getMaxCode() {
		$.ajax({
			url : "<?= base_url('admin/data/group/getMaxCode') ?>",
			dataType : "JSON",
			success : function(maxCode) {
				$('#kode_kel').val('TPS'+maxCode);
			},	
		});
	}
	// Get max code

	// getLecturerAutoComplete
	function getLecturerAutoComplete() {
		$("#doping").autocomplete({
            minLength : 2,
            source: '<?php echo base_url() ?>admin/data/group/getLecturerAutoComplete', //data source
            focus: function(event, ui){
            	$( "#doping" ).val( ui.item.nama );
        		return false;
            },
            select: function(event, ui){ //event after choose the suggest
    			$("#npp").val(ui.item.npp);
            }

        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
	      return $( "<li>" )
	        .append( "<a><h4>"+ item.nama + "</h4></a>" )
	        .appendTo( ul );
	    };
	}
	// getLecturerAutoComplete

	// processGroup
	function processGroup() {
		$('#frmCreateGroup').on('submit',function(e){
			e.preventDefault();
			$.ajax({
    			url : "<?= base_url('admin/data/group/processGroup') ?>",
    			type : "post",
    			dataType : "json",
    			data : $(this).serialize(),
    			success : function(msg) {
    				var cLass,message = '';

    				if ( msg ) {
    					cLass = 'alert fresh-color alert-success alert-dismissible';
    					message = 'Proses Berhasil';
						$('#btnProsesDosen').html('Update');
    				} else  {
    					cLass = 'alert fresh-color alert-danger alert-dismissible';
    					message = 'Proses Gagal';
    				}

    				$('div#alert_box').html('<div class="'+ cLass +'" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ message +'</div>');
    				reload_table();
    				resetForm();
    				getMaxCode();
    			},
    			error: function (jqXHR, textStatus, errorThrown){
					alert('Error when processing data.. Please reload the page..');
				}
    		});
		});
	}
	// processGroup

	//reload data table
	function reload_table() {
		table.ajax.reload(null,false);
    	$('#checkAllGroup').prop('checked',0);
    	resetForm();
    	//total_cbnya()
    }
	//reload data table

	//function resetForm()
	function resetForm() {
		$('#kode_kel').val('');
		$('#doping').val('');
		$('#npp').val('');
		getMaxCode();
	}
	//function resetForm()

	//show
	function show(obj) {
		$('#kode_kel').val(obj.getAttribute('data-kode_kel'));
		$('#doping').val(obj.getAttribute('data-nmdosen'));
		$('#npp').val(obj.getAttribute('data-npp'));
	}
	//show

	// createManyGroup
	function createManyGroup() {
		$('#btnCreateGroup').on('click',function(){
			$.ajax({
				url : " <?= base_url('admin/data/group/createManyGroup') ?>",
				data : "many="+ $('#many').val(),
				method : "POST",
				dataType : "JSON",
				success : function(msg) {
					$('#btnCreateGroup').prop('disabled',0);
					$('#btnCreateGroup').html('Buat Kelompok');
					$('#btnCancelCreateGroup').prop('disabled',0);
					$('#many').val('');
					$('#create_group_modal').modal('hide');
					reload_table();
					resetForm();
					getMaxCode();
				},
				beforeSend : function(jqXHR, settings) {
					$('#btnCreateGroup').prop('disabled',1);
					$('#btnCreateGroup').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
					$('#btnCancelCreateGroup').prop('disabled',1);
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error when processing data.. Please reload the page..');
				}
			});
		});
	}
	// createManyGroup
</script>
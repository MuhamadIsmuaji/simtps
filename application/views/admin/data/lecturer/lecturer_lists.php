<style type="text/css">

    .ui-autocomplete {
        max-height: 180px;
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
        height: 180px;
    }

</style>

<div class="page-title">
    <span class="title">Halaman Data Dosen</span>
    <div class="description">Halaman ini digunakan untuk mengolah data dosen</div>
</div>
<div class="row">
	<!-- Form -->
	<div class="col-md-4">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Form Data Dosen</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div id="alert_box"></div>
	            <form class="form-horizontal" id="frmProcessLecturer" action="#">
	                <div class="form-group">
	                    <label for="NPP" class="col-sm-2 control-label">NPP</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="npp" name="npp" placeholder="NPP" onkeypress="return numbersonly(this,event)" required>  
	                        <input type="hidden" class="form-control" id="old_npp" name="old_npp" placeholder="NPP" onkeypress="return numbersonly(this,event)" required>  
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="Nama" class="col-sm-2 control-label">Nama</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
	                    	<p class="help-block"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
	                    <div class="col-sm-10">
	                        <input type="text" class="form-control" id="pwd" name="pwd" placeholder="Password Max 9 Karakter" maxlength="9" required>
	                    	 <p class="help-block" id="alert_pwd"></p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="inputPassword3" class="col-sm-2 control-label">Akses</label>
	                    <div class="col-sm-10">
	                    	<div class="radio3">
	                            <input type="radio" id="radio1" name="akses" value="0" checked>
	                            <label for="radio1">Dosen</label>
                            </div>
                            <div class="radio3">
	                            <input type="radio" id="radio2" name="akses" value="1"  >
	                            <label for="radio2">Dosen Pembimbing</label>
                            </div>
                            <div class="radio3">
	                            <input type="radio" id="radio3" name="akses" value="2"  >
	                            <label for="radio3">Admin / Kalab RPL</label>
                            </div>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-sm-offset-2 col-sm-10">
	                        <button type="submit" id="btnProsesDosen" class="btn btn-block btn-primary" disabled>
	                        	Tambah
	                        </button>
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
	                <div class="title">Data Dosen</div>
	            </div>
	            <div class="pull-right card-action">
	        		<button type="button" id="deleteLecturerSelected" onclick="deleteLecturerSelected()" visible="false" class="btn btn-warning">Hapus Terpilih</button>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbLecturerListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th><!-- <input type="checkbox" id="checkAllLecturer" onclick="selectAllLecturer()"> -->#</th>
	                            <th>NPP</th>
	                            <th>NAMA</th>
	                            <th>AKSES</th>
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

<?php $this->load->view('admin/data/lecturer/confirm_delete_lecturer_modal'); ?>

<script type="text/javascript">
	var save_method;
    var table,total_data;
    //var total_cb = 0;

	$(function(){
		formCorrection();
		getLecturerAutoComplete();
		getLecturerAutoCompleteName()
		processLecturer();

		$('#deleteLecturerSelected').hide();


		/*Datatable*/
		table = $('#tbLecturerListsAdmin').DataTable({
    			
			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "NPP, Nama Dosen...",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "zeroRecords": "Maaf Data Dosen Tidak Ditemukan",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "",
                "sProcessing": '<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...',
                "oPaginate":{
                	"sPrevious": "<",
                	"sNext": ">",
                }
            },

            "aLengthMenu": [[10, 15, 20], [10, 15, 20]],
            
            "processing": true,
            "serverSide": true,

            "ajax" : {
                "url": "<?php echo base_url('admin/data/lecturer/lecturerListsAdmin');?>/",
                "type": "POST",
                "dataType" : "json",
                beforeSend: function(jqXHR, settings){
                    	$('#checkAllLecturer').prop('checked',0);
			    		$('#checkAllLecturer').prop('disabled',1);
			    		$('#deleteLecturerSelected').hide(); // button
				},
            },

        }); 

        table.on( 'xhr', function () {
		    var json = table.ajax.json();
		});	
		/*Datatable*/

		table.on( 'xhr', function () {
		    var json = table.ajax.json();
		    total_data =  json.data.length;
		    if(!total_data){
		    	$('#checkAllLecturer').prop('disabled',1)
		    }else{
		    	$('#checkAllLecturer').prop('disabled',0)
		    }
		});	
	}); // $(function)

	// function total_cbnya(){
	// 	total_cb = 0;
	// 	for(var i=1 ; i<=total_data ; i++){
	// 		if($('#cbLecturer'+i).length){
	// 		   	total_cb++;
	// 		}
	// 	}
	// }

	//select all lecturer
	function selectAllLecturer(){
    	//total_cbnya();

		if($('#checkAllLecturer').prop('checked')){
    		$('#deleteLecturerSelected').show()
    		for (i = 1; i <=total_data; i++) {
	    		$('#cbLecturer'+i).prop('checked',true)
	    	}
    	}else{
    		$('#deleteLecturerSelected').hide()
	    	for (i = 1; i <=total_data; i++) {
	    		$('#cbLecturer'+i).prop('checked',false)
	    	}
	    }
    }
	//select all lecturer

	//when some lecturer selected
    function checkLecturerSelected(){
    	//total_cbnya()    	
    	status = 0
    	for(i=1; i<=total_data; i++){
    		if($('#cbLecturer'+i).prop('checked')){
    			status = eval(status)+1;
    		}
    	}

    	if(status == total_data){
    		$('#checkAllLecturer').prop('checked',true)
    	}else{
    		$('#checkAllLecturer').prop('checked',false)	
    	}

    	if(status>0){
    		$('#deleteLecturerSelected').show()
    	}else{
    		$('#deleteLecturerSelected').hide()
    	}
    }
	//when some lecturer selected

	//process delete data
	function deleteData(n,obj,status){
		serializeId = 'jml='+n+'&';
		for(i=1;i<=n;i++){
			if(i==n){
				serializeId+='npp'+(i)+'='+obj[i];
			}else{
				serializeId+='npp'+(i)+'='+obj[i]+'&';
			}
		}
		$('#confirm_delete_lecturer_modal').modal('show');
		$('#message_delete').html('<strong>Yakin Ingin Menghapus Sebanyak '+ n +' Data Dosen</strong>');
		
		$('#btnDeleteLecturer').on('click',function(){
			$.ajax({
				url 	 : "<?= base_url('admin/data/lecturer/processDeleteLecturer') ?>",
				data 	 : serializeId,
				type     : 'get',
				dataType : "json",
				success  : function(msg) {
					$('#message_delete').html('<strong>'+ msg +'</strong>');
					setTimeout(function(){ 
						$('#confirm_delete_lecturer_modal').modal('hide');
						$('#btnDeleteLecturer').prop('disabled',0);
						$('#btnDeleteLecturer').html('Hapus');
						$('#btnCancelDeleteLecturer').prop('disabled',0);
						reload_table(); 
					}, 2500);

				},
				beforeSend : function(jqXHR, settings) {
					$('#btnDeleteLecturer').prop('disabled',1);
					$('#btnDeleteLecturer').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
					$('#btnCancelDeleteLecturer').prop('disabled',1);
				},
				error : function(jqXHR, textStatus, errorThrown) {
					setTimeout(function(){ 
						$('#message_delete').html('<strong>Terjadi Kesalahan : '+ errorThrown +'</strong>');
                        window.location.href = "<?= base_url('admin/data/lecturer') ?>";						
					}, 4000);
				}
			});
		});
	}
	//process delete data

	//delete lecturer selected
	function deleteLecturerSelected(){
		indekId = 1;
		total = 0
		ids = new Array();		
		for(i=1; i<=total_data; i++){
			if($('#cbLecturer'+i).prop('checked')){
				total++;
				ids[indekId] = $('#cbLecturer'+i).val()
				indekId++;
			}
		}
		deleteData(total,ids,1)
	}
	//delete lecturer selected

	//show lecturer detail
	function show(obj){
		$('#alert_pwd').html('');
		$('#btnProsesDosen').prop('disabled',0);
		$('#btnProsesDosen').html('Update');
		$('#npp').val(obj.getAttribute('data-npp'));
		$('#old_npp').val(obj.getAttribute('data-old'));
		$('#nama').val(obj.getAttribute('data-nama'));
		$('#pwd').val(obj.getAttribute('data-pwd'));
		var who = obj.getAttribute('data-akses');
		
		if ( who == 1 )
			$('input:radio[id=radio2]').prop('checked', true);
		else
			$('input:radio[id=radio1]').prop('checked', true);

	}
	//show lecturer detail

	//reload data table
	function reload_table() {
		table.ajax.reload(null,false);
    	$('#checkAllLecturer').prop('checked',0);
    	//total_cbnya()
    }
	//reload data table

	//processLecturer
    function processLecturer() {
    	$('#frmProcessLecturer').on('submit',function(e){
    		e.preventDefault();
    		$.ajax({
    			url : "<?= base_url('admin/data/lecturer/processLecturer') ?>",
    			type : "post",
    			dataType : "json",
    			data : $(this).serialize(),
    			success : function(msg) {
    				var cLass,message = '';

    				if ( msg == 0 ) {
    					cLass = 'alert fresh-color alert-danger alert-dismissible';
    					message = 'Proses gagal.. npp sudah ada';
						$('#btnProsesDosen').html('Update');
    				} else if ( msg == 1 ) {
    					cLass = 'alert fresh-color alert-success alert-dismissible';
    					message = 'Proses Insert berhasil..';
    					resetForm();
    				} else {
    					cLass = 'alert fresh-color alert-success alert-dismissible';
    					message = 'Proses Update berhasil..';
    					resetForm();
    				}

    				$('div#alert_box').html('<div class="'+ cLass +'" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ message +'</div>');
    				reload_table();
    			},
    			error: function (jqXHR, textStatus, errorThrown){
					alert('Error when processing data.. Please reload the page..');
				}
    		});
    	});
    }
	//processLecturer

	//form correction
	function formCorrection() {

		$('#pwd').on('keyup',function() {
			var pwd = $(this).val();
			var index = 0;
			while( index <= pwd.length - 1 ) {
				if (pwd.charAt(index) == ' ') {
					$('#alert_pwd').html('<i style="color:red">Password tidak boleh mengandung spasi</i>');
					$('#btnProsesDosen').prop('disabled',1);
					break;
				} else {
					$('#alert_pwd').html('');
					$('#btnProsesDosen').prop('disabled',0);
				}
				index++;
			}
		});
	}
	//form correction

	//lecturer autocomplete
	function getLecturerAutoComplete() {
		$("#npp").autocomplete({
            minLength : 2,
            source: '<?php echo base_url() ?>admin/data/lecturer/getLecturerAutoComplete', //data source
            focus: function(event, ui){
            	$( "#nbi" ).val( ui.item.label );
        		return false;
            },
            select: function(event, ui){ //event after choose the suggest
                $("#nama").val(ui.item.nama);
                $('#old_npp').val(ui.item.npp);
                $("#pwd").val(ui.item.pwd);
                $('#alert_pwd').html('');
				$('#btnProsesDosen').prop('disabled',0);
				$('#btnProsesDosen').html('Update');

                if (ui.item.akses == 0) // jika dosen biasa
                	$('input:radio[id=radio1]').prop('checked', true);
                else if (ui.item.akses == 1)// jika dosen pembimbing
                	$('input:radio[id=radio2]').prop('checked', true);
                else // jika admin
                	$('input:radio[id=radio3]').prop('checked', true);
            }

        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
	      return $( "<li>" )
	        .append( "<a><h4>" + item.label + " - " + item.nama + "</h4></a>" )
	        .appendTo( ul );
	    };
	}
	//lecturer autocomplete

	//lecturer autocomplete name
	function getLecturerAutoCompleteName() {
		$("#nama").autocomplete({
            minLength : 2,
            source: '<?php echo base_url() ?>admin/data/lecturer/getLecturerAutoCompleteName', //data source
            focus: function(event, ui){
            	$( "#nama" ).val( ui.item.nama );
        		return false;
            },
            select: function(event, ui){ //event after choose the suggest
                $("#npp").val(ui.item.npp);
                $('#old_npp').val(ui.item.npp);
                $("#pwd").val(ui.item.pwd);
                $('#alert_pwd').html('');
				$('#btnProsesDosen').prop('disabled',0);
				$('#btnProsesDosen').html('Update');
				
                if (ui.item.akses == 0) // jika dosen biasa
                	$('input:radio[id=radio1]').prop('checked', true);
                else if (ui.item.akses == 1)// jika dosen pembimbing
                	$('input:radio[id=radio2]').prop('checked', true);
                else // jika admin
                	$('input:radio[id=radio3]').prop('checked', true);
            }

        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
	      return $( "<li>" )
	        .append( "<a><h4>" + item.label + " - " + item.nama + "</h4></a>" )
	        .appendTo( ul );
	    };
	}
	//lecturer autocomplete name

	//resetForm
	function resetForm() {
		$('#npp').val('');
		$('#old_npp').val('');
		$('#nama').val('');
		$('#pwd').val('');
        $('input:radio[id=radio1]').prop('checked', true);
		$('#btnProsesDosen').html('Tambah');
		$('#btnProsesDosen').prop('disabled',1);

	}
	//resetForm
</script>


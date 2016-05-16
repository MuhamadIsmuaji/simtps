<?php 
	$next = $settingData->thn_ajaran+1;
	$semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Daftar Kelompok</span>
    		<div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-12">
	    <div class="card">
	        
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbGroupListsLecturer" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>Kode Kelompok</th>
	                            <th>Judul</th>
	                            <th>Status Judul</th>
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

<script>
	var save_method;
    var table,total_data;

	$(function(){
		$('#deleteGroupSelected').prop('disabled',1);
		$('#many').val('');
		
		/*Datatable*/
		table = $('#tbGroupListsLecturer').DataTable({
    			
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
                "url": "<?php echo base_url('lecturer/data/group/groupListsLecturer');?>/",
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

		console.log('a')

	}); // $function
</script>
<div class="page-title">
   <div class="row">
   		 <div class="col-md-8">
   		 	<span class="title">Halaman Data Pengumuman</span>
    		<div class="description">Halaman ini digunakan untuk menampilkan data pengumuman</div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Data Pengumuman</div>
	            </div>
	            <div class="pull-right card-action">
	        		<button type="button" id="deleteNewsSelected" onclick="deleteNewsSelected()" visible="false" class="btn btn-warning">
	        			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>&nbsp;
	        			<strong>Hapus Terpilih</strong>
	        		</button>
	        		<a href="<?= base_url('admin/data/news/create') ?>" class="btn btn-primary">
	        			<i class="fa fa-plus fa-lg" aria-hidden="true"></i>&nbsp;
	        			<strong>Buat Pengumuman</strong>
	        		</a>	        		
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbNewsListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th><input type="checkbox" id="checkAllNews" onclick="selectAllNews()"></th>
	                            <th>Tanggal Pembuatan</th>
	                            <th>Tanggal Kadaluarsa</th>
	                            <th>Judul</th>
	                            <th>Status Publikasi</th>
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

<?php $this->load->view('admin/data/news/confirm_delete_news_modal'); ?>

<script>

	var save_method;
    var table,total_data;

	$(function(){
		$('#deleteNewsSelected').hide();

		/*Datatable*/
		table = $('#tbNewsListsAdmin').DataTable({
    			
			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "Judul Pengumuman...",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "zeroRecords": "Maaf Data Pengumuman Tidak Ditemukan",
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
                "url": "<?php echo base_url('admin/data/news/newsListsAdmin');?>/",
                "type": "POST",
                "dataType" : "json",
                beforeSend: function(jqXHR, settings){
                    	$('#checkAllNews').prop('checked',0);
			    		$('#checkAllNews').prop('disabled',1);
			    		$('#deleteNewsSelected').hide(); // button
				},
            },

        }); 
		/*Datatable*/

		table.on( 'xhr', function () {
		    var json = table.ajax.json();
		    total_data =  json.data.length;
		    if(!total_data){
		    	$('#checkAllNews').prop('disabled',1)
		    }else{
		    	$('#checkAllNews').prop('disabled',0)
		    }
		});	
	}); //$ function

	//delete news selected
	function deleteNewsSelected(){
		indekId = 1;
		total = 0
		ids = new Array();		
		for(i=1; i<=total_data; i++){
			if($('#cbNews'+i).prop('checked')){
				total++;
				ids[indekId] = $('#cbNews'+i).val()
				indekId++;
			}
		}
		deleteData(total,ids,1)
	}
	//delete news selected

	//process delete data
	function deleteData(n,obj,status){
		serializeId = 'jml='+n+'&';
		for(i=1;i<=n;i++){
			if(i==n){
				serializeId+='id'+(i)+'='+obj[i];
			}else{
				serializeId+='id'+(i)+'='+obj[i]+'&';
			}
		}
		$('#confirm_delete_news_modal').modal('show');
		$('#message_delete').html('<strong>Yakin Ingin Menghapus Sebanyak '+ n +' Data Pengumuman</strong>');
		
		$('#btnDeleteNews').on('click',function(){
			$.ajax({
				url 	 : "<?= base_url('admin/data/news/processDeleteNews') ?>",
				data 	 : serializeId,
				type     : 'get',
				dataType : "json",
				success  : function(msg) {
					$('#message_delete').html('<strong>'+ msg +'</strong>');
					setTimeout(function(){ 
						$('#confirm_delete_news_modal').modal('hide');
						reload_table(); 
					}, 3000);

				},
				beforeSend : function(jqXHR, settings) {
					$('#btnDeleteNews').prop('disabled',1);
					$('#btnDeleteNews').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
					$('#btnCancelDeleteNews').prop('disabled',1);
				},
				error : function(jqXHR, textStatus, errorThrown) {					
					setTimeout(function(){ 
						$('#message_delete').html('<strong>Terjadi Kesalahan : '+ errorThrown +'</strong>');
                        window.location.href = "<?= base_url('admin/data/news') ?>";						
					}, 4000);
				}
			});
		});
	}
	//process delete data

	//when some news selected
    function checkNewsSelected(){
    	status = 0
    	for(i=1; i<=total_data; i++){
    		if($('#cbNews'+i).prop('checked')){
    			status = eval(status)+1;
    		}
    	}

    	if(status == total_data){
    		$('#checkAllNews').prop('checked',true)
    	}else{
    		$('#checkAllNews').prop('checked',false)	
    	}

    	if(status>0){
    		$('#deleteNewsSelected').show()
    	}else{
    		$('#deleteNewsSelected').hide()
    	}
    }
	//when some news selected

	//select all news
	function selectAllNews(){
		if($('#checkAllNews').prop('checked')){
    		$('#deleteNewsSelected').show()
    		for (i = 1; i <=total_data; i++) {
	    		$('#cbNews'+i).prop('checked',true)
	    	}
    	}else{
    		$('#deleteNewsSelected').hide()
	    	for (i = 1; i <=total_data; i++) {
	    		$('#cbNews'+i).prop('checked',false)
	    	}
	    }
    }
	//select all news


	//reload data table
	function reload_table() {
		table.ajax.reload(null,false);
    	$('#checkAllNews').prop('checked',0);
    }
	//reload data table


</script>


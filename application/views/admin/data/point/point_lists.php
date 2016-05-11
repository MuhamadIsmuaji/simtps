<div class="page-title">
   <div class="row">
   		 <div class="col-md-8 col-md-offset-2">
   		 	<span class="title">Halaman Daftar Nilai</span>
    		<div class="description">Halaman ini digunakan untuk mencetak daftar nilai</div>
    		<input type="hidden" name="current_thn_ajaran" id="current_thn_ajaran" value="<?= $current_thn_ajaran ?>" />
    		<input type="hidden" name="current_smt" id="current_smt" value="<?= $current_smt ?>" />
    		<input type="hidden" name="current_smt" id="maxThnAjaran" value="<?= $maxThnAjaran ?>" />
    		<input type="hidden" name="current_smt" id="minThnAjaran" value="<?= $minThnAjaran ?>" />
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Lists -->
	<div class="col-md-8 col-md-offset-2">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Daftar Nilai Peserta Praktikum</div>
	            </div>
	            <div class="pull-right card-action">
	        		<button type="button" id="deleteNewsSelected" onclick="printPointList()" visible="false" class="btn btn-primary">Cetak Daftar Nilai</button> 	
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<table id="tbPointListsAdmin" class="table table-striped" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>NBI</th>
	                            <th>NAMA</th>
	                            <th>NILAI</th>
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

<script type="text/javascript">
	var save_method;
    var table,total_data;
    var maxThnAjaran,minThnAjaran,filterThnAJaran,filterSmt;
    var inputThnAjaran, inputSemester = '';

	$(function(){
		/*Datatable*/
		table = $('#tbPointListsAdmin').DataTable({
    			
			"dom": '<"row"<"col-sm-4"l><"col-sm-4"<"#tahun_ajaran">><"col-sm-4"<"#semester">><"col-sm-4">>rtp',

			ordering : 0,

            "language": {
                "search": "Pencarian:",
                "searchPlaceholder": "NBI, Nama Peserta...",
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

            "aLengthMenu": [[10, 15, 20, -1], [10, 15, 20, "Semua"]],
            
            "processing": true,
            "serverSide": true,

            "ajax" : {
                "url": "<?php echo base_url('admin/data/point/pointListAdmin');?>/"+$('#current_thn_ajaran').val()+'/'+$('#current_smt').val(),
                "type": "POST",
                "dataType" : "json",
            },

        }); 

		table.on( 'xhr', function () {
		    var json = table.ajax.json();
		});	
		/*Datatable*/


		// Create filter periode
		maxThnAjaran = parseInt($('#maxThnAjaran').val());
		minThnAjaran = parseInt($('#minThnAjaran').val());

		for(i=minThnAjaran;i<=maxThnAjaran;i++){
			var next = i;
			var selected = $('#current_thn_ajaran').val() == i ? 'Selected' : '';
			inputThnAjaran += '<option value="'+ i +'"'+ selected +'>'+ i +' / '+ (next+1) +'</option>';
		}

		for(i=1;i<=2;i++){
			var selected2 = $('#current_smt').val() == i ? 'Selected' : '';
			var GorJ = i == 1 ? 'Ganjil' : 'Genap'
			inputSemester += '<option value="'+ i +'"'+ selected2 +'>'+ GorJ +'</option>';
		}

	    $("div#tahun_ajaran").html('Tahun Ajaran <select id="thn_ajaran_filter" name="thn_ajaran_filter" class="form-control input-sm">'+ inputThnAjaran + '</select>');
	    $("div#semester").html('Semester <select id="smt_filter" name="smt_filter" class="form-control input-sm">'+ inputSemester +'</select>');

		filterThnAJaran = $('#thn_ajaran_filter').val();
		filterSmt = $('#smt_filter').val();

	    //Filter periode operation
		$('#thn_ajaran_filter').on('change',function(){
			table.ajax.url("<?= base_url('admin/data/point/pointListAdmin')?>/"+ $(this).val() +'/'+ $('#smt_filter').val());
			//console.log($(this).val() + ' ' + $('#smt_filter').val());		
			filterThnAJaran = $('#thn_ajaran_filter').val();
			filterSmt = $('#smt_filter').val();
			reload_table();
		});

		$('#smt_filter').on('change',function(){
			table.ajax.url("<?= base_url('admin/data/point/pointListAdmin')?>/"+ $('#thn_ajaran_filter').val() +'/'+ $(this).val());
			//console.log($(this).val() + ' ' + $('#thn_ajaran_filter').val());		
			filterThnAJaran = $('#thn_ajaran_filter').val();
			filterSmt = $('#smt_filter').val();
			reload_table();
		});
		//Filter periode operation


	}); //$function

	//reload datatable
	function reload_table(){		
		table.ajax.reload(null,false)
	}
	//reload datatable
	

	// Point list print process
	function printPointList() {
    	window.location.href = "<?= base_url('admin/data/point/printPointList') ?>/" + filterThnAJaran +'/'+ filterSmt;
	}
	// 
</script>
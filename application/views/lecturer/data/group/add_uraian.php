<div class="page-title">
    <span class="title">Halaman Tambah Uraian Bimbingan</span>
    <div class="description">Halaman ini digunakan untuk menambahkan uraian dosen pembimbing untuk data bimbingan kelompok</div>
</div>
<div class="row">
	<!-- Form -->
	<div class="col-md-6">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	                <div class="title">Input Uraian Dosen</div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div id="alert_box"></div>
	            <form action="<?= base_url('lecturer/data/group/addUraian/'.$guidanceData->thn_ajaran.'/'.$guidanceData->smt.'/'.$guidanceData->kode_kel.'/'.$guidanceData->nou) ?>" method="POST">
	                <div class="form-group">
                        <div id="summernote"></div>
                        <input type="hidden" id="uraian" name="uraian" value="<?= $guidanceData->uraian_dosen ?>" readonly />
                    </div>
	                <div class="form-group">
	                    <button type="submit" class="btn btn-block btn-primary">
	                       	Simpan Uraian
	                    </button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<!-- Form -->
	
	<!-- Lists -->
	<div class="col-md-6">
	    <div class="card">
	        <div class="card-header">
	            <div class="card-title">
	            	<?php $tgl = new DateTime($guidanceData->tgl); ?>
	                <div class="title">
	                	Bimbingan Ke-<?= $guidanceData->nou .' '?>
						Tanggal <?= $tgl->format('d-m-Y') ?>
	                </div>
	            </div>
	        </div>
	        <div class="card-body">
	        	<div class="card-action">
				</div>
	        	<div class="table-responsive">
	        		<h4>Uraian Peserta :</h4>
					<div class="text-indent">
						<?= $guidanceData->uraian ?>
					</div>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- Lists -->
</div>

<script type="text/javascript">
	//summnernote
    $('#summernote').summernote({
        height: 250,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,                  // set focus to editable area after initializing summernote
        placeholder: 'Uraian Dosen...',
        shorcut : false,
        dialogsInBody: false,
        dialogsFade: false,
        disableDragAndDrop: true,
        callbacks : {
	        onKeyup: function(e) {
	            $('#uraian').val($('#summernote').summernote('code'));
	        },
	        onInit: function() {
		    	$('#summernote').summernote('code', $('#uraian').val());
		    }
        }
      
    });
    //summernote
</script>



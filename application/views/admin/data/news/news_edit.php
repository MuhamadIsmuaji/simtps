<!-- Untuk disable upload gambar summernote -->
<style type="text/css">
    .note-group-select-from-files {
        display: none;
    }
</style>
<!-- Untuk disable upload gambar summernote -->

<div class="page-title">
   <div class="row">
   		 <div class="col-md-8 col-md-offset-2">
   		 	<span class="title">Halaman Edit Data Pengumuman</span>
    		<div class="description">Halaman ini digunakan untuk mengedit data pengumuman</div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Form -->
	 <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Form Edit Pengumuman	</div>
                </div>
            </div>
            <div class="card-body">
                <form id="frm" action="<?= base_url('admin/data/news/edit/'.$news->id) ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php $tgl = new DateTime($news->tgl); ?>
                                <label for="exampleInputEmail1">Tanggal Publikasi</label>
                                <input type="text" class="form-control" id="tgl" name="tgl" value="<?= $tgl->format('d-m-Y') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            	<?php $tgl_exp = new DateTime($news->tgl_exp) ?>
                                <label for="exampleInputPassword1">Tanggal Kadaluarsa</label>
                                <input type="text" class="form-control" id="tgl_exp" name="tgl_exp" placeholder="Tanggal Kadaluarsa" value="<?= $tgl_exp->format('d-m-Y') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Pengumuman" value="<?= $news->judul ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Isi Pengumuman</label>
                        <div id="summernote"></div>
                        <input type="hidden" id="isi" name="isi" value="<?= $news->isi ?>" >
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Publikasi</label>
                                <div class="radio3">
                                    <input type="radio" id="radio2" name="validasi" value="0" <?php echo $news->validasi == 0 ? 'checked' : ''; ?> >
                                    <label for="radio2">Simpan Sebagai Draft</label>
                                </div>
                                <div class="radio3">
                                    <input type="radio" id="radio1" name="validasi" value="1" <?php echo $news->validasi == 1 ? 'checked' : ''; ?> >
                                    <label for="radio1">Publikasi</label>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                            	<?php $lampiran = $news->lampiran != NULL ? '('.$news->lampiran.')' : '(Tidak ada lampiran file)' ;?>
                                <label for="exampleInputFile">Lampiran File <?= $lampiran ?></label>
                                <input type="file" name="lampiran" id="lampiran" accept=".pdf,.docx,.xlsx,.jpg,.jpeg,.png,.bmp" >
                                <p class="help-block">File yang diizinkan : .pdf .docx .xlsx (maks : 2 MB)</p>
                            </div>
                        </div>
                    </div>
                      <?php 
                          if ( isset($errorMessage) ) :
                      ?>
                          <div class="<?= $divClass ?>" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              <?= $errorMessage ?>&nbsp<a href="<?= base_url('admin/data/news') ?>" class="alert-link">Kembali Ke Daftar Pengumuman</a>           
                          </div>
                      <?php 
                          endif;
                      ?>
                    <input type="submit" id="btnUpdateNews" name="btnUpdateNews" class="btn btn-block btn-primary" value="Submit" /> 
                </form>
            </div>
        </div>
    </div>
	<!-- Form -->
</div>

<script>

    $(function(){

        //summnernote
        $('#summernote').summernote({
            height: 250,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,                  // set focus to editable area after initializing summernote
            placeholder: 'Isi pengumuman...',
            shorcut : false,
            dialogsInBody: false,
            dialogsFade: false,
            disableDragAndDrop: true,
            callbacks : {
	            onKeyup: function(e) {
	                $('#isi').val($('#summernote').summernote('code'));
	            },
    	        onInit: function() {
    			    	$('#summernote').summernote('code', $('#isi').val());
    			    }
            }
          
        });
        //summernote

        //datepicker
        $('#tgl').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#tgl_exp').datetimepicker({
            format:'DD-MM-YYYY'
        });
        //datepicker

    }); // $ function

    //check file    
    function checkFile(oInput,event) {
      if(oInput.files[0].size > 2000000){
          alert('Maaf, file terlalu besar!')
          oInput.value = "";
          return false;
      }else{
          var _validFileExtensions = [".docx", ".pdf", ".xlsx", ".jpg", ".jpeg", ".png", ".bmp"];
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
                      $('#btnCreateNews').focus();
                  }
              }
          }
          return true;
        }
    }
    //check file  

</script>
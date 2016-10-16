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
   		 	<span class="title">Input Data Bimbingan</span>
    		<div class="description">
          Kelompok TPS01 Tahun Ajaran 2015 / 2016 Semester Genap
        </div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Form -->
	 <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Form Data Bimbingan</div>
                </div>
            </div>
            <div class="card-body">
                <form id="frm" action="<?= base_url('participant/guidance/create') ?>" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php 
                                    $now = date('Y-m-d');
                                    $dateNow = new DateTime($now);
                                ?>
                                <label for="exampleInputEmail1">Tanggal Bimbingan</label>
                                <input type="text" class="form-control" id="tgl" name="tgl" value="<?= $dateNow->format('d-m-Y') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Bimbingan Ke</label>
                                <select class="form-control" name="nou" id="nou">
                                  <option value="1">Bimbingan Ke 1</option>
                                  <option value="2">Bimbingan Ke 2</option>
                                  <option value="3">Bimbingan Ke 3</option>
                                  <option value="4">Bimbingan Ke 4</option>
                                  <option value="5">Bimbingan Ke 5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Uraian Bimbingan</label>
                        <div id="summernote"></div>
                        <input type="hidden" id="uraian" name="uraian" readonly />
                    </div>
                    <?php 
                        if ( isset($errorMessage) ) :
                    ?>
                        <div class="<?= $divClass ?>" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= $errorMessage ?>
                            &nbsp;
                            <a href="<?= base_url('participant/guidance') ?>" class="alert-link">
                              Kembali ke data bimbingan kelompok
                            </a>             
                        </div>
                    <?php 
                        endif;
                    ?>
                    <button type="submit" id="btnCreateNews" class="btn btn-block btn-primary">Submit</button>
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
            placeholder: 'Uraian Bimbingan...',
            shorcut : false,
            dialogsInBody: false,
            dialogsFade: false,
            disableDragAndDrop: true,
            callbacks : {
            onKeyup: function(e) {
                    $('#uraian').val($('#summernote').summernote('code'));
                }
            }
          
        });
        //summernote

        //datepicker
        $('#tgl').datetimepicker({
            format:'DD-MM-YYYY'
        });
        //datepicker

    }); // $ function
</script>
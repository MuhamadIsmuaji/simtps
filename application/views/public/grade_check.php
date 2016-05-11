<div class="page-title">
   <div class="row">
   		 <div class="col-md-4 col-md-offset-4">
   		 	<span class="title">Lihat Nilai</span>
    		<div class="description">Digunakan untuk cek nilai peserta praktikum tanpa harus login ke sistem</div>
   		 </div>
   </div>
</div>
<div class="row">
	<!-- Form -->
	 <div class="col-md-4 col-md-offset-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Form Lihat Nilai</div>
                </div>
            </div>
            <div class="card-body">
                <form id="frmGradeCheck" action="#">
                    <input type="text" class="form-control" id="nbi" name="nbi" placeholder="Masukkan NBI anda..." onkeypress="return numbersonly(this,event)" required><br/>
                    <button type="submit" id="btnGradeCheck" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
	<!-- Form -->
</div>

<?php $this->load->view('public/grade_check_modal'); ?>

<script>
    $(function(){
        $('#frmGradeCheck').on('submit',function(e){
            e.preventDefault();
           
            var data = $(this).serialize();
            var table = $("#gradeList tbody");
            $('#grade_check_modal').modal('show');
            $.ajax({
                url     : "<?= base_url('public/grade/checkProcess') ?>",
                data    : data,
                type    : "POST",
                dataType: "JSON",
                success : function(e){
                    if (e.status > 0) {
                        var identitas = '';
                        identitas = '<p>NPM : '+ e.data[0].nbi + '</p>';
                        identitas = identitas + '<p>NAMA : '+ e.data[0].nama +'</p>';

                        setTimeout(function(){ 
                            $('#status').html('<strong>'+identitas+'</strong>');
                            $.each(e.data, function(idx, elem){
                                var next = parseInt(elem.thn_ajaran) + 1;
                                var smt = elem.smt == 1 ? 'Ganjil' : 'Genap';   
                                table.append("<tr><td>"+elem.thn_ajaran+' / '+ next +"</td><td>"+smt+"</td>   <td>"+elem.nilai_huruf+"</td></tr>");
                            });    
                        }, 2000);
                            
                    } else {
                        setTimeout(function(){ 
                            $('#status').html('<p style="color:red;">Data Tidak Ditemukan</p>');   
                        }, 2000);
                    }

                    setTimeout(function(){ 
                        $('#btnFinish').html('Selesai');
                        $('#btnFinish').prop('disabled',0);    
                    }, 2000);
                },
                beforeSend : function(jqXHR, settings) {
                    $('#btnFinish').html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspProcessing...');
                    $('#status').html('<p>Processing...</p>');
                    $('#btnFinish').prop('disabled',1);
                    $('#gradeList > tbody').html('');
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    $('#status').html('<p style="color:red;">Terjadi Kesalahan...</p>');
                    $('#gradeList > tbody').html('');
                    $('#status').html('');
                    $('#btnFinish').html('Selesai');
                    $('#btnFinish').prop('disabled',0);
                }
            });
            
        });
    }) // $ function

// beforeSend : function(jqXHR, settings) {
//                     $('#btnDeleteLecturer').prop('disabled',1);
//                     $('#btnDeleteLecturer').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memproses...');
//                     $('#btnCancelDeleteLecturer').prop('disabled',1);
//                 },
//                 error : function(jqXHR, textStatus, errorThrown) {
//                     setTimeout(function(){ 
//                         $('#message_delete').html('<strong>Terjadi Kesalahan : '+ errorThrown +'</strong>');
//                         window.location.href = "<?= base_url('admin/data/lecturer') ?>";                        
//                     }, 4000);
//                 }
</script>
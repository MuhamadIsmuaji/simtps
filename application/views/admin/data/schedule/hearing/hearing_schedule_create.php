<?php 
  $next = $settingData->thn_ajaran+1;
  $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="page-title">
    <span class="title">
      Halaman Tambah Jadwal Sidang
    </span>
    <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
</div>
<div class="row">
  <!-- Form -->
  <div class="col-md-4">
      <div class="card">
          <div class="card-header">
              <div class="card-title">
                  <div class="title">Form Data Jadwal Sidang</div>
              </div>
          </div>
          <div class="card-body">
            <div id="alert_box"></div>
              <form id="frmCreateSidang" method="#" action="#">
                    <?php 
                        $now = date('Y-m-d');
                        $dateNow = new DateTime($now);
                    ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="text" class="form-control" id="tgl" name="tgl" placeholder="Tanggal" value="<?= $dateNow->format('d-m-Y') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ruang</label>
                        <input type="text" class="form-control" id="ruang" name="ruang" placeholder="Ruang" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dari</label>
                        <select class="form-control" id="mulai" name="mulai">
                          <?php 
                            for($i=0;$i<=23;$i++) {
                                if ( $i<=9 )
                                  echo '<option value="'.$i.'">0'. $i .':00</option>';
                                else
                                  echo '<option value="'.$i.'">'.$i .':00</option>';                                    
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sampai</label>
                        <select class="form-control" id="akhir" name="akhir">
                          <?php
                            for($i=0;$i<=23;$i++) {
                                if ( $i<=9 )
                                  echo '<option value="0'.$i.'">0'. $i .':00</option>';
                                else
                                  echo '<option value="'.$i.'">'.$i .':00</option>';                                    
                            }
                          ?>
                        </select>
                    </div>   
                    <div class="form-group">
                        <label for="exampleInputEmail1">Moderator</label>
                         <select class="form-control" id="moderator" name="moderator">
                          <?php 
                            foreach ($dataDoping as $dosen) {
                              echo '<option value="'. $dosen->npp .'">'. $dosen->nama .'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Penguji 1</label>
                         <select class="form-control" id="penguji1" name="penguji1">
                          <?php 
                            foreach ($dataDoping as $dosen) {
                              echo '<option value="'. $dosen->npp .'">'. $dosen->nama .'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Penguji 2</label>
                         <select class="form-control" id="penguji2" name="penguji2">
                          <?php 
                            foreach ($dataDoping as $dosen) {
                              echo '<option value="'. $dosen->npp .'">'. $dosen->nama .'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Validasi</label>
                        <div class="radio3">
                            <input type="radio" id="radio2" name="validasi" value="0" checked>
                            <label for="radio2">Tidak</label>
                        </div>
                        <div class="radio3">
                            <input type="radio" id="radio1" name="validasi" value="1">
                            <label for="radio1">Ya</label>
                        </div>
                    </div>  
                    <div cLass="row">
                      <div cLass="col-sm-6">
                        <button type="submit" id="btnCreateSidang" onclick="createSidang();" class="btn btn-block btn-primary">Simpan</button>
                      </div>
                      <div cLass="col-sm-6">
                        <button type="reset" id="btnResetSidang" class="btn btn-block btn-primary">Reset</button>
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
          </div>
          <div class="card-body">
            <div class="card-action">
        </div>
            <div class="table-responsive">
              <table id="tbGroupListSidang" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAllGroup" onclick="selectAllGroup()"></th>
                            <th>No</th>
                            <th>Kode Kelompok</th>
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


<script type="text/javascript">
  var total_data;

  $(function(){
    createSidang();
    var table = $("#tbGroupListSidang tbody");
    var moderator = $('#moderator').val();
    var penguji1 = $('#penguji1').val();
    var penguji2 = $('#penguji2').val();
    $('#checkAllGroup').prop('disabled',1);

    //datepicker
    $('#tgl').datetimepicker({
        format:'DD-MM-YYYY'
    });
    //datepicker
    
    //get Autoload by Selected moderator
    $.ajax({
      url : "<?= base_url('admin/data/schedule/getGroupList') ?>",
      type : "POST",
      data : "moderator="+moderator,
      dataType : "JSON",
      success : function(data) {
        table.empty();
        total_data = data.many;
        if ( data.many == 0 ) {
          table.append('<tr><td colspan="3" align="center">Data Kelompok Praktikum Kosong</td></tr>');
          $('#checkAllGroup').prop('disabled',1);
        } else {
          var no = 1;
          var cb = 1;
          $('#checkAllGroup').prop('disabled',0);

          $.each(data.list, function(idx, elem){
              table.append('<tr>'+
                '<td><input type="checkbox" id="cbGroup'+cb+'" onclick="checkGroupSelected();" value="'+ elem +'"></td>'+
                '<td>'+no+'</td>'+
                '<td>'+elem+'</td>'+
              '</tr>');
              no++;
              cb++;
          });
        }

      },
      error : function(jqXHR, textStatus, errorThrown) {
        alert('Terjadi Kesalahan : '+ textStatus);
      }
    });
    //get Autoload by Selected moderator
    
    //select moderator
    $('#moderator').on('change',function(){
      moderator = $(this).val();
      $.ajax({
          url : "<?= base_url('admin/data/schedule/getGroupList') ?>",
          type : "POST",
          data : "moderator="+moderator,
          dataType : "JSON",
          success : function(data) {
            table.empty();
            total_data = data.many;
            if ( data.many == 0 ) {
            $('#checkAllGroup').prop('disabled',1);
              table.append('<tr><td colspan="3" align="center">Data Kelompok Praktikum Kosong</td></tr>');
            } else {
              var no = 1;
              var cb = 1;
              $('#checkAllGroup').prop('disabled',0);
              
              $.each(data.list, function(idx, elem){
                  table.append('<tr>'+
                    '<td><input type="checkbox" id="cbGroup'+cb+'" onclick="checkGroupSelected();" value="'+ elem +'"></td>'+
                    '<td>'+no+'</td>'+
                    '<td>'+elem+'</td>'+
                  '</tr>');
                  no++;
                  cb++;
              });
            }
          },
          error : function(jqXHR, textStatus, errorThrown) {
            alert('Terjadi Kesalahan : '+ textStatus);
          }
      });
    });
    //select moderator
    
    // when user click reset button
    $('#btnResetSidang').on('click',function(){
      $('#checkAllGroup').prop('checked',false);
      for (i = 1; i <=total_data; i++) {
        $('#cbGroup'+i).prop('checked',false)
      }  
    });
    // when user click reset button
    
  }); // $function

  //select all group
  function selectAllGroup() {
    if($('#checkAllGroup').prop('checked')){
      for (i = 1; i <=total_data; i++) {
        $('#cbGroup'+i).prop('checked',true);
      }
    }else{
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
  }
  //when some group selected
  
  // submit create sidang
  function createSidang(){
    $('#frmCreateSidang').on('submit',function(e){
      e.preventDefault();
      
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

      if ( total == 0 ) {
        alert('Pilih Kelompok Terlebih Dahulu !');
        return false;
      } else {
        createSidangProcess(total,ids,1);
      }
       
    });
  }
  // submit create sidang
  
  // create sidang process
  function createSidangProcess(n,obj,status) {
    var tgl = $('#tgl').val();
    var ruang = $('#ruang').val();
    var mulai = $('#mulai').val();
    var akhir = $('#akhir').val();
    moderator = $('#moderator').val();
    penguji1 = $('#penguji1').val();
    penguji2 = $('#penguji2').val();
    var validasi = $('input[name=validasi]:checked', '#frmCreateSidang').val();
    
    serializeId = 'tgl='+ tgl +'&ruang='+ ruang +
        '&mulai='+ mulai +'&akhir='+ akhir +'&validasi='+ validasi +
        '&moderator='+ moderator +'&penguji1='+ penguji1 +'&penguji2='+ penguji2 + 
        '&jml='+ n +'&';
    

    for(i=1;i<=n;i++){
      if(i==n){
        serializeId+='kode_kel'+(i)+'='+obj[i];
      }else{
        serializeId+='kode_kel'+(i)+'='+obj[i]+'&';
      }
    }
    
    window.location.href = "<?= base_url('admin/data/schedule/hearingScheduleCreateProcess') ?>?" + serializeId;
  }
  // create sidang process

</script>
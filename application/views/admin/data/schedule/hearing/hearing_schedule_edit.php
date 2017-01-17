<?php 
  $next = $settingData->thn_ajaran+1;
  $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="page-title">
    <span class="title">
      Halaman Edit Jadwal Sidang
      <input type="hidden" value="<?= $identitasJadwal->thn_ajaran ?>" id="thn_ajaran">
      <input type="hidden" value="<?= $identitasJadwal->smt ?>" id="smt">
      <input type="hidden" value="<?= $identitasJadwal->ruang ?>" id="old_ruang">
      <input type="hidden" value="<?= $identitasJadwal->mulai ?>" id="old_mulai">
      <input type="hidden" value="<?= $identitasJadwal->akhir ?>" id="old_akhir">
      <input type="hidden" value="<?= $identitasJadwal->tgl ?>" id="old_tgl">
      <input type="hidden" value="<?= $identitasJadwal->penguji1 ?>" id="old_penguji1">
      <input type="hidden" value="<?= $identitasJadwal->penguji2 ?>" id="old_penguji2">
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
                    <?php $tgl = new DateTime($identitasJadwal->tgl); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="text" class="form-control" id="tgl" name="tgl" placeholder="Tanggal" value="<?= $tgl->format('d-m-Y') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ruang</label>
                        <input type="text" class="form-control" id="ruang" name="ruang" placeholder="Ruang" value="<?= $identitasJadwal->ruang ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dari</label>
                        <select class="form-control" id="mulai" name="mulai">
                          <?php 
                            for($i=0;$i<=23;$i++) {
                                $selectMulai = $i == $identitasJadwal->mulai ? 'selected' : '';
                                if ( $i<=9 )
                                  echo '<option value="'.$i.'" '.$selectMulai.'>0'. $i .':00</option>';
                                else
                                  echo '<option value="'.$i.'" '.$selectMulai.'>'.$i .':00</option>';                                    
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sampai</label>
                        <select class="form-control" id="akhir" name="akhir">
                          <?php
                            for($i=0;$i<=23;$i++) {
                                $selectAkhir = $i == $identitasJadwal->akhir ? 'selected' : '';
                                if ( $i<=9 )
                                  echo '<option value="0'.$i.'"'. $selectAkhir .'>0'. $i .':00</option>';
                                else
                                  echo '<option value="'.$i.'"'. $selectAkhir .'>'.$i .':00</option>';                                    
                            }
                          ?>
                        </select>
                    </div>   
                    <div class="form-group">
                        <label for="exampleInputEmail1">Moderator</label>
                        <input class="form-control" type="text" value="<?= $moderator->nama ?>" readonly>
                        <input class="form-control" type="hidden" value="<?= $moderator->npp ?>" id="moderator" name="moderator" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Penguji 1</label>
                         <select class="form-control" id="penguji1" name="penguji1">
                          <?php 
                            foreach ($dataDoping as $dosen) {
                              $selectPenguji1 = $dosen->npp == $identitasJadwal->penguji1 ? 'selected' : '';
                              echo '<option value="'. $dosen->npp .'"'. $selectPenguji1 .'>'. $dosen->nama .'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Penguji 2</label>
                         <select class="form-control" id="penguji2" name="penguji2">
                          <?php 
                            foreach ($dataDoping as $dosen) {
                              $selectPenguji2 = $dosen->npp == $identitasJadwal->penguji2 ? 'selected' : '';
                              echo '<option value="'. $dosen->npp .'"'. $selectPenguji2 .'>'. $dosen->nama .'</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Validasi</label>
                        <div class="radio3">
                            <input type="radio" id="radio2" name="validasi" value="0" <?php  if ($identitasJadwal->validasi == 0) echo "checked"; ?>>
                            <label for="radio2">Tidak</label>
                        </div>
                        <div class="radio3">
                            <input type="radio" id="radio1" name="validasi" value="1" <?php  if ($identitasJadwal->validasi == 1) echo "checked"; ?>>
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
    var old_ruang = $('#old_ruang').val();
    var old_mulai = $('#old_mulai').val();
    var old_akhir = $('#old_akhir').val();
    var old_tgl = $('#old_tgl').val();

    $('#checkAllGroup').prop('disabled',1);

    //datepicker
    $('#tgl').datetimepicker({
        format:'DD-MM-YYYY'
    });
    //datepicker
    
    //get Autoload by Selected moderator
    $.ajax({
      url : "<?= base_url('admin/data/schedule/getGroupListEdit') ?>",
      type : "POST",
      data : "moderator="+moderator+"&old_ruang="+old_ruang+"&old_mulai="+old_mulai+"&old_akhir="+old_akhir+"&old_tgl="+old_tgl,
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
          var banyak_cek = 1;
          $('#checkAllGroup').prop('disabled',0);
          $.each(data.list, function(idx, elem){
              if ( data.list[idx][0] == 1 ) {
                checked = 'checked';
                banyak_cek++;
              } else {
                checked = '';
              }

              table.append('<tr>'+
                '<td><input type="checkbox" id="cbGroup'+cb+'" onclick="checkGroupSelected();" value="'+ elem[1] +'" '+ checked +'></td>'+
                '<td>'+no+'</td>'+
                '<td>'+elem[1]+'</td>'+
              '</tr>');
              no++;
              cb++;
          });

          if ( data.many == banyak_cek - 1 ) {
            $('#checkAllGroup').prop('checked',true);
          }
        }

      },
      error : function(jqXHR, textStatus, errorThrown) {
        alert('Terjadi Kesalahan : '+ errorThrown);
      }
    });
    //get Autoload by Selected moderator

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
    //data baru
    var old_ruang = $('#old_ruang').val();
    var old_tgl = $('#old_tgl').val();
    var old_mulai = $('#old_mulai').val();
    var old_akhir = $('#old_akhir').val(); 
    var old_penguji1 = $('#old_penguji1').val();
    var old_penguji2 = $('#old_penguji2').val(); 

    //data lama
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
        '&old_ruang='+ old_ruang +'&old_tgl='+ old_tgl +'&old_mulai='+ old_mulai + '&old_akhir='+old_akhir+
        '&old_penguji1='+ old_penguji1 + '&old_penguji2='+ old_penguji2 +  
        '&jml='+ n +'&';
    

    for(i=1;i<=n;i++){
      if(i==n){
        serializeId+='kode_kel'+(i)+'='+obj[i];
      }else{
        serializeId+='kode_kel'+(i)+'='+obj[i]+'&';
      }
    }
    
    window.location.href = "<?= base_url('admin/data/schedule/hearingScheduleEditProcess') ?>?" + serializeId;
    //console.log(serializeId);
  }
  // create sidang process

</script>
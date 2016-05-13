<div class="page-title">
    <span class="title">Halaman Surat Tugas</span>
    <div class="description">Halaman ini digunakan untuk mencetak surat tugas</div>
</div>
<div class="row">
  <!-- Form -->
  <div class="col-md-4">
      <div class="card">
          <div class="card-header">
              <div class="card-title">
                  <div class="title">Pilih Surat Tugas</div>
              </div>
          </div>
          <div class="card-body">
              <div class="sub-title">Tahun Ajaran</div>
              <div>
                <select class="form-control" name="thn_ajaran" id="thn_ajaran">
                      <?php 

                        for ( $i=$minThnAjaran;$i<=$maxThnAjaran;$i++) {
                          $next = $i+1;
                          $selected = $i == $current_thn_ajaran ? 'Selected' : '';
                          echo '<option value="'. $i .'"'. $selected .'>'. $i .' / '. $next .'</option>';
                        }
                      ?>
                </select>
              </div>
              <div class="sub-title">Semester</div>
              <div>
                <select class="form-control" name="smt" id="smt">
                  <option value="1" <?= $current_smt == 1 ? 'Selected' : '' ?> >Ganjil</option>
                  <option value="2" <?= $current_smt == 2 ? 'Selected' : '' ?> >Genap</option>
                </select>
              </div>
          </div>
      </div>
  </div>
  <!-- Form -->
  
  <!-- Lists -->
  <div class="col-md-8">
      <div class="card">
          <div class="card-header">
              <div class="card-title">
                  <div class="title">Data Dosen Pembimbing</div>
              </div>
              <div class="pull-right card-action">
                  <button type="button" id="printLoa" onclick="printLoa();" visible="false" 
                    class="btn btn-primary" ><i class="fa fa-cloud-download fa-lg" aria-hidden="true"></i>
                    &nbsp;<strong>Unduh Surat Tugas</strong>
                  </button>
              </div>
          </div>
          <div class="card-body">
            <div class="card-action">
        </div>
            <div class="table-responsive">
              <table id="tbDopingList" class="table table-striped" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th><input type="checkbox" id="checkAllDoping" onclick="selectAllDoping()"></th>
                              <th>NPP</th>
                              <th>NAMA</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
              </table>
            </div>
          </div>
      </div>
  </div>
  <!-- Lists -->
</div> 

<script type="text/javascript">
  var total_data;
  $(function(){
      //$('#printLoa').prop('disabled',1);
      var table = $("#tbDopingList tbody");
      table.append('<tr><td colspan="3" align="center">Data Dosen Pembimbing Kosong</td></tr>');
      var cur_thn_ajaran = $('#thn_ajaran').val();
      var cur_smt = $('#smt').val();

      //get Autoload current period
      $.ajax({
            url: "<?= base_url('admin/data/loa/dopingList')?>",
            type: "POST",
            data: "smt="+ cur_smt +"&thn_ajaran="+ cur_thn_ajaran,
            dataType: "JSON",
            success : function(data) {
              table.empty();
              total_data = data.many;
              if ( data.many == 0 ) {
                table.append('<tr><td colspan="3" align="center">Data Dosen Pembimbing Kosong</td></tr>');
              } else {
                var cb = 1;
                $.each(data.list, function(idx, elem){
                    table.append('<tr>'+
                      '<td><input type="checkbox" id="cbDoping'+cb+'" onclick="checkDopingSelected();" value="'+ elem.npp +'"></td>'+
                      '<td>'+elem.npp+'</td>'+
                      '<td>'+elem.nama+'</td>'+
                    '</tr>');
                    cb++;
                });
              }

            },
            error : function(jqXHR, textStatus, errorThrown) {
              alert('Terjadi Kesalahan : '+ textStatus);
            }
        });
      //get Autoload current period

      // select thn_ajaran
      $('#thn_ajaran').on('change',function(){
          var smt = $('#smt').val();
          $.ajax({
              url: "<?= base_url('admin/data/loa/dopingList')?>",
              type: "POST",
              data: "smt="+ smt +"&thn_ajaran="+ $(this).val(),
              dataType: "JSON",
              success : function(data) {
                table.empty();
                total_data = data.many;
                if ( data.many == 0 ) {
                  table.append('<tr><td colspan="3" align="center">Data Dosen Pembimbing Kosong</td></tr>');
                } else {
                  var cb = 1;
                  $.each(data.list, function(idx, elem){
                      table.append('<tr>'+
                        '<td><input type="checkbox" id="cbDoping'+cb+'" onclick="checkDopingSelected();" value="'+ elem.npp +'"></td>'+
                        '<td>'+elem.npp+'</td>'+
                        '<td>'+elem.nama+'</td>'+
                      '</tr>');
                      cb++;
                  });
                }

              },
              error : function(jqXHR, textStatus, errorThrown) {
                alert('Terjadi Kesalahan : '+ textStatus);
              }
          });
      });
      // select thn_ajaran

      // select smt
      $('#smt').on('change',function(){
          var thn_ajaran = $('#thn_ajaran').val();
          $.ajax({
              url: "<?= base_url('admin/data/loa/dopingList')?>",
              type: "POST",
              data: "smt="+ $(this).val() +"&thn_ajaran="+ thn_ajaran ,
              dataType: "JSON",
              success : function(data) {
                table.empty();
                total_data = data.many;
                if ( data.many == 0 ) {
                  table.append('<tr><td colspan="3" align="center">Data Dosen Pembimbing Kosong</td></tr>');
                } else {
                  var cb = 1;
                  $.each(data.list, function(idx, elem){
                      table.append('<tr>'+
                        '<td><input type="checkbox" id="cbDoping'+cb+'" onclick="checkDopingSelected();" value="'+ elem.npp +'"></td>'+
                        '<td>'+elem.npp+'</td>'+
                        '<td>'+elem.nama+'</td>'+
                      '</tr>');
                      cb++;
                  });
                }

              },
              error : function(jqXHR, textStatus, errorThrown) {
                alert('Terjadi Kesalahan : '+ textStatus);
              }
          });
      });
      // select smt
      
  }); //$function

  //select all doping
  function selectAllDoping() {

    if($('#checkAllDoping').prop('checked')){
      $('#printLoa').prop('disabled',0);
      for (i = 1; i <=total_data; i++) {
        $('#cbDoping'+i).prop('checked',true);
      }
    }else{
      //$('#deleteGroupSelected').prop('disabled',1);
      for (i = 1; i <=total_data; i++) {
        $('#cbDoping'+i).prop('checked',false)
      }
    }

  }
  //select all doping

  //when some doping selected
  function checkDopingSelected(){
    //total_cbnya()     
    status = 0
    for(i=1; i<=total_data; i++){
      if($('#cbDoping'+i).prop('checked')){
        status = eval(status)+1;
      }
    }

    if(status == total_data){
      $('#checkAllDoping').prop('checked',true)
    }else{
      $('#checkAllDoping').prop('checked',false) 
    }

    if(status>0){
      $('#printLoa').prop('disabled',0);
    }else{
      $('#printLoa').prop('disabled',1);
    }
  }
  //when some doping selected

  function printProcess(n,obj,status){
    serializeId = 'jml='+n+'&';
    for(i=1;i<=n;i++){
      if(i==n){
        serializeId+='npp'+(i)+'='+obj[i];
      }else{
        serializeId+='npp'+(i)+'='+obj[i]+'&';
      }
    }

    window.location.href = "<?= base_url('admin/data/loa/loaPrint') ?>?" + serializeId;
  }

  function printLoa() {
    indekId = 1;
    total = 0
    ids = new Array();    
    for(i=1; i<=total_data; i++){
      if($('#cbDoping'+i).prop('checked')){
        total++;
        ids[indekId] = $('#cbDoping'+i).val()
        indekId++;
      }
    }
      
    printProcess(total,ids,1) 
  }

  

</script>


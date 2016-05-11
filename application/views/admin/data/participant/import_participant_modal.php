<div class="modal fade modal-primary" id="import_participant_modal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                  <h4 class="modal-title" id="myAddLabel">Import Data Peserta</h4>
              </div>
              <div class="modal-body">
                <?= form_open_multipart('admin/data/participant/importParticipant') ?>
                  <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <input type="file" id="excel_participant" name="excel_participant"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" onchange="checkFile(this,event)" required />
                      <p class="help-block">Pilih File Dengan Tipe : .xls / .xlsx <br/>(Maks : 5 MB)</p>
                  </div>
              </div>
              <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" value="Upload" name="upload">
              </div>
                <?= form_close(); ?>
          </div>
    </div>
</div>

<script type="text/javascript">
    //check file    
    function checkFile(oInput,event) {
      if(oInput.files[0].size > 5000000){
          alert('Maaf, file terlalu besar!')
          oInput.value = "";
          return false;
      }else{
          var _validFileExtensions = [".xls", ".xlsx"]; //jpg|jpeg|png|bmp
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
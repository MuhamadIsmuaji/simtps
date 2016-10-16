<!-- Modal -->
<div class="modal fade modal-primary" id="input_file_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelDocument">Upload Dokumen Kelompok</h4>
            </div>
            <form action="<?= base_url('participant/group/inputFileGroup') ?>" enctype="multipart/form-data" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pilih Dokumen</label>
                    <input type="file" class="form-control" name="group_document" onchange="checkFile(this,event)" accept=".pdf, .docx"  required />
                    <input type="hidden" id="code" name="code" />
                    <input type="hidden" id="kode_kel_modal_file" name="kode_kel_modal_file" />
                    <p class="help-block"><strong><i>*Dokumen yang sudah ada akan diganti</i></strong></p>
                    <p class="help-block">
                        <strong><i>*Pastikan dokumen dengan format .docx atau .pdf (Max : 50 MB)</i></strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelInputFile" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="btnSubmitInputFile" class="btn btn-primary">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-primary bs-example-modal-lg" id="input_title_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Input Judul</h4>
            </div>
            <form action="<?= base_url('participant/group/inputTitleGroup') ?>" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Judul Tugas Perancangan Sistem</label>
                    <!-- <input type="text" class="form-control" name="judul" placeholder="Judul Tugas Perancangan Sistem" required /> -->
                    <textarea class="form-control" name="judul" rows="4"></textarea>
                    <input type="hidden" id="kode_kel_modal_title" name="kode_kel_modal_title" />
                    <p class="help-block"><strong><i>*Judul yang sudah ada akan diganti</i></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelInputTitle" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="btnSubmitInputTitle" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
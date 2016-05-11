<!-- Modal -->
<div class="modal fade modal-primary" id="add_member_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambahkan Anggota Kelompok</h4>
            </div>
            <form action="#" method="#" id="frmAddMember">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">NBI Peserta</label>
                    <input type="text" class="form-control" name="nbinama" id="nbinama" 
                        placeholder="NBI Peserta..." required />
                    <input type="hidden" id="nbinya" name="nbinya" />
                    <input type="hidden" id="kode_kel_modal_add" name="kode_kel_modal_add" />
                    <p class="help-block" id="addStatus">
                        <strong>
                        <i>Pastikan peserta yang ditambahkan belum memiliki kelompok</i>
                        </strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelAdd" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="btnAdd" class="btn btn-primary">Tambahkan</button>
            </div>
            </form>
        </div>
    </div>
</div>
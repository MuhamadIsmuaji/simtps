<!-- Modal -->
<div class="modal fade modal-primary" id="invite_member_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Undang Anggota Kelompok</h4>
            </div>
            <form action="#" method="#" id="frmInviteMember">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">NBI Peserta</label>
                    <input type="text" class="form-control" name="nbijoin" id="nbijoin" placeholder="NBI peserta yang akan diundang" onkeypress="return numbersonly(this,event)" required />
                    <label style="margin-top: 12px;">Nama Peserta</label>
                    <input type="text" class="form-control" name="namajoin" id="namajoin" readonly />
                    <input type="hidden" id="kode_kel_modal_invite" name="kode_kel_modal_invite" />
                    <p class="help-block" id="inviteStatus">
                        <strong>
                        <i>Pastikan peserta yang anda undang belum memiliki kelompok</i>
                        </strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelInviteModal" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="btnInviteModal" class="btn btn-primary">Undang</button>
            </div>
            </form>
        </div>
    </div>
</div>
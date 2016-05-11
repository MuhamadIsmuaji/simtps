<!-- Modal -->
<div class="modal fade modal-primary" id="detail_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelKodeKel">Lab. RPL Untag Surabaya</h4>
            </div>
            <div class="modal-body">
                <blockquote>
                  <div id="status"></div>
                </blockquote>
                <h4><strong>Daftar Anggota Kelompok</strong></h4><br/>
                <div class="table-responsive">
                    <table id="memberList" class="table table-striped">
                        <thead>
                            <th>NBI</th>
                            <th>Nama</th>
                        </thead>
                    <tbody></tbody>
                </table>
                </div>
                <div id="statusRegister"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancelJoin" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" id="btnJoin" onclick="registeringOnGroup()" class="btn btn-primary">Gabung</button>
            </div>
        </div>
    </div>
</div>
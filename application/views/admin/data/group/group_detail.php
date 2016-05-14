<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    
    $judul = $dataGroup->judul == NULL ? '-' : $dataGroup->judul;
    $proposal = $dataGroup->proposal == NULL ? '-' : $dataGroup->proposal;
    $revisi = $dataGroup->revisi == NULL ? '-' : $dataGroup->revisi;

    if ( $dataGroup->judul == NULL ) {
        $btnJudul = '-';
    } else {
        if ( $dataGroup->validasi == 1 ) {
            $btnJudul = '<button class="btn btn-danger btn-block" onclick="validateTitle(this,0)" data-thn_ajaran="'.$dataGroup->thn_ajaran.'"
                         data-smt="'.$dataGroup->smt.'" data-kode_kel="'.$dataGroup->kode_kel.'" >
                            <i class="fa fa-times fa-lg" aria-hidden="true"></i>&nbsp;
                            Batalkan Validasi Judul
                        </button>';
        } else {
            $btnJudul = '<button class="btn btn-primary btn-block" onclick="validateTitle(this,1)" data-thn_ajaran="'.$dataGroup->thn_ajaran.'"
                         data-smt="'.$dataGroup->smt.'" data-kode_kel="'.$dataGroup->kode_kel.'" >
                            <i class="fa fa-check fa-lg" aria-hidden="true"></i>&nbsp;
                            Validasi Judul
                        </button>';
        }
    }


    if ( $dataGroup->proposal == NULL ) {
        $btnProposal = '-';
    } else {
        $btnProposal = '<a href="'. base_url('admin/data/group/downloadGroupDocument/1/'.$dataGroup->proposal) .'" 
                            target="_blank" class="btn btn-primary btn-block" >
                            <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                            Unduh Proposal
                        </a>';
    }

    if ( $dataGroup->revisi == NULL ) {
        $btnRevisi = '-';
    } else {
        $btnRevisi = '<a href="'. base_url('admin/data/group/downloadGroupDocument/2/'.$dataGroup->revisi) .'" 
                            target="_blank" class="btn btn-primary btn-block" >
                            <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                            Unduh Revisi Proposal
                    </a>';
    }
?>  
<input type="hidden" id="kode_kel" value="<?= $dataGroup->kode_kel ?>" />
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?= $dataGroup->kode_kel.' - Tahun Ajaran '.$settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="step">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="step" class="active">
                            <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                <div class="icon fa fa-users"></div>
                                <div class="step-title">
                                    <div class="title">Data Anggota</div>
                                    <div class="description">Detail data anggota kelompok</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-star"></div>
                                <div class="step-title">
                                    <div class="title">Data Nilai</div>
                                    <div class="description">Detail data nilai anggota kelompok</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step3" role="tab" id="step3-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-book"></div>
                                <div class="step-title">
                                    <div class="title">Data Dokumen dan Bimbingan</div>
                                    <div class="description">Detail data dokumen dan bimbingan kelompok</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                            <div class="row">
                                <!-- Lists -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <div class="title">Daftar Anggota Kelompok</div>
                                            </div>
                                            <div class="pull-right card-action">
                                                <button type="button" id="btnAddAnggota" visible="false" 
                                                    class="btn btn-primary" onclick="showAddAnggotaModal()" >
                                                    <i class="fa fa-plus fa-lg" aria-hidden="true"></i>&nbsp;
                                                    <strong>Tambahkan Anggota</strong>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-action">
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tbListAnggota" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>NBI</th>
                                                            <th>NAMA</th>
                                                            <th>#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach ($dataMember as $member) {       
                                                        ?>
                                                            <tr>
                                                                <td><?= $member->nbi ?></td>
                                                                <td><?= $member->nama ?></td>
                                                                <td>
                                                                    <a href="javascript:void(0)" class="btn btn-danger"
                                                                        data-thn_ajaran="<?= $member->thn_ajaran ?>"
                                                                        data-smt="<?= $member->smt ?>"
                                                                        data-kode_kel="<?= $member->kode_kel ?>"  
                                                                        data-nbi="<?= $member->nbi ?>"
                                                                        data-nama="<?= $member->nama ?>"
                                                                        onclick="deleteAnggota(this);" >
                                                                        <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                                                        &nbsp;<strong>Hapus</strong>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Lists -->
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <div class="title">Data Nilai</div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                            <form action="<?= base_url('admin/data/group/changePoint') ?>"
                                                method="POST" >
                                                <table id="tbLecturerListsAdmin" class="table table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="text-align: center;">NBI</th>
                                                            <th rowspan="2" style="text-align: center;">NAMA</th>
                                                            <th rowspan="2" style="text-align: center;">Nilai Bimbingan</th>
                                                            <th colspan="4" style="text-align: center;">Penilaian Moderator</th>
                                                            <th colspan="4" style="text-align: center;">Penilaian Penguji 1</th>
                                                            <th colspan="4" style="text-align: center;">Penilaian Penguji 2</th>
                                                            <th rowspan="2" style="text-align: center;">Nilai Akhir</th>
                                                            <th rowspan="2" style="text-align: center;">Nilai Huruf</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="text-align: center;">Nilai A</th>
                                                            <th style="text-align: center;">Nilai B</th>
                                                            <th style="text-align: center;">Nilai C</th>
                                                            <th style="text-align: center;">Nilai D</th>
                                                            <th style="text-align: center;">Nilai A</th>
                                                            <th style="text-align: center;">Nilai B</th>
                                                            <th style="text-align: center;">Nilai C</th>
                                                            <th style="text-align: center;">Nilai D</th>
                                                            <th style="text-align: center;">Nilai A</th>
                                                            <th style="text-align: center;">Nilai B</th>
                                                            <th style="text-align: center;">Nilai C</th>
                                                            <th style="text-align: center;">Nilai D</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $banyak = 0; 
                                                            $ke = 1;
                                                            foreach ($dataMember as $membernya) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $membernya->nbi ?></td>
                                                                <td><?= $membernya->nama ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_bimb ?></td>

                                                                <td style="text-align: center;"><?= $membernya->nilai_11 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_12 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_13 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_14 ?></td>
                                                                
                                                                <td style="text-align: center;"><?= $membernya->nilai_21 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_22 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_23 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_24 ?></td>

                                                                <td style="text-align: center;"><?= $membernya->nilai_31 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_32 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_33 ?></td>
                                                                <td style="text-align: center;"><?= $membernya->nilai_34 ?></td>

                                                                <td style="text-align: center;"><?= $membernya->nilai_akhir ?></td>
                                                                <td style="text-align: center;">
                                                                    <select class="form-control" name="nilai_huruf[]">
                                                                        <option value="A" 
                                                                            <?= $membernya->nilai_huruf == 'A' ? 
                                                                                'selected' : '' ?> >
                                                                            A
                                                                        </option>
                                                                        <option value="B"
                                                                            <?= $membernya->nilai_huruf == 'B' ? 
                                                                                'selected' : '' ?> >
                                                                            B
                                                                        </option>
                                                                        <option value="C"
                                                                            <?= $membernya->nilai_huruf == 'C' ? 
                                                                                'selected' : '' ?> >
                                                                            C
                                                                        </option>
                                                                        <option value="D"
                                                                            <?= $membernya->nilai_huruf == 'D' ? 
                                                                                'selected' : '' ?> >
                                                                            D
                                                                        </option>
                                                                        <option value="E"
                                                                            <?= $membernya->nilai_huruf == 'E' ? 
                                                                                'selected' : '' ?> >
                                                                            E
                                                                        </option>
                                                                    </select>
                                                                    <input type="hidden" name="thn_ajaran[]" 
                                                                        value="<?= $membernya->thn_ajaran ?>"/>
                                                                    <input type="hidden" name="kode_kel[]" 
                                                                        value="<?= $membernya->kode_kel ?>"/> 
                                                                    <input type="hidden" name="smt[]" value="<?= $membernya->smt ?>"/> 
                                                                    <input type="hidden" name="nbi[]" value="<?= $membernya->nbi ?>"/>
                                                                </td>
                                                            </tr>
                                                        <?php 
                                                                $ke++;
                                                                $banyak++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <input type="hidden" id="n_point" name="n_point" value="<?= $banyak ?>" />
                                            </div>
                                            <div class="sub-title"></div>
                                            <div class="text-indent">
                                                <button type="submit" name="btnSimpanUbahNilai" class="btn btn-primary btn-block">   
                                                    <i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i>&nbsp;
                                                    <strong>Simpan Nilai Huruf</strong>
                                                </button>
                                            </div>
                                            </form>
                                            <div class="sub-title">Keterangan</div>
                                            <div class="text-indent">
                                                <ul class="list-group">
                                                    <li class="list-group-item">Nilai A : Nilai Presentasi</li>
                                                    <li class="list-group-item">Nilai B : Nilai Kejelasan Rancangan</li>
                                                    <li class="list-group-item">Nilai C : Nilai Kejelasan Uji Coba</li>
                                                    <li class="list-group-item">Nilai C : Nilai Kelengkapan Dokumen</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="step3" aria-labelledby="document-tab">
                            <div class="row">
                                <!-- Lists -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <div class="title">Data Dokumen</div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-action">
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tbListDokumen" class="table table-striped" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td>Judul Tugas</td>
                                                        <td><?= $judul ?></td>
                                                        <td><?= $btnJudul ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Proposal</td>
                                                        <td><?= $proposal ?></td>
                                                        <td><?= $btnProposal ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Revisi Proposal</td>
                                                        <td><?= $revisi ?></td>
                                                        <td><?= $btnRevisi ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <div class="title">Data Bimbingan</div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-action">
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tbListBimbingan" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal Bimbingan</th>
                                                            <th>Uraian</th>
                                                            <th>Validasi Dosen Pembimbing</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach ($bimbingan as $databimb) {
                                                                $tgl = new DateTime($databimb->tgl);
                                                                $validasi = $databimb->validasi == 1 ? 'Valid' : 'Belum Valid';
                                                        ?>
                                                                <tr>
                                                                    <td><?= $databimb->nou ?></td>
                                                                    <td><?= $tgl->format('d-m-Y') ?></td>
                                                                    <td><?= $databimb->uraian ?></td>
                                                                    <td><?= $validasi ?></td>
                                                                </tr>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Lists -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    $this->load->view('admin/data/group/add_member_modal');
?>

<script type="text/javascript">
    var n_point = 0;
    $(function() {
        n_point = $('#n_point').val();

        addMemberAutoComplete();

        // frmInviteMemberAction
        $('#frmAddMember').on('submit',function(e){
            e.preventDefault();
            nbinya = $('#nbinya').val();
            kode_kel_add = $('#kode_kel_modal_add').val();

            $.ajax({
                url : "<?= base_url('admin/data/group/addMember') ?>",
                method : 'POST',
                data : 'kode_kel_add='+kode_kel_add+'&nbinya='+nbinya,
                dataType : 'JSON',
                success : function(msg) {
                    $('#nbinama').val('');
                    $('#nbinya').val('');

                    if ( msg == 0 ) {
                        $('#addStatus').html('<strong><i>Processing...</i></strong>');

                        setTimeout(function(){ 
                            $('#addStatus').html('<strong><i>Tambah anggota berhasil...</i></strong>');
                            $('#btnAdd').html('Tambahkan');
                            $('#btnAdd').prop('disabled',0);
                            $('#btnCancelAdd').prop('disabled',0);
                            $('#kode_kel_modal_add').val('');

                            window.location.href = "<?= base_url('admin/data/group/detailGroup') ?>/"+kode_kel_add;   
                        }, 3000);
                    } else {
                        $('#addStatus').html('<strong><i style="color:red;">Data peserta tidak ditemukan...</i></strong>');

                        $('#btnAdd').html('Tambahkan');
                        $('#btnAdd').prop('disabled',0);
                        $('#btnCancelAdd').prop('disabled',0);
                    }
                },
                beforeSend : function() {
                    $('#btnAdd').html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspProcessing...');
                    $('#btnAdd').prop('disabled',1);
                    $('#btnCancelAdd').prop('disabled',1);
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    $('#btnAdd').html('Tambahkan');
                    $('#AddStatus').html('<strong><i style="color:red;">Terjadi kesalahan... Reload browser anda...</i></strong>');
                    $('#btnAdd').prop('disabled',0);
                    $('#btnCancelAdd').prop('disabled',0);
                    $('#nbinama').val('');
                    $('#nbinya').val('');
                    $('#kode_kel_modal_add').val('');
                }
            });
        });
    }); // $function

    // for validate title group 
    // param group and status
    // group to get group data, status ( 1 = validate , 0 = cancel validate)
    function validateTitle(group,status) {
        thn_ajaran_validate = group.getAttribute('data-thn_ajaran');
        smt_validate = group.getAttribute('data-smt');
        kode_kel_validate = group.getAttribute('data-kode_kel');

        message_validate = status == 1 ? 'Yakin Ingin Validasi Judul ?' : 'Yakin Ingin Batalkan Validasi Judul ?';

        if ( confirm(message_validate) ) {
            $.ajax({
                url : "<?= base_url('admin/data/group/validateTitle') ?>",
                data : 'thn_ajaran='+thn_ajaran_validate+'&smt='+smt_validate+'&kode_kel='+kode_kel_validate+'&status='+status,
                method : 'POST',
                dataType : 'JSON',
                success : function(msg) {
                    if ( msg == 0 ) {
                        alert('Proses Gagal');
                    }

                    window.location.href = "<?= base_url('admin/data/group/detailGroup/') ?>/"+kode_kel_validate;
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    alert('Error ! Reload Browser Anda');
                }
            });
        }
    }

    //for delete anggota
    //param objek to get data attr 
    function deleteAnggota(objek) {
        thn_ajaran = objek.getAttribute('data-thn_ajaran');
        smt = objek.getAttribute('data-smt');
        kode_kel = objek.getAttribute('data-kode_kel');
        nbi = objek.getAttribute('data-nbi');
        nama = objek.getAttribute('data-nama');

        if ( confirm('Yakin ingin menghapus '+nama+' dari kelompok '+kode_kel+' ?') ) {
            $.ajax({
                url : "<?= base_url('admin/data/group/deleteMemberFromGroup') ?>",
                data : 'thn_ajaran='+thn_ajaran+'&smt='+smt+'&nbi='+nbi+'&kode_kel='+kode_kel,
                method : 'POST',
                dataType : 'JSON',
                success : function(msg) {
                    if ( msg == 1 ) {
                        alert('Anggota berhasil dihapus...');
                    } else {
                        alert('Hapus Gagal...');
                    }

                    window.location.href = "<?= base_url('admin/data/group/detailGroup/') ?>/"+kode_kel;
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    alert('Reload Browser Anda');
                }
            });
        }
    }

    //for showing add anggota modal
    function showAddAnggotaModal() {
        $('#add_member_modal').modal('show');
        $('#kode_kel_modal_add').val($('#kode_kel').val());
    }

    // for add member autocomplete
    function addMemberAutoComplete() {
        $("#nbinama").autocomplete({
            minLength : 4,
            source: "<?= base_url('admin/data/group/getParticipantAutoComplete') ?>",
            focus: function(event, ui){
                $("#nbinama").val( ui.item.label + ' - ' + ui.item.nama );
                return false;
            },
            select: function(event, ui){ //event after choose the suggest
                $('#nbinama').val($('#nbinama').val());
                $("#nbinya").val(ui.item.label);
                $('#btnAdd').focus();
                return false;
            }

        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a><h4>" + item.label + " - " + item.nama + "</h4></a>" )
            .appendTo( ul );
        };
    }

</script>
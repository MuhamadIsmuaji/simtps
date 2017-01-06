<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    $judul = $dataGroup->judul == NULL ? '-' : $dataGroup->judul;
    $proposal = $dataGroup->proposal == NULL ? '-' : $dataGroup->proposal;
    $revisi = $dataGroup->revisi == NULL ? '-' : $dataGroup->revisi;
    $validasi = $dataGroup->validasi == 1 ? 'Disetujui' : 'Belum Disetujui'; 

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
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?= $dataGroup->kode_kel.' - Tahun Ajaran '.$settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?>
                    </div>
                </div>
                <div class="pull-right card-action">
                    <a href="<?= base_url('lecturer/data/group/groupGuidance/'.$dataGroup->thn_ajaran.'/'.$dataGroup->smt.'/'.$dataGroup->kode_kel) ?>" class="btn btn-primary">
                        <i class="fa fa-book fa-lg" aria-hidden="true"></i>&nbsp;
                        <strong>Bimbingan</strong>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td><?= $judul ?></td>
                            <td><?= $btnJudul ?></td>
                        </tr>
                        <tr>
                            <td>Proposal</td>
                            <td>:</td>
                            <td>
                                <a href="<?= base_url('lecturer/data/group/downloadGroupDocument/1/'.$proposal) ?>" target="_blank">
                                    <?= $proposal ?>
                                </a>   
                            </td>
                            <td> </td>

                        </tr>
                        <tr>
                            <td>Revisi Proposal</td>
                            <td>:</td>
                            <td>
                                <a href="<?= base_url('lecturer/data/group/downloadGroupDocument/2/'.$revisi) ?>">
                                    <?= $revisi ?>
                                </a>  
                            </td>
                            <td> </td>

                        </tr>
                        <tr>
                            <td>Status Judul</td>
                            <td>:</td>
                            <td><?= $validasi ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Anggota Kelompok</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbLecturerListsAdmin" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center;">NBI</th>
                                <th rowspan="2" style="text-align: center;">NAMA</th>
                                <th rowspan="2" style="text-align: center;">Bimbingan</th>
                                <th colspan="4" style="text-align: center;">Penilaian Moderator</th>
                                <th colspan="4" style="text-align: center;">Penilaian Penguji 1</th>
                                <th colspan="4" style="text-align: center;">Penilaian Penguji 2</th>
                                <th rowspan="2" style="text-align: center; width: 70px;">Akhir</th>
                                <th rowspan="2" style="text-align: center; width: 95px;">Huruf</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">Presentasi</th>
                                <th style="text-align: center;">Kejelasan Rancangan</th>
                                <th style="text-align: center;">Kejelasan Uji Coba</th>
                                <th style="text-align: center;">Kelengkapan Dokumen</th>
                                <th style="text-align: center;">Presentasi</th>
                                <th style="text-align: center;">Kejelasan Rancangan</th>
                                <th style="text-align: center;">Kejelasan Uji Coba</th>
                                <th style="text-align: center;">Kelengkapan Dokumen</th>
                                <th style="text-align: center;">Presentasi</th>
                                <th style="text-align: center;">Kejelasan Rancangan</th>
                                <th style="text-align: center;">Kejelasan Uji Coba</th>
                                <th style="text-align: center;">Kelengkapan Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($groupMember as $member) {
                            ?>
                                <tr>
                                    <td><?= $member->nbi ?></td>
                                    <td><?= $member->nama ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_bimb ?></td>

                                    <td style="text-align: center;"><?= $member->nilai_11 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_12 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_13 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_14 ?></td>
                                    
                                    <td style="text-align: center;"><?= $member->nilai_21 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_22 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_23 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_24 ?></td>

                                    <td style="text-align: center;"><?= $member->nilai_31 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_32 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_33 ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_34 ?></td>

                                    <td style="text-align: center;"><?= $member->nilai_akhir ?></td>
                                    <td style="text-align: center;"><?= $member->nilai_huruf ?></td>
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
</div>

<script type="text/javascript">
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
                url : "<?= base_url('lecturer/data/group/validateTitle') ?>",
                data : 'thn_ajaran='+thn_ajaran_validate+'&smt='+smt_validate+'&kode_kel='+kode_kel_validate+'&status='+status,
                method : 'POST',
                dataType : 'JSON',
                success : function(msg) {
                    if ( msg == 0 ) {
                        alert('Proses Gagal');
                    }

                    window.location.href = "<?= base_url('lecturer/data/group/detailGroup/') ?>/"+thn_ajaran_validate+'/'+smt_validate+'/'
                    +kode_kel_validate;
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    alert('Error ! Reload Browser Anda');
                }
            });
        }
    }
</script>
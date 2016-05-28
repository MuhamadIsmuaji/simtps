<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    $judul = $dataGroup->judul == NULL ? '-' : $dataGroup->judul;
    $proposal = $dataGroup->proposal == NULL ? '-' : $dataGroup->proposal;
    $revisi = $dataGroup->revisi == NULL ? '-' : $dataGroup->revisi;
    $validasi = $dataGroup->validasi == 1 ? 'Disetujui' : 'Belum Disetujui'; 
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
                        </tr>
                        <tr>
                            <td>Proposal</td>
                            <td>:</td>
                            <td>
                                <a href="<?= base_url('lecturer/data/group/downloadGroupDocument/1/'.$proposal) ?>" target="_blank">
                                    <?= $proposal ?>
                                </a>   
                            </td>

                        </tr>
                        <tr>
                            <td>Revisi Proposal</td>
                            <td>:</td>
                            <td>
                                <a href="<?= base_url('lecturer/data/group/downloadGroupDocument/2/'.$revisi) ?>">
                                    <?= $revisi ?>
                                </a>  
                            </td>
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
<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
    $disabled = $identitasJadwal->validasi == 1 ? 'disabled' : '';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Jadwal Sidang Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
                </div>
                <div class="pull-right card-action">
                    <a href="<?= base_url('admin/data/schedule/hearingScheduleEdit/'.$identitasJadwal->thn_ajaran.'/'.$identitasJadwal->smt.'/'.$identitasJadwal->ruang.'/'.$identitasJadwal->tgl.'/'.$identitasJadwal->mulai.'/'.$identitasJadwal->akhir) ?>" class="btn btn-primary" <?= $disabled ?>>Edit Jadwal</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbNewsListsAdmin" class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td>Ruang</td>
                            <td>:</td>
                            <td><?= $identitasJadwal->ruang ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>
                                <?php
                                    $tgl = new DateTime($identitasJadwal->tgl);
                                    echo $tgl->format('d-m-Y');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td>
                                <?php 
                                    $mulai = $identitasJadwal->mulai <= 9 ? '0'.$identitasJadwal->mulai.':00' : $identitasJadwal->mulai.':00';
                                    $akhir = $identitasJadwal->akhir <= 9 ? '0'.$identitasJadwal->akhir.':00' : $identitasJadwal->akhir.':00'; 
                                    echo $mulai.' - '.$akhir;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Moderator</td>
                            <td>:</td>
                            <td><?= $moderator ?></td>
                        </tr>
                        <tr>
                            <td>Penguji 1</td>
                            <td>:</td>
                            <td><?= $penguji1 ?></td>
                        </tr>
                        <tr>
                            <td>Penguji 2</td>
                            <td>:</td>
                            <td><?= $penguji2 ?></td>
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
                    <div class="title">Daftar Kelompok</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbLecturerListsAdmin" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE KELOMPOK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                foreach ($detailJadwal as $value2) {
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $value2->kode_kel ?></td>
                                </tr>
                            <?php 
                                    $no++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
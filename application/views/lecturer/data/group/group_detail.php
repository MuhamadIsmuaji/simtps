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
                    	Bimbingan
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
                       		<td><?= $proposal ?></td>
                       	</tr>
						<tr>
                       		<td>Revisi Proposal</td>
                       		<td>:</td>
                       		<td><?= $revisi ?></td>
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
                                <th rowspan="2">NBI</th>
                                <th rowspan="2">NAMA</th>
                                <th rowspan="2">Nilai Bimbingan</th>
                                <th colspan="4">Penilaian Moderator</th>
                                <th colspan="4">Penilaian Penguji 1</th>
                                <th colspan="4">Penilaian Penguji 2</th>
                                <th rowspan="2">Nilai Akhir</th>
                                <th rowspan="2">Nilai Huruf</th>
                            </tr>
                            <tr>
                                <th>Nilai A</th>
                                <th>Nilai B</th>
                                <th>Nilai C</th>
                                <th>Nilai D</th>
                                <th>Nilai A</th>
                                <th>Nilai B</th>
                                <th>Nilai C</th>
                                <th>Nilai D</th>
                                <th>Nilai A</th>
                                <th>Nilai B</th>
                                <th>Nilai C</th>
                                <th>Nilai D</th>
                            </tr>
                        </thead>
                        <tbody>
                         	<?php 
                         		foreach ($groupMember as $member) {
                         	?>
								<tr>
									<td><?= $member->nbi ?></td>
									<td><?= $member->nama ?></td>
									<td><?= $member->nilai_bimb ?></td>

									<td><?= $member->nilai_11 ?></td>
									<td><?= $member->nilai_12 ?></td>
									<td><?= $member->nilai_13 ?></td>
									<td><?= $member->nilai_14 ?></td>
									
									<td><?= $member->nilai_21 ?></td>
									<td><?= $member->nilai_22 ?></td>
									<td><?= $member->nilai_23 ?></td>
									<td><?= $member->nilai_24 ?></td>

									<td><?= $member->nilai_31 ?></td>
									<td><?= $member->nilai_32 ?></td>
									<td><?= $member->nilai_33 ?></td>
									<td><?= $member->nilai_34 ?></td>

									<td><?= $member->nilai_akhir ?></td>
									<td><?= $member->nilai_huruf ?></td>
								</tr>
                         	<?php 
                         		}
                         	?>
                        </tbody>
                    </table>
                </div>
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
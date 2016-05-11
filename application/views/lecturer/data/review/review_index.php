<?php 
	$next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                    	Review Sidang <?= 'Tahun Ajaran '.$settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="step">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="step" class="active">
                            <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                <div class="icon fa fa-star"></div>
                                <div class="step-title">
                                    <div class="title">Moderator</div>
                                    <div class="description">Review sidang sebagai moderator.</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-star"></div>
                                <div class="step-title">
                                    <div class="title">Penguji 1</div>
                                    <div class="description">Review sidang sebagai penguji 1</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step3" role="tab" id="step3-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-star"></div>
                                <div class="step-title">
                                    <div class="title">Penguji 2</div>
                                    <div class="description">Review sidang sebagai penguji 2</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                            <div class="table-responsive">
                            <form action="<?= base_url('penilaian/penilaianSidang') ?>" method="POST">
				        		<table id="tbModerator" class="table table-striped" cellspacing="0" width="100%">
				                    <thead>
				                        <tr>
				                            <th>NBI</th>
				                            <th>Nama</th>
				                            <th>Kelompok</th>
				                            <th>Presentasi</th>
				                            <th>Kejelasan Rancangan</th>
				                            <th>Kejelasan Uji Coba</th>
				                            <th>Kelengkapan Dokumen</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    	<?php
				                    		foreach ($groupModerator as $value) {
												foreach ($value as $value2) {
				                    	?>
											
											<tr>
												<td><?= $value2->nbi ?></td>
												<td><?= $value2->nama ?></td>
												<td><?= $value2->kode_kel ?></td>
												<td>
													<input type="text" name="nilai_11[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_11 ?>" onkeypress="return numbersonly(this,event)" required />
													<input type="hidden" name="nbi[]" 
														value="<?= $value2->nbi ?>" />
													<input type="hidden" name="kode_kel[]" 
														value="<?= $value2->kode_kel ?>" />
													<input type="hidden" name="thn_ajaran[]" 
														value="<?= $value2->thn_ajaran ?>" />
													<input type="hidden" name="smt[]" 
														value="<?= $value2->smt ?>" />
												</td>
												<td>
													<input type="text" name="nilai_12[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_12 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_13[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_13 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_14[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_14 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
											</tr>

				                    	<?php 
				                    			}
				                    		}
				                    	?>
				                    </tbody>
								</table>
	        				</div>
	        				<div class="sub-title"></div>
			                <div class="text-indent">
			                    <input type="submit" name="btnSimpanNilaiModerator" class="btn btn-primary" value="Simpan" />
			                </div>
			                </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">
                        	<div class="table-responsive">
                            <form action="<?= base_url('penilaian/penilaianSidang') ?>" method="POST">
				        		<table id="tbPenguji" class="table table-striped" cellspacing="0" width="100%">
				                    <thead>
				                        <tr>
				                            <th>NBI</th>
				                            <th>Nama</th>
				                            <th>Kelompok</th>
				                            <th>Presentasi</th>
				                            <th>Kejelasan Rancangan</th>
				                            <th>Kejelasan Uji Coba</th>
				                            <th>Kelengkapan Dokumen</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    	<?php
				                    		foreach ($groupPenguji1 as $value) {
												foreach ($value as $value2) {
				                    	?>
											
											<tr>
												<td><?= $value2->nbi ?></td>
												<td><?= $value2->nama ?></td>
												<td><?= $value2->kode_kel ?></td>
												<td>
													<input type="text" name="nilai_21[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_21 ?>" onkeypress="return numbersonly(this,event)" required />
													<input type="hidden" name="nbi[]" 
														value="<?= $value2->nbi ?>" />
													<input type="hidden" name="kode_kel[]" 
														value="<?= $value2->kode_kel ?>" />
													<input type="hidden" name="thn_ajaran[]" 
														value="<?= $value2->thn_ajaran ?>" />
													<input type="hidden" name="smt[]" 
														value="<?= $value2->smt ?>" />
												</td>
												<td>
													<input type="text" name="nilai_22[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_22 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_23[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_23 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_24[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_24 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
											</tr>

				                    	<?php 
				                    			}
				                    		}
				                    	?>
				                    </tbody>
								</table>
	        				</div>
	        				<div class="sub-title"></div>
			                <div class="text-indent">
			                    <input type="submit" name="btnSimpanNilaiPenguji1" class="btn btn-primary" value="Simpan" />
			                </div>
			                </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="step3" aria-labelledby="dropdown1-tab">
                        	<div class="table-responsive">
                            <form action="<?= base_url('penilaian/penilaianSidang') ?>" method="POST">
				        		<table id="tbModerator" class="table table-striped" cellspacing="0" width="100%">
				                    <thead>
				                        <tr>
				                            <th>NBI</th>
				                            <th>Nama</th>
				                            <th>Kelompok</th>
				                            <th>Presentasi</th>
				                            <th>Kejelasan Rancangan</th>
				                            <th>Kejelasan Uji Coba</th>
				                            <th>Kelengkapan Dokumen</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    	<?php
				                    		foreach ($groupPenguji2 as $value) {
												foreach ($value as $value2) {
				                    	?>
											
											<tr>
												<td><?= $value2->nbi ?></td>
												<td><?= $value2->nama ?></td>
												<td><?= $value2->kode_kel ?></td>
												<td>
													<input type="text" name="nilai_31[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_31 ?>" onkeypress="return numbersonly(this,event)" required />
													<input type="hidden" name="nbi[]" 
														value="<?= $value2->nbi ?>" />
													<input type="hidden" name="kode_kel[]" 
														value="<?= $value2->kode_kel ?>" />
													<input type="hidden" name="thn_ajaran[]" 
														value="<?= $value2->thn_ajaran ?>" />
													<input type="hidden" name="smt[]" 
														value="<?= $value2->smt ?>" />
													
												</td>
												<td>
													<input type="text" name="nilai_32[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_32 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_33[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_33 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
												<td>
													<input type="text" name="nilai_34[]" style="text-align: center;" size="4" 
														value="<?= $value2->nilai_34 ?>" onkeypress="return numbersonly(this,event)" required />
												</td>
											</tr>

				                    	<?php 
				                    			}
				                    		}
				                    	?>
				                    </tbody>
								</table>
	        				</div>
	        				<div class="sub-title"></div>
			                <div class="text-indent">
			                    <input type="submit" name="btnSimpanNilaiPenguji2" class="btn btn-primary" value="Simpan" />
			                </div>
			                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
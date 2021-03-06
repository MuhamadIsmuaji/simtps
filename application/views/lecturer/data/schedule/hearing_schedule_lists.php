<?php 
    $next = $settingData->thn_ajaran+1;
    $semester = $settingData->smt == 1 ? 'Ganjil' : 'Genap' ; 
?>

<div class="page-title">
   <div class="row">
         <div class="col-md-8">
            <span class="title">Jadwal Sidang Tugas Perancangan Sistem</span>
            <div class="description">Tahun Ajaran <?= $settingData->thn_ajaran.' / '.$next.' Semester '. $semester ?></div>
         </div>
   </div>
</div>
<div class="row">
    <!-- Lists -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Data Jadwal Sidang - <?= $this->session->userdata('nama'); ?></div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-action">
                </div>
                <div class="table-responsive">
                    <table id="tbNewsListsAdmin" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <!-- <th style="text-align: center;">No</th> -->
                                <th style="text-align: center; width: 100px">Tanggal</th>
                                <th style="text-align: center;">Waktu</th>
                                <th style="text-align: center;">Ruang</th>
                                <th style="text-align: center;width: 120px;"">Moderator</th>
                                <th style="text-align: center;width: 120px;"">Penguji 1</th>
                                <th style="text-align: center;width: 120px;"">Penguji 2</th>
                                <th style="text-align: center;">Kelompok</th>
                                <th style="text-align: center; width: 250px;">Judul</th>
                                <th style="text-align: center; width: 300px;"">Anggota Kelompok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach ($dataJadwal as $ke) {
                                    echo '<tr>';
                                        // echo '<td style="text-align: center;">'. $no .'</td>';
                                    foreach ($ke as $jadwal) {
                                        echo '<td style="text-align: center;">';
                                        
                                        if ( is_array($jadwal) ) {
                                            foreach ($jadwal as $anggota) {
                                               foreach ($anggota as $key => $dataAnggota) {
                                                   // echo $dataAnggota.'&nbsp;&nbsp;&nbsp;&nbsp;';
                                                   echo '<p class="text-left">'.$dataAnggota.'</p>';

                                               }
                                               echo '<br/>';
                                            }
                                        } else {
                                            echo $jadwal;
                                        }

                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                    $no++;
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
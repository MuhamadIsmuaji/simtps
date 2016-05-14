<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= $news->judul ?></div>
                    <div class="description">
                    	<?php 
                    		$tgl = new DateTime($news->tgl);
                    		$tgl_exp = new DateTime($news->tgl_exp);
                    		$validasi = $news->validasi == 1 ? 'Dipublikasi' : 'Belum Dipublikasi';
                    		echo "Dibuat Pada : ".$tgl->format('d-m-Y');
                    	?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-indent">
                	<?= $news->isi ?>
                </div>
				<?php 
					if ($news->lampiran != NULL) {
						echo '
                        <div class="sub-title">Lampiran File</div>
                        <div class="text-indent">
                            Unduh Lampiran File Pengumuman : <a href="'.base_url('public/news/downloadAttachmentFile/'.$news->lampiran).'" class="btn btn-success" style="padding-left:0px;">
                                <strong>Unduh</strong>
                                <i class="fa fa-download" aria-hidden="true"></i></a>
                        </div>';
					} else {
						echo '';
					}
				?>
                </div>
            </div>
        </div>
    </div>
</div>
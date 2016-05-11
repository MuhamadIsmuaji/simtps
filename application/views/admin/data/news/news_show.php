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
                    		echo "Dibuat Pada : ".$tgl->format('d-m-Y')."&nbsp Kadaluarsa Pada : ".$tgl_exp->format('d-m-Y')."<br/>";
                    		echo "Status : ".$validasi;
                    	?>
                    </div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
	        			<a href="<?= base_url('admin/data/news/edit/'.$news->id) ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>	        		
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
                            Unduh Lampiran File Pengumuman : <a href="'.base_url('public/news/downloadAttachmentFile/'.$news->lampiran).'" class="btn btn-success" style="padding-left:0px;">Unduh<i class="fa fa-download"></i></a>
                        </div>';
                    } else {
                        echo '';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
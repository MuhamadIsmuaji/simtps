<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="list-group">
                    <?php 
                    	foreach ($newsList as $news) {
                        $tgl = new DateTime($news->tgl);
                    ?>
						<a href="<?= base_url('public/news/show/'.$news->id.'/'.$news->slug) ?>" class="list-group-item">
                        	<span class="badge"><h6><?= $tgl->format('d-m-Y') ?></h6></span>
                            <h5><strong><?= $news->judul ?></strong></h5>
                    	</a>

                   <?php } ?>
                </div>
                <div class="sub-title"></div>
                <h5><?= $links ?></h5>
            </div>
        </div>
    </div>
</div>
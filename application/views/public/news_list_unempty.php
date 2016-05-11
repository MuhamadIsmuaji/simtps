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
                        	<span class="badge"><?= $tgl->format('d-m-Y') ?></span> <strong><?= $news->judul ?></strong>
                    	</a>

                   <?php } ?>
                </div>
                <div class="sub-title"></div>
                <?= $links ?>
            </div>
        </div>
    </div>
</div>
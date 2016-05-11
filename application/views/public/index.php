 <div class="page-title">
    <span class="title">Pengumuman Terbaru</span>
    <div class="description">Sistem Informasi Manajemen Tugas Perancangan Sistem Teknik Informatika Untag Surabaya</div>
</div>

<?php 
	if ($check) {
		$this->load->view('public/index_news');
	} else {
		$this->load->view('public/index_news_empty');
	}
?>
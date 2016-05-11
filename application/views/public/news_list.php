<div class="page-title">
    <span class="title">Daftar Pengumuman</span>
    <div class="description">Sistem Informasi Manajemen Tugas Perancangan Sistem Teknik Informatika Untag Surabaya</div>
</div>

<?php 
	if ($check) {
		$this->load->view('public/news_list_unempty');
	} else {
		$this->load->view('public/news_list_empty');
	}
?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$data = [
			'content' 		=> 'admin/data/news/news_lists',
			'pagetitle' 	=> 'Data Pengumuman',
			'navbartitle' 	=> 'Data Pengumuman'
		];

		$this->load->view('template',$data);
	}

	private function generateDateFormat($date = null) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$getDate = new DateTime($date);
		return  $getDate->format('Y-m-d');
	}

	private function generateSlug($title = null ) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		$temp = explode(' ', $title);
		$length = count($temp);
		$slug = $temp[0];
		$index = 1;
		for ($i=2;$i<=$length;$i++){
			$slug = $slug.'-'.$temp[$index];
			$index++;
		}
		return $slug;
	}

	// Data pengumuman di admin
	public function newsListsAdmin() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_POST) ) {
			redirect('admin/dashboard','refresh');
		}

		$list = $this->M_pengumuman->newsListsAdmin();
        $no = $this->input->post('start');
        $data = array();
        $no_cb = 1;

        foreach ($list as $news) {
            $no++;
            $row = array();

			$row[] = '<input type="checkbox" id="cbNews'. $no_cb .'" value="'. $news->id .'" onchange="checkNewsSelected()">';
         	$no_cb++;
         	$tgl = new DateTime($news->tgl);
         	$tgl_exp = new DateTime($news->tgl_exp);
            $row[] = $tgl->format('d-m-Y');
            $row[] = $tgl_exp->format('d-m-Y');
            $row[] = $news->judul;
            $validasi = $news->validasi == 1 ? 'Sudah Dipublikasi' : 'Belum Dipublikasi';
            $row[] = $validasi;
            
            $aksi = '<a href="'. base_url('admin/data/news/show/'.$news->id.'/'.$news->slug).'" class="btn btn-success"><span class="icon fa fa-eye"></span></a>
					 <a href="'. base_url('admin/data/news/edit/'.$news->id) .'" class="btn btn-primary"><span class="icon fa fa-pencil"></span></a>';

            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "draw"  			=> $this->input->post('draw'),
            "recordsTotal"      => $this->M_pengumuman->countAll(),
            "recordsFiltered"   => $this->M_pengumuman->countFiltered(),
            "data"              => $data,
        );

        echo json_encode($output);
	}
	// Data pengumuman di admin

	public function processDeleteNews() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( empty($_GET) ) {
			redirect('admin/data/news','refresh');
		}

		for( $i=1; $i<=$this->input->get('jml'); $i++) { //ulangi sebanyak jml yg akan dihapus
            
            $id = $this->input->get('id'.$i);
            $news = $this->M_pengumuman->getNewsById($id)->row();
			
            if ($news->lampiran != NULL)
            	unlink('assets/files/news/'.$news->lampiran);
            
            $deleteProcess = $this->M_pengumuman->delete($id);
        }

        if ($deleteProcess){
        	echo json_encode('Hapus Data Pengumuman Berhasil..');
        } else {
        	echo json_encode('Terjadi Kesalahan.. Reload Browser Anda...');
        }
	}

	public function show($id = null , $slug = null) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $id == NULL || $slug == NULL ) {
			//not found page
			redirect('admin/dashboard','refresh');
		}

		$news = $this->M_pengumuman->getNewsByIdandSlug($id,$slug)->num_rows();
		if (!$news) {
			//not found page
			redirect('admin/dashboard','refresh');
		}

		$news = $this->M_pengumuman->getNewsByIdandSlug($id,$slug)->row();

		$data = [
			'content' 		=> 'admin/data/news/news_show',
			'pagetitle' 	=> 'Lihat Pengumuman',
			'navbartitle' 	=> 'Lihat Pengumuman',
			'news'			=> $news
		];

		$this->load->view('template',$data);

	}

	public function edit($id = null) {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if ( $id == NULL ) {
			//not found page
			redirect('admin/data/news','refresh');
		}

        $news = $this->M_pengumuman->getNewsById($id)->row();

        if (!$news) { // Jika pengumuman tidak ada
			redirect('admin/data/news','refresh');
        } else { // Jika pengumuman ada
        	if ($this->input->post('btnUpdateNews')) { // proses update

        		$tgl = $this->generateDateFormat($this->input->post('tgl'));
				$tgl_exp = $this->generateDateFormat($this->input->post('tgl_exp'));
				$judul = $this->input->post('judul');
				$slug = $this->generateSlug($this->input->post('judul'));
				$isi = $this->input->post('isi');
				$validasi = $this->input->post('validasi');
				$now = date('Y-m-d');

				if ( $tgl_exp <= $now && $tgl < $now ) { // Jika tgl atau tgl_exp tidak memenuhi syarat
					$errorMessage = 'Tanggal Publikasi dan Tanggal Kadaluarsa Tidak Boleh Kurang Dari Tanggal Sekarang...';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';	
				} else if ( $tgl_exp <= $now ) { // Jika tgl_exp tidak memenuhi syarat
					$errorMessage = 'Tanggal Kadaluarsa Harus Lebih Dari Tanggal Sekarang...';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';	
				} else if ( $tgl < $now ) { // Jika tgl tidak memenuhi syarat
					$errorMessage = 'Tanggal Publikasi Tidak Boleh Kurang Dari Tanggal Sekarang...';
					$divClass = 'alert fresh-color alert-danger alert-dismissible';	
				} else { // Jika exp_date memenuhi

					if ( $_FILES['lampiran']['size'] == 0 ) { // Jika file ada file lampiran
						$isFile = false;
					} else { // Jika tidak ada file lampiran
						$isFile = true;
					}

					if ($isFile) { // Upload file
						$config['upload_path']          = './assets/files/news/';
						$config['allowed_types']        = 'pdf|docx|xlsx|jpg|jpeg|png|bmp';
						$config['max_size']             = 2048; //2 MB
						$config['remove_spaces']        = TRUE;
						$config['file_ext_tolower']		= TRUE;
						$config['overwrite']			= false;
						$this->load->library('upload', $config);

						if ( ! $this->upload->do_upload('lampiran') ) { // Jika upload file lampiran tidak sesuai
							$errorMessage = '<strong>Terjadi Kesalahan Upload File Lampiran. Pastikan File Sesuai Dengan Ketentuan !!!</strong>';
							$divClass = 'alert fresh-color alert-danger alert-dismissible';
							$isUpload = false;
						} else { // Jika upload file lampiran sesuai
            				
            				if ($news->lampiran != NULL) // Jika file null tidak dilakukan penghapusan
            					unlink('assets/files/news/'.$news->lampiran);

							$lampiran = $this->upload->data('file_name');
							$isUpload = true;
						}
					} else {
						$lampiran = $news->lampiran;
						$isUpload = true;
					}

					if ($isUpload) {
						$newsData = [
							'tgl'		=> $tgl,
							'judul'		=> $judul,
							'isi'		=> $isi,
							'tgl_exp'	=> $tgl_exp,
							'lampiran'	=> $lampiran,
							'slug'		=> $slug,
							'validasi'	=> $validasi
						];

						$updateNews = $this->M_pengumuman->update($id,$newsData);
						if ($updateNews) {
							redirect('admin/data/news/show/'.$id.'/'.$slug,'refresh');
						} else {
							$errorMessage = '<strong>Edit pengumuman gagal..</strong>';
							$divClass = 'alert fresh-color alert-danger alert-dismissible';
						}
					} 
				}

        	} else { // Selain proses update
        		$errorMessage = null;
        		$divClass = null;
        	}

			$data = [
				'content' 		=> 'admin/data/news/news_edit',
				'pagetitle' 	=> 'Edit Pengumuman',
				'navbartitle' 	=> 'Edit Pengumuman',
				'news'			=> $news,
				'errorMessage'	=> $errorMessage,
				'divClass'		=> $divClass
			];

			$this->load->view('template',$data);
        }

	}

	public function create() {
		if ( !$this->session->userdata('isAdminTps') ) {
			redirect('public/home','refresh');
		}

		if (!empty($_POST)) {

			$tgl = $this->generateDateFormat($this->input->post('tgl'));
			$tgl_exp = $this->generateDateFormat($this->input->post('tgl_exp'));
			$judul = $this->input->post('judul');
			$slug = $this->generateSlug($this->input->post('judul'));
			$isi = $this->input->post('isi');
			$validasi = $this->input->post('validasi');
			$now = date('Y-m-d');

			if ( $tgl_exp <= $now && $tgl < $now ) { // Jika tgl atau tgl_exp tidak memenuhi syarat
				$errorMessage = 'Tanggal Publikasi dan Tanggal Kadaluarsa Tidak Boleh Kurang Dari Tanggal Sekarang...';
				$divClass = 'alert fresh-color alert-danger alert-dismissible';	
			} else if ( $tgl_exp <= $now ) { // Jika tgl_exp tidak memenuhi syarat
				$errorMessage = 'Tanggal Kadaluarsa Harus Lebih Dari Tanggal Sekarang...';
				$divClass = 'alert fresh-color alert-danger alert-dismissible';	
			}else if ( $tgl < $now ) { // Jika tgl tidak memenuhi syarat
				$errorMessage = 'Tanggal Publikasi Tidak Boleh Kurang Dari Tanggal Sekarang...';
				$divClass = 'alert fresh-color alert-danger alert-dismissible';	
			}else { // Jika tgl memenuhi syarat

				if ( $_FILES['lampiran']['size'] == 0 ) { // Jika file ada file lampiran
					$isFile = false;
				} else { // Jika tidak ada file lampiran
					$isFile = true;
				}

				if ($isFile) { // Upload file
					$config['upload_path']          = './assets/files/news/';
					$config['allowed_types']        = 'pdf|docx|xlsx|jpg|jpeg|png|bmp';
					$config['max_size']             = 2048; //2 MB
					$config['remove_spaces']        = TRUE;
					$config['file_ext_tolower']		= TRUE;
					$config['overwrite']			= false;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('lampiran') ) { // Jika upload file lampiran tidak sesuai
						$errorMessage = '<strong>Terjadi Kesalahan Upload File Lampiran. Pastikan File Sesuai Dengan Ketentuan !!!</strong>';
						$divClass = 'alert fresh-color alert-danger alert-dismissible';
						$isUpload = false;
					} else { // Jika upload file lampiran sesuai
						$lampiran = $this->upload->data('file_name');
						$isUpload = true;
					}
				} else {
					$lampiran = NULL;
					$isUpload = true;
				}

				if ($isUpload) {
					$newsData = [
						'tgl'		=> $tgl,
						'judul'		=> $judul,
						'isi'		=> $isi,
						'tgl_exp'	=> $tgl_exp,
						'lampiran'	=> $lampiran,
						'slug'		=> $slug,
						'validasi'	=> $validasi
					];

					$insertNews = $this->M_pengumuman->insert($newsData);
					if ($insertNews) {
						$errorMessage = '<strong>Buat pengumuman berhasil. </strong>';
						$divClass = 'alert fresh-color alert-success alert-dismissible';
					} else {
						$errorMessage = null;
						$divClass = null;
					}
				} 
			}
		} else {
			$errorMessage = null;
			$divClass = null;
		}

		$data = [
			'content' 		=> 'admin/data/news/news_create',
			'pagetitle' 	=> 'Tambah Pengumuman',
			'navbartitle' 	=> 'Tambah Pengumuman',
			'errorMessage'	=> $errorMessage,
			'divClass'		=> $divClass
		];

		$this->load->view('template',$data);
	}	
}

/* End of file News.php */
/* Location: ./application/controllers/admin/data/News.php */
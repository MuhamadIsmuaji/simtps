<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	function construct() {
		parent::__construct();
	}

	public function index() {
		redirect('public/news/newsList','refresh');
	}

	public function newsList() {

		$dateNow = date('Y-m-d');
		$config = [
			'base_url'			=> base_url('public/news/newsList'),
			'total_rows'		=> $this->M_pengumuman->newsRecord($dateNow),
			'per_page'			=> 5,
			'uri_segment'		=> 4,
			'use_page_numbers'	=> TRUE,
			'num_links'			=> 2,
			'next_link'			=> '>',
			'prev_link'			=> '<',
			'first_link'		=> FALSE,
			'last_link'			=> FALSE,
			'cur_tag_open'		=> '<li class="active"><a href="#">', 
			'cur_tag_close'		=> '</a></li>',
			'num_tag_open'		=> '<li>',
			'num_tag_close'		=> '</li>',
			'full_tag_open'		=> '<ul class="pagination">',
			'full_tag_close'	=> '</ul>',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'prev_link'			=> '&laquo',
			'prev_tag_open'		=> '<li class="prev">',
			'prev_tag_close'	=> '</li>',
			'next_link'			=> '&raquo',
			'next_tag_open'		=> '<li>',
			'next_tag_close'	=> '</li>',
			'last_tag_open'		=> '<li>',
			'last_tag_close'	=> '</li>'
		];

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		//To avoid show same object in other page
		$offset = $page == 0 ? 0 : ($page-1) * $config['per_page'];
		
		$newsList = $this->M_pengumuman->newsListsPublic($config["per_page"], $offset, $dateNow)->result_object();

        $links =  $this->pagination->create_links();
	

		$data = [
			'content' 		=> 'public/news_list',
			'pesan'			=> 'ini halaman daftar pengumuman',
			'pagetitle' 	=> 'Daftar Pengumuman',
			'navbartitle' 	=> 'Lab. RPL Untag Surabaya',
			'newsList'		=> $newsList,
			'links'			=> $links,
			'check'			=> $config['total_rows']			

		];

		$this->load->view('template',$data);
	}

	public function downloadAttachmentFile($fileName = null) {
		if ( $fileName == null ) {
			redirect('public/home','refresh');
		}

		if ( file_exists('assets/files/news/'.$fileName) ) {
			$this->load->helper('download');
			$file = file_get_contents('assets/files/news/'.$fileName);
			force_download($fileName, $file);
		} else {
			//not found page
			redirect('public/home','refresh');
		}
	}

	public function show($id = null, $slug = null) {
		if ( $id == NULL || $slug == NULL ) {
			//not found page
			redirect('public/home','refresh');
		}

		$news = $this->M_pengumuman->getNewsByIdandSlug($id,$slug)->num_rows();
		if (!$news) {
			//not found page
			redirect('public/home','refresh');
		}

		$news = $this->M_pengumuman->getNewsByIdandSlug($id,$slug)->row();

		$data = [
			'content' 		=> 'public/news_show',
			'pagetitle' 	=> 'Detail Pengumuman',
			'navbartitle' 	=> 'Detail Pengumuman',
			'news'			=> $news
		];

		$this->load->view('template',$data);
	}


}

/* End of file News.php */
/* Location: ./application/controllers/public/News.php */
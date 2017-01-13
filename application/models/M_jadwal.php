<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal extends CI_Model {
	
	private $table = 'tb_jadwal';
	private $pk1 = 'thn_ajaran';
	private $pk2 = 'smt';
	private $pk3 = 'kode_kel';

	function __construct() {
		parent::__construct();
	}

	public function reviewSchedule($thn_ajaran = NULL, $smt = NULL, $npp = NULL,$what = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where($what,$npp);
		$query = $this->db->get();
		return $query;
	}

	public function deleteBySchedule($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $moderator = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where('ruang',$ruang);
		$this->db->where('moderator',$moderator);
		$this->db->where('tgl',$tgl);
		$this->db->where('mulai',$mulai);
		$this->db->where('akhir',$akhir);
		return $this->db->delete($this->table);
	}

	public function insert($scheduleData = null) {
		return $this->db->insert($this->table, $scheduleData);
	}

	public function getGroupScheduleByCode($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where($this->pk3,$kode_kel);
		$query = $this->db->get();
		return $query;
	}

	public function getRoomSchedule($thn_ajaran = NULL, $smt = NULL, $ruang = NULL, $tgl = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where('ruang', $ruang);
		$this->db->where('tgl',$tgl);
		$query = $this->db->get();
		return $query;
	}

	public function getDopingSchedule($thn_ajaran = NULL, $smt = NULL, $npp = NULL, $tgl = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where('tgl',$tgl);
		$this->db->where("( moderator='". $npp ."' OR penguji1='". $npp ."' OR penguji2='". $npp ."'  )");
		$query = $this->db->get();
		return $query;
	}

	public function getScheduleList($thn_ajaran = NULL, $smt = NULL) {
		$query = $this->db->query("
			Select distinct tb_jadwal.thn_ajaran, tb_jadwal.smt, tb_jadwal.ruang, tb_jadwal.mulai, tb_jadwal.akhir, tb_jadwal.tgl, tb_jadwal.moderator
				from tb_jadwal inner join tb_dosen
					ON tb_dosen.npp = tb_jadwal.moderator
						OR tb_dosen.npp = tb_jadwal.penguji1
						OR tb_dosen.npp = tb_jadwal.penguji2

				where tb_jadwal.thn_ajaran = '". $thn_ajaran ."' AND tb_jadwal.smt = '". $smt ."'
				ORDER BY tb_jadwal.ruang
		");

		// $query = $this->db->query("
		// 	Select *
		// 		from tb_jadwal inner join tb_dosen
		// 			ON tb_dosen.npp = tb_jadwal.moderator
		// 				OR tb_dosen.npp = tb_jadwal.penguji1
		// 				OR tb_dosen.npp = tb_jadwal.penguji2
		// 		where tb_jadwal.thn_ajaran = '". $thn_ajaran ."' AND tb_jadwal.smt = '". $smt ."'

		// 		GROUP BY  tb_jadwal.thn_ajaran, tb_jadwal.smt, tb_jadwal.ruang, tb_jadwal.mulai, tb_jadwal.akhir, tb_jadwal.tgl, tb_jadwal.moderator
		// ");

		// $query = $this->db->query("
		// 	Select distinct thn_ajaran, smt, ruang, mulai, akhir
		// 		from tb_jadwal 
					
		// 		where thn_ajaran = '". $thn_ajaran ."' AND smt = '". $smt ."'
		// ");

		return $query;
	}

	public function getScheduleDosen($thn_ajaran = NULL ,$smt = NULL, $npp = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where("( moderator='". $npp ."' OR penguji1='". $npp ."' OR penguji2='". $npp ."'  )");
		$query = $this->db->get();
		return $query;
	}

	public function getJadwalByIdentitas($thn_ajaran = NULL ,$smt = NULL ,$ruang = NULL, $moderator = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where('ruang', $ruang);
		$this->db->where('moderator', $moderator);
		$this->db->where('tgl', $tgl);
		$this->db->where('mulai',$mulai);
		$this->db->where('akhir',$akhir);
		$query = $this->db->get();
		return $query;
	}

	public function getJadwalByIdentitasPar($thn_ajaran = NULL ,$smt = NULL ,$ruang = NULL, $tgl = NULL, $mulai = NULL, $akhir = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where('ruang', $ruang);
		$this->db->where('tgl', $tgl);
		$this->db->where('mulai',$mulai);
		$this->db->where('akhir',$akhir);
		$query = $this->db->get();
		return $query;
	}

	public function isSchedule($npp = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('moderator',$npp);
		$this->db->or_where('penguji1',$npp);
		$this->db->or_where('penguji2',$npp);
		$query = $this->db->get();
		return $query;
	}

	public function isScheduleGroup($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('thn_ajaran',$thn_ajaran);
		$this->db->where('smt',$smt);
		$this->db->where('kode_kel',$kode_kel);
		$query = $this->db->get();
		return $query;
	}

}

/* End of file M_jadwal.php */
/* Location: ./application/models/M_jadwal.php */

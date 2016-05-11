<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bimbingan extends CI_Model {

	private $table = 'tb_bimbingan';
	private $pk1 = 'thn_ajaran';
	private $pk2 = 'smt';
	private $pk3 = 'kode_kel';
	private $pk4 = 'nou';

	function __construct() {
		parent::__construct();
	}

	public function insert($guidanceData = null) {
		return $this->db->insert($this->table, $guidanceData);
	}

	public function delete($thn_ajaran = NULL, $smt = NULL, $kode_kel = null, $nou = NULL) {
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where($this->pk3,$kode_kel);
		$this->db->where($this->pk4,$nou);
		return $this->db->delete($this->table);
	}

	public function update($thn_ajaran = NULL, $smt = NULL, $kode_kel = null, $nou = NULL, $guidanceData = null) {
		$this->db->where($this->pk1,$thn_ajaran);
		$this->db->where($this->pk2,$smt);
		$this->db->where($this->pk3,$kode_kel);
		$this->db->where($this->pk4,$nou);
		return $this->db->update($this->table,$guidanceData);
	}

	public function getGuidanceByKodeKel($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pk1, $thn_ajaran);
		$this->db->where($this->pk2, $smt);
		$this->db->where($this->pk3, $kode_kel);
		$this->db->order_by($this->pk4, 'asc');
		$query = $this->db->get();
		return $query;
	}

	public function getGuidance($filterData = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($filterData);
		$query = $this->db->get();
		return $query;
	}


	

}

/* End of file M_bimbingan.php */
/* Location: ./application/models/M_bimbingan.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mhs extends CI_Model {

	private $table = 'tb_mhs';
	private $pktable = 'nbi';

	function __construct() {
		parent::__construct();
	}

	public function getMhsLogin($nbi = null, $pwd = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('nbi',$nbi);
		$this->db->where('pwd',$pwd);
		$query = $this->db->get();
		return $query;
	}

	public function getMhsByNbi($nbi = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable, $nbi);
		$query = $this->db->get();
		return $query;
	}

	public function getMhsActive() {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('akses',1);
		$query = $this->db->get();
		return $query;
	}

	public function update($old_nbi = null, $mhsData = null) {
		$this->db->where($this->pktable,$old_nbi);
		return $this->db->update($this->table,$mhsData);
	}

	public function insert($mhsData = null) {
		return $this->db->insert($this->table, $mhsData);
	}

	public function delete($nbi = null) {
		$this->db->where($this->pktable,$nbi);
		return $this->db->delete($this->table);
	}

	// autocomplete ketika invite member
	function getParticipantAutoCompleteInviteNBI($nbi = NULL) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_not_in('akses', 0); // Agar mhs yg akses 0 tdk ikut 
        $this->db->like($this->pktable, $nbi, 'both');
        return $this->db->get();
	}

	// autocomplete ketika add member di admin dengan nbi atau nama
	function getParticipantAutoCompleteInviteNbiNama($namanbi = NULL) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_not_in('akses', 0); // Agar mhs yg akses 0 tdk ikut 
        $this->db->like('nama', $namanbi, 'both');
        $this->db->or_like('nbi', $namanbi, 'both');
        return $this->db->get();
	}	

}

/* End of file M_mhs.php */
/* Location: ./application/models/M_mhs.php */
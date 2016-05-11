<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends CI_Model {

	private $table		= 'tb_setting';
	private $pktable1	= 'thn_ajaran';
	private $pktable2	= 'smt';

	function __construct() {
		parent::__construct();
	}

	public function getSetting() {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query;
	}

	public function getTahunAjaran() {
		$this->db->distinct();
		$this->db->select('thn_ajaran');
		$query = $this->db->get($this->table);
		return $query;
	}

	public function checkSetting($thn_ajaran = NULL, $smt = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$query = $this->db->get();
		return $query;
	}

	public function insert($createSetting = NULL) {
		return $this->db->insert($this->table, $createSetting);
	}

	public function update($thn_ajaran = NULL, $smt = NULL, $settingData = NULL) {
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where('status',1);
		return $this->db->update($this->table,$settingData);
	} 

}

/* End of file M_setting.php */
/* Location: ./application/models/M_setting.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_anggota extends CI_Model {

	private $table = 'tb_anggota';
	private $pktable1 = 'thn_ajaran';
	private $pktable2 = 'smt';
	private $pktable3 = 'kode_kel';
	private $pktable4 = 'nbi';
	private $column = array('tb_anggota.nbi');
	private $order = array('tb_anggota.nbi' => 'asc');

	function __construct() {
		parent::__construct();
	}

	/*Datatable data peserta di admin*/
	private function getDataTablesQuery($thn_ajaran = NULL , $smt = NULL) {

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');
		//$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');

		$this->db->where('tb_anggota.thn_ajaran',$thn_ajaran);
		$this->db->where('tb_anggota.smt',$smt);

        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        
 
        // if(isset($_POST['order']))
        // {
        //     // $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //     $this->db->order_by($this->table.'.kode_kel');
        // }
        // else if(isset($this->order))
        // {
        //     $order = $this->order;
        //     $this->db->order_by(key($order), $order[key($order)]);
        // }
        $this->db->order_by($this->table.'.kode_kel');
    }

	public function participantListsAdmin($thn_ajaran = NULL , $smt = NULL) {
		$this->getDataTablesQuery($thn_ajaran, $smt);
		if($_POST['length'] != -1)
        	$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
	}

	public function countAll(){
		return $this->db->count_all($this->table);
	}

	public function countFiltered($thn_ajaran = NULL , $smt = NULL){
		$this->getDataTablesQuery($thn_ajaran, $smt);
        $query = $this->db->get();
        return $query->num_rows();
	}
	/*Datatable data peserta di admin*/
	
	public function getAnggotaByNbi($nbi = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');
		$this->db->where($this->table.'.nbi',$nbi);
		$query = $this->db->get();
		return $query;
	}

	public function getAnggotaByPeriode($thn_ajaran = NULL , $smt = NULL, $nbi = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1, $thn_ajaran);
		$this->db->where($this->pktable2, $smt);
		$this->db->where($this->pktable4, $nbi);
		$query = $this->db->get();
		return $query;
	}

	public function getAnggotaByPeriodeJoinMhs($thn_ajaran = NULL , $smt = NULL, $nbi = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1, $thn_ajaran);
		$this->db->where($this->pktable2, $smt);
		$this->db->where($this->pktable4, $nbi);
		$query = $this->db->get();
		return $query;
	}


	public function getAnggotaPeriode($thn_ajaran = NULL , $smt = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');
		$this->db->where('tb_anggota.thn_ajaran', $thn_ajaran);
		$this->db->where('tb_anggota.smt', $smt);
		$query = $this->db->get();
		return $query;
	}

	public function insert($anggotaData = null) {
		return $this->db->insert($this->table, $anggotaData);
	}

	public function delete($thn_ajaran = null, $smt = null, $nbi = null) {
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable4,$nbi);
		return $this->db->delete($this->table);
	}

	public function update($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $nbi = NULL, $dataUpdate) {
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		$this->db->where($this->pktable4,$nbi);
		return $this->db->update($this->table,$dataUpdate);
	}

	public function countParticipant($thn_ajaran = NULL, $smt = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$query = $this->db->get();
		return $query;
	}

	public function getAnggotaByKodeKel($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		$query = $this->db->get();
		return $query;
	}

	public function getAnggota($filterData = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($filterData);
		$query = $this->db->get();
		return $query;

	}

	public function getAnggotaByKodeKelJoinMhs($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_mhs','tb_mhs.nbi = tb_anggota.nbi','inner');
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		$query = $this->db->get();
		return $query;
	}

	public function getAnggotaByKodeKelJoinMhsSort($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_mhs','tb_mhs.nbi = tb_anggota.nbi','inner');
		$this->db->where('tb_anggota.'.$this->pktable1,$thn_ajaran);
		$this->db->where('tb_anggota.'.$this->pktable2,$smt);
		$this->db->where('tb_anggota.'.$this->pktable3,$kode_kel);
		$this->db->order_by('tb_anggota.kode_kel','ASC');
		$query = $this->db->get();
		return $query;
	}
	

}

/* End of file M_anggota.php */
/* Location: ./application/models/M_anggota.php */
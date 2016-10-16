<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelompok extends CI_Model {

	private $table = 'tb_kelompok';
	private $pktable1   = 'thn_ajaran';
	private $pktable2   = 'smt';
	private $pktable3   = 'kode_kel';
	private $column = array('tb_kelompok.kode_kel');
	private $order = array('tb_kelompok.kode_kel' => 'asc');


	
	function __construct() {
		parent::__construct();
	}

	/*Datatable data kelompok di admin*/
	private function getDataTablesQuery($thn_ajaran = NULL , $smt = NULL) {

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('tb_dosen', 'tb_dosen.npp = tb_kelompok.npp','left');
		//$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');

		$this->db->where('tb_kelompok.thn_ajaran',$thn_ajaran);
		$this->db->where('tb_kelompok.smt',$smt);

        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }


        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	public function groupListsAdmin($thn_ajaran = NULL , $smt = NULL) {
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
	/*Datatable data kelompok di admin*/

	/*Datatable data kelompok di dosen*/
	private function getDataTablesQueryLecturer($thn_ajaran = NULL , $smt = NULL, $npp = NULL) {

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('tb_dosen', 'tb_dosen.npp = tb_kelompok.npp','left');
		//$this->db->join('tb_mhs',$this->table.'.nbi = tb_mhs.nbi','inner');

		$this->db->where('tb_kelompok.thn_ajaran',$thn_ajaran);
		$this->db->where('tb_kelompok.smt',$smt);
		$this->db->where('tb_kelompok.npp',$npp);

        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        
 
        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	public function groupListsLecturer($thn_ajaran = NULL , $smt = NULL, $npp = NULL) {
		$this->getDataTablesQueryLecturer($thn_ajaran, $smt, $npp);
		if($_POST['length'] != -1)
        	$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
	}

	public function countAllLecturer(){
		return $this->db->count_all($this->table);
	}

	public function countFilteredLecturer($thn_ajaran = NULL , $smt = NULL, $npp = NULL){
		$this->getDataTablesQueryLecturer($thn_ajaran, $smt, $npp);
        $query = $this->db->get();
        return $query->num_rows();
	}
	/*Datatable data kelompok di dosen*/

	/*Datatable data kelompok di peserta*/
	private function getDataTablesQueryParticipant($thn_ajaran = NULL , $smt = NULL) {

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('tb_dosen', 'tb_dosen.npp = tb_kelompok.npp','inner');

		$this->db->where('tb_kelompok.thn_ajaran',$thn_ajaran);
		$this->db->where('tb_kelompok.smt',$smt);

        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
        }

        
 
        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	public function groupListsParticipant($thn_ajaran = NULL , $smt = NULL) {
		$this->getDataTablesQueryParticipant($thn_ajaran, $smt);
		if($_POST['length'] != -1)
        	$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
	}

	public function countAllParticipant(){
		return $this->db->count_all($this->table);
	}

	public function countFilteredParticipant($thn_ajaran = NULL , $smt = NULL){
		$this->getDataTablesQueryParticipant($thn_ajaran, $smt);
        $query = $this->db->get();
        return $query->num_rows();
	}
	/*Datatable data kelompok di peserta*/

	public function insert($groupData = null) {
		return $this->db->insert($this->table, $groupData);
	}

	public function update($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL, $groupData = NULL) {
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		return $this->db->update($this->table,$groupData);
	}

	public function getGroupByCodeJoinLecturer($thn_ajaran = NULL, $smt = NULL, $kode_kel = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_dosen','tb_dosen.npp = tb_kelompok.npp','inner');
		$this->db->where('tb_kelompok.thn_ajaran',$thn_ajaran);
		$this->db->where('tb_kelompok.smt',$smt);
		$this->db->where('tb_kelompok.kode_kel',$kode_kel);
		$query = $this->db->get();
		return $query;
	}

	public function getAllGroup($thn_ajaran = NULL, $smt = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$query = $this->db->get();
		return $query;
	}

	public function getMaxCode($thn_ajaran = NULL, $smt = NULL) {
		$query = $this->db->query('SELECT MAX(CAST( MID(kode_kel,4) AS INT)) AS maxColumns FROM '. $this->table .' where thn_ajaran = '.$thn_ajaran. ' AND smt = '.$smt);
		
		return $query->result_object();
        // $this->db->select_max('kode_kel');
        // $this->db->where($this->pktable1, $thn_ajaran);
        // $this->db->where($this->pktable2, $smt);
        // $query = $this->db->get($this->table)->row();
        // return $query->kode_kel;

	}

	public function getActiveGroup($thn_ajaran = NULL, $smt = NULL, $kode_kel) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		$query = $this->db->get();
		return $query;
	}

	public function getActiveGroupNoDoping($thn_ajaran = NULL, $smt = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where('npp',NULL);
		$query = $this->db->get();
		return $query;
	}

	public function getActiveGroupWithDoping($thn_ajaran = NULL, $smt = NULL, $npp = NULL) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where('npp',$npp);
		$query = $this->db->get();
		return $query;
	}

	public function delete($thn_ajaran = null, $smt = null, $kode_kel = null) {
		$this->db->where($this->pktable1,$thn_ajaran);
		$this->db->where($this->pktable2,$smt);
		$this->db->where($this->pktable3,$kode_kel);
		return $this->db->delete($this->table);
	}

	// Untuk cek apakah dia sebagai pembimbing atau tidak
	public function isPembimbing($nidn = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('npp',$nidn);
		$query = $this->db->get();
		return $query;
	}
	// Untuk cek apakah dia sebagai pembimbing atau tidak

	public function getPembimbing($thn_ajaran = NULL, $smt = NULL) {
		$query = $this->db->query("
			Select distinct(tb_kelompok.npp), tb_dosen.nama from tb_kelompok
				inner join tb_dosen ON tb_dosen.npp = tb_kelompok.npp
				where tb_kelompok.thn_ajaran ='". $thn_ajaran ."' AND tb_kelompok.smt = '". $smt ."'  
		");

		return $query;
	}

}

/* End of file M_kelompok.php */
/* Location: ./application/models/M_kelompok.php */
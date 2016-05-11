<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dosen extends CI_Model 
{

	private $table = 'tb_dosen';
	private $pktable   = 'npp';
	private $column = array('npp','nama');
	private $order = array('npp' => 'asc');

	function __construct() {
		parent::__construct();
	}

	/*Datatable data dosen di admin*/
	private function getDataTablesQuery() {

		$this->db->select('*');
        $this->db->from($this->table);
        //$this->db->where_not_in('akses',2); // mendandakan dia admin
        
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

	public function lecturerListsAdmin() {
		$this->getDataTablesQuery();
		if($_POST['length'] != -1)
        	$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
	}

	public function countAll(){
		return $this->db->count_all($this->table);
	}

	public function countFiltered(){
		$this->getDataTablesQuery();
        $query = $this->db->get();
        return $query->num_rows();
	}
	/*Datatable data dosen di admin*/

	public function getDosenLogin($npp = null, $pwd = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('npp',$npp);
		$this->db->where('pwd',$pwd);
		$query = $this->db->get();
		return $query;
	}

	public function getDosenBynpp($npp = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable,$npp);
		$query = $this->db->get();
		return $query;
	}

	public function getDosenActive() {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('akses !=',0);
		$query = $this->db->get();
		return $query;
	}

	public function getDosenActiveBynpp($npp = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable,$npp);
		$this->db->where('akses !=',0);
		$query = $this->db->get();
		return $query;
	}

	public function update($npp = null, $lecturerData = null) {
		$this->db->where($this->pktable,$npp);
		return $this->db->update($this->table,$lecturerData);
	}

	public function insert($lecturerData = null) {
		return $this->db->insert($this->table, $lecturerData);
	}

	public function delete($npp = null) {
		$this->db->where($this->pktable,$npp);
		return $this->db->delete($this->table);
	}

	public function getLecturerAutoComplete($npp = null, $admin = null) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_not_in($this->pktable, $admin);
        $this->db->where_not_in('akses', 2); // Agar admin tidak bisa cari profil admin lainnya
        $this->db->like($this->pktable, $npp, 'both');
        return $this->db->get();
	}

	public function getLecturerAutoCompleteName($nama = null, $admin = null) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_not_in($this->pktable, $admin);
        $this->db->where_not_in('akses', 2); // Agar admin tidak bisa cari profil admin lainnya
        $this->db->like('nama', $nama, 'both');
        return $this->db->get();
	}

	public function getLecturerAutoCompleteGroup($nama = NULL) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_not_in('akses', 0); // Agar yang dipilih cuma dosen pembimbing saja
        $this->db->like('nama', $nama, 'both');
        return $this->db->get();
	}

}

/* End of file M_dosen.php */
/* Location: ./application/models/M_dosen.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengumuman extends CI_Model {

	private $table = 'tb_pengumuman';
	private $pktable   = 'id';
	private $column = array('judul');
	private $order = array('tgl' => 'desc');
	
	function __construct() {
		parent::__construct();
	}

	/*Data pengumuman di admin*/
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

	public function newsListsAdmin() {
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
	/*Data pengumuman di admin*/

	public function insert($newsData = null) {
		return $this->db->insert($this->table, $newsData);
	}

	public function update($id = null, $newsData = null) {
		$this->db->where($this->pktable,$id);
		return $this->db->update($this->table,$newsData);
	}

	public function delete($id = null) {
		$this->db->where($this->pktable,$id);
		return $this->db->delete($this->table);
	}

	public function getNewsById($id = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable,$id);
		$query = $this->db->get();
		return $query;
	}

	public function getNewsByIdandSlug($id = null, $slug = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->pktable,$id);
		$this->db->where('slug',$slug);
		$query = $this->db->get();
		return $query;
	}

	public function getNewestNews($dateNow = null) {
		$query = $this->db->query("
			SELECT * FROM tb_pengumuman WHERE id = 
			( 
				SELECT MAX(id) FROM
				(
					SELECT * FROM tb_pengumuman WHERE validasi = 1
						AND tgl <= '". $dateNow ."' 
						AND tgl_exp >= '". $dateNow ."' 
				) AS T
			) 
		");

		return $query;
	}

	// News pagination
	public function newsRecord($dateNow = null) {
		$this->db->where('validasi',1);
		$this->db->where('tgl_exp >=', $dateNow);
		return $this->db->count_all_results($this->table);
	}

	public function newsListsPublic($limit = null, $start = null, $dateNow = null) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('validasi',1);
		$this->db->where('tgl <=', $dateNow);
		$this->db->where('tgl_exp >=', $dateNow);
		$this->db->order_by('id','DESC');
		$this->db->order_by('tgl','DESC');
		$this->db->limit($limit,$start);
		return $this->db->get();
	} 
	// News pagination

}

/* End of file M_pengumuman.php */
/* Location: ./application/models/M_pengumuman.php */
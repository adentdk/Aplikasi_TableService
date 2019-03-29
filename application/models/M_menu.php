<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

	public function getMenu($where = null)
	{
		if (empty($where)) {
			$this->db->order_by('qty','asc');
			return $this->db->get('menu')->result_array();
		
		}elseif (!empty($where['id_menu'])){

			return $this->db->get_where('menu',$where)->row_array();
		
		}else{
		
			return $this->db->get_where('menu',$where)->result_array();

		}
	}

	public function add($data)
	{
		$this->db->insert('menu',$data);

		return $this->db->affected_rows();
	}

	public function update($id, $data)
	{
		$this->db->where('id_menu',$id);
		$this->db->update('menu',$data);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id_menu',$id);
		$this->db->delete('menu');

		return $this->db->affected_rows();
	}
	

}

/* End of file M_menu.php */
/* Location: ./application/models/M_menu.php */
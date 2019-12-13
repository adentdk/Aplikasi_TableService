<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public function getUserbyLevel($level)
	{
		$this->db->select('user.id_user, user.username, user.nama, level.nama_level as level');
		$this->db->from('user');
		$this->db->join('level','level.id_level = user.id_level');
		$this->db->where('level.nama_level',$level);
		$this->db->where('user.nama !=','default');
		$this->db->order_by('user.id_user', 'asc');

		return $this->db->get()->result_array();
	}

	public function getUserbyID($id)
	{
		$this->db->select('user.id_user, user.username, user.password, user.nama, user.id_level');
		$this->db->from('user');

		return $this->db->get_where('',['user.id_user' => $id])->row_array();
	}

	public function add($data)
	{
		$this->db->insert('user',$data);

		return $this->db->affected_rows();
	}

	public function update($id,$data)
	{
		$this->db->where('id_user',$id);
		$this->db->update('user',$data);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id_user',$id);
		$this->db->delete('user');

		return $this->db->affected_rows();
	}

}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */
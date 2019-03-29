<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {


	public function getDataUser($username)
	{
		$this->db->select('user.id_user, user.username, user.password, user.nama');
		$this->db->select('level.nama_level as level');
		$this->db->from('user');
		$this->db->join('level','level.id_level = user.id_level');

		return $this->db->get_where('',['username' => $username]);


	}


	public function getMeja($where = 0)
	{	
		return $this->db->get_where('meja',['status_meja' => $where])->result_array();
	}

	public function tambahPesanan($data)
	{
		$this->db->insert('pesanan',$data);
	}

	public function gantiMeja($no_meja,$status)
	{
		$this->db->where('no_meja',$no_meja);
		$this->db->update('meja',['status_meja' =>  $status]);
	}


}

/* End of file M_login.php */
/* Location: ./application/models/M_login.php */
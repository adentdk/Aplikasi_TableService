<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_meja extends CI_Model {

	public function getMeja($where = 0)
	{
		if (empty($where)) {
			$this->db->order_by('no_meja','asc');
			return $this->db->get('meja')->result_array();
		
		}elseif (!empty($where['no_meja'])){

			return $this->db->get_where('meja',$where)->row_array();
		
		}else{
		
			return $this->db->get_where('meja',$where)->result_array();

		}
	}

	public function add($data)
	{
		$this->db->insert('meja',$data);

		return $this->db->affected_rows();
	}

	public function update($no_meja, $status)
	{	

		if ($status == 'kosong') $status = 'penuh';
		elseif($status == 'penuh') $status = 'kosong';

		$this->db->where('no_meja',$no_meja);
		$this->db->update('meja',['status_meja' => $status]);

		return $this->db->affected_rows();
	}

	public function delete($no_meja)
	{
		$this->db->where('no_meja',$no_meja);
		$this->db->delete('meja');

		return $this->db->affected_rows();
	}

}

/* End of file M_meja.php */
/* Location: ./application/models/M_meja.php */
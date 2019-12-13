<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pesanan extends CI_Model {

	public function getPesanan($where = null)
	{
		if (empty($where)) {
			$this->db->order_by('waktu','desc');
			return $this->db->get('pesanan')->result_array();
		
		}elseif (!empty($where['id_pesanan'])){

			$this->db->select('*');
			$this->db->from('pesanan');
			$this->db->join('user','user.id_user = pesanan.id_user');
			$this->db->order_by('pesanan.waktu','desc');
			return $this->db->get_where('',$where)->row_array();
		
		}else{
			$this->db->order_by('waktu','desc');
			return $this->db->get_where('pesanan',$where)->result_array();

		}
	}

	public function getDetail($id_pesanan)
	{
		$this->db->select('detail_pesanan.id_detail_pesanan, detail_pesanan.qty, detail_pesanan.subtotal, detail_pesanan.keterangan');
		$this->db->select('menu.nama_menu, menu.harga');
		$this->db->from('detail_pesanan');
		$this->db->join('menu','menu.id_menu = detail_pesanan.id_menu');
		$this->db->where('id_pesanan',$id_pesanan);

		return $this->db->get()->result_array();
	}

	public function updatePesanan($id_pesanan,$data)
	{
		$this->db->update('pesanan',$data,['id_pesanan' => $id_pesanan]);
		
		return $this->db->affected_rows();
	}

}

/* End of file M_order.php */
/* Location: ./application/models/M_order.php */
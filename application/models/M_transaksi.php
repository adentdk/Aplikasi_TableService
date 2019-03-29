<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model {

	public function getTransaksi($where = null)
	{
		if (empty($where)) {
			$this->db->order_by('waktu','desc');
			return $this->db->get('transaksi')->result_array();
		
		}elseif (!empty($where['id_transaksi'])){

			$this->db->select('transaksi.id_transaksi, transaksi.total_bayar, transaksi.bayar, transaksi.kembalian, transaksi.waktu, transaksi.status_transaksi');
			$this->db->select('pesanan.id_pesanan, pesanan.no_meja');
			$this->db->select('user.nama');
			$this->db->from('transaksi');
			$this->db->join('pesanan','pesanan.id_pesanan = transaksi.id_pesanan');
			$this->db->join('user','user.id_user = transaksi.id_user');
			return $this->db->get_where('',$where)->row_array();
		
		}else{
			
			$this->db->select('transaksi.id_transaksi, transaksi.waktu, transaksi.status_transaksi , pesanan.id_pesanan, pesanan.no_meja');
			$this->db->from('transaksi');
			$this->db->join('pesanan','pesanan.id_pesanan = transaksi.id_pesanan');
			$this->db->order_by('transaksi.waktu','desc');
			return $this->db->get_where('',$where)->result_array();

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

	public function getTotalBayar($id_pesanan)
	{
		$this->db->select('SUM(subtotal) as total')->from('detail_pesanan');
		$this->db->where('id_pesanan',$id_pesanan);

		return $this->db->get()->row_array();
	}

	public function updateTransaksi($id,$data)
	{
		$this->db->where('id_transaksi',$id);
		$this->db->update('transaksi',$data);
		return $this->db->affected_rows();
	}	

	public function reportTransaksi()
	{
		$this->db->select('waktu, SUM(total_bayar) as pemasukan');
		$this->db->from('transaksi');
		$this->db->order_by('waktu','desc');
		$this->db->group_by('waktu');

		return $this->db->get()->result_array();
	}

}

/* End of file M_transaksi.php */
/* Location: ./application/models/M_transaksi.php */
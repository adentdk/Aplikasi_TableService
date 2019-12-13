<?php

class M_pelanggan extends CI_Model {

    public function getMenu($where = null)
    {
        if (!empty($where['id_menu'])) {
            return $this->db->get_where('menu',$where)->row_array();
        }else{
            return $this->db->get_where('menu',$where)->result_array();
        }
    }
    public function getMenuAcak($where = null)
    {
        $this->db->limit(3);
        $this->db->order_by('RAND()');
        return $this->db->get_where('menu',$where)->result_array();
    }

    public function tambahPesanan($data){
        $this->db->insert('detail_pesanan',$data);

        return $this->db->affected_rows();
    }

    public function updateMenu($id,$data){
        $this->db->where('id_menu',$id);
        $this->db->update('menu',$data);
    }

    public function getPesanan($id_pesanan)
    {
        $this->db->select('pesanan.id_pesanan, pesanan.no_meja, pesanan.keterangan, pesanan.status_pesanan');
        $this->db->select('user.nama');
        $this->db->from('pesanan');
        $this->db->join('user','user.id_user = pesanan.id_user');
        return $this->db->get_where('',['id_pesanan' => $id_pesanan])->row_array();
    }

    public function hapusPesanan($id)
    {
        $this->db->where('id_detail_pesanan',$id);
        $this->db->delete('detail_pesanan');

        return $this->db->affected_rows();
    }

    public function updatePesanan($id,$data)
    {
        $this->db->where('id_pesanan',$id);
        $this->db->update('pesanan',$data);

        return $this->db->affected_rows();
    }

    public function getDetailPesanan($id_pesanan)
    {
        $this->db->select('detail_pesanan.id_detail_pesanan, detail_pesanan.subtotal, detail_pesanan.keterangan, detail_pesanan.qty');
        $this->db->select('menu.id_menu, menu.nama_menu, menu.harga');
        $this->db->from('detail_pesanan');
        $this->db->join('menu','menu.id_menu = detail_pesanan.id_menu');
        $this->db->where('detail_pesanan.id_pesanan',$id_pesanan);

        return $this->db->get()->result_array();
    }

    public function tambahTransaksi($data)
    {
        $this->db->insert('transaksi',$data);
    }
}
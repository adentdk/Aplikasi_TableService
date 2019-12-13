<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	private $level;

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('transaksi_akses')){
			$this->session->set_flashdata('msg','Akses ditolak');
			redirect('login/petugas','refresh');
		}

		if($this->session->userdata('administrator')) $this->level = 'administrator';
		elseif($this->session->userdata('kasir')) $this->level = 'kasir';

		$this->load->model('M_transaksi','tks');

	}

	public function getDataTransaksi()
	{
		echo json_encode($this->tks->getTransaksi(['id_transaksi' => $this->input->post('id_transaksi')]));
	}

	public function detailPesanan()
	{
		$data['detail'] = $this->tks->getDetail($this->input->post('id_pesanan'));
		$this->load->view('_pattern/detailPesanan',$data);
	}

	public function bayar()
	{
		$data = $this->input->post();
		$data['status_transaksi'] = 'sudah bayar';
		$data['waktu'] = date('Y-m-d H:i:s');
		$id_transaksi = $data['id_transaksi'];

		$result = $this->tks->updateTransaksi($id_transaksi,$data);
		if ($result > 0) {
			$this->session->set_flashdata('msg','Berhasil');
			redirect($this->level.'/kelola_transaksi','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal');
			redirect($this->level.'/kelola_transaksi','refresh');
		}
	}
}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */

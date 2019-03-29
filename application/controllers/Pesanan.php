<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

	private $level;

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('pesanan_akses')){
			$this->session->set_flashdata('msg','Akses ditolak');
			redirect('login/petugas','refresh');
		}

		if($this->session->userdata('administrator')) $this->level = 'administrator';
		elseif($this->session->userdata('pelayan')) $this->level = 'pelayan';

		$this->load->model('M_pesanan','psn');

	}

	// List all your items
	public function getpesanan()
	{
		if ($this->input->post('id_pesanan')) {
			echo json_encode($this->psn->getPesanan(['id_pesanan' => $this->input->post('id_pesanan')]));
		}
	}

	public function detailPesanan()
	{
		$data['detail'] = $this->psn->getDetail($this->input->post('id_pesanan'));
		$this->load->view('_pattern/detailPesanan',$data);
	}

	public function ambilPesanan()
	{
		$id_pesanan = $this->uri->segment(3);

		$result = $this->psn->updatePesanan($id_pesanan,['status_pesanan' => 'diantrikan']);
		if ($result > 0) {
			$this->session->set_flashdata('msg','Berhasil');
			redirect($this->level.'/kelola_pesanan','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal');
			redirect($this->level.'/kelola_pesanan','refresh');
		}
	}

	public function hantarPesanan()
	{
		$id_pesanan = $this->uri->segment(3);

		$result = $this->psn->updatePesanan($id_pesanan,['status_pesanan' => 'disajikan']);
		if ($result > 0) {
			$this->session->set_flashdata('msg','Berhasil');
			redirect($this->level.'/kelola_pesanan','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal');
			redirect($this->level.'/kelola_pesanan','refresh');
		}
	}

	// Add a new item
	public function add()
	{

	}

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file Pesanan.php */
/* Location: ./application/controllers/Pesanan.php */

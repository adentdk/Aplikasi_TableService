<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	private $id_user;
	private $username;
	private $nama;
	private $id_pesanan;
	private $no_meja;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('pelanggan')) {
			$this->session->set_flashdata('msg','Login terlebih dahulu');
			redirect('login/pelanggan','refresh');
		}

		$this->id_user = $this->session->userdata('id_user');
		$this->username = $this->session->userdata('username');
		$this->nama = $this->session->userdata('nama');
		$this->id_pesanan = $this->session->userdata('id_pesanan');
		$this->no_meja = $this->session->userdata('no_meja');

		$this->load->model('M_pelanggan','plg');
	}
	
	public function index()
	{
		$judul['judul'] = 'Resto Run';
		$data['nama'] = $this->nama;
		$ajax['ajax'] = 'ajaxPelanggan';

		$content['acak'] = $this->plg->getMenuAcak(['qty >' => 1]);
		$content['menu'] = $this->plg->getMenu(['qty >' => 1]);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelanggan/_navbar',$data);
		$this->load->view('pelanggan/home',$content);
		$this->load->view('pelanggan/_footer');
		$this->load->view('_pattern/modalPelanggan');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function pesan()
	{
		$data = $this->input->post();
		$data['id_pesanan'] = $this->id_pesanan;

		$result = $this->plg->tambahPesanan($data);

		if($result > 0){
			$this->plg->updateMenu($data['id_menu'],['qty' => $this->plg->getMenu(['id_menu' => $data['id_menu'] ] )['qty'] - $data['qty']]);
			$this->session->set_flashdata('msg','Berhasil Ditambah');
			redirect('pelanggan/pesanan','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Ditambah');
			redirect('pelanggan','refresh');
		}
	}

	public function pesanan()
	{
		$judul['judul'] = 'Resto Run';
		$data['nama'] = $this->nama;
		$ajax['ajax'] = 'ajaxPelanggan';

		$content['pesanan'] = $this->plg->getPesanan($this->id_pesanan);
		$content['detail'] = $this->plg->getDetailPesanan($this->id_pesanan);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelanggan/_navbar',$data);
		$this->load->view('pelanggan/pesanan',$content);
		$this->load->view('pelanggan/_footer');
		$this->load->view('_pattern/modalPelanggan');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function hapusPesanan($id_pesanan,$id_menu,$qty)
	{
		$result = $this->plg->hapusPesanan($id_pesanan);

		if($result > 0){
			$this->plg->updateMenu($id_menu,['qty' => $this->plg->getMenu(['id_menu' => $id_menu])['qty'] + $qty]);
			$this->session->set_flashdata('msg','Berhasil Dihapus');
			redirect('pelanggan/pesanan','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Dihapus');
			redirect('pelanggan/pesanan','refresh');
		}
	}

	public function kirim()
	{
		if ($this->input->post()) {
			$data = [
						'keterangan' => $this->input->post('keterangan'),
						'status_pesanan' => 'terkirim'
					];

			$result = $this->plg->updatePesanan($this->id_pesanan, $data);

			if($result > 0){
				$this->session->set_flashdata('msg','Berhasil Dikirim');
				redirect('pelanggan/pesanan','refresh');
			}else{
				$this->session->set_flashdata('msg','Gagal Dikirm');
				redirect('pelanggan/pesanan','refresh');
			}
		}else{
			echo "<h1>404 NOT FOUND</h1>";
		}
	}

	public function selesai()
	{
		if ($this->input->post()) {
			
			$result = $this->plg->updatePesanan($this->id_pesanan, ['status_pesanan' => 'selesai']);

			if($result > 0){

				$data = $this->input->post();
				$data['id_pesanan'] = $this->id_pesanan;
				$data['id_user'] = $this->id_user;

				$this->plg->tambahTransaksi($data);
				$this->session->set_flashdata('msg','Berhasil Logout');
				redirect('login/logout','refresh');
			}else{
				$this->session->set_flashdata('msg','Gagal Dikirm');
				redirect('pelanggan/pesanan','refresh');
			}
		}else{
			echo "<h1>404 NOT FOUND</h1>";
		}
	}

	public function getDetailMenu()
	{
		echo json_encode($this->plg->getMenu(['id_menu' => $this->input->post('id_menu')]));
	}
}

/* End of file Pelanggan.php */
/* Location: ./application/controllers/Pelanggan.php */

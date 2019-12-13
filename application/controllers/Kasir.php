<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {

	private $id_user;
	private $username;
	private $nama;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('kasir')) {
			$this->session->set_flashdata('msg','akses ditolak');
			redirect('login/petugas','refresh');
		}

		$this->id_user = $this->session->userdata('id_user');
		$this->username = $this->session->userdata('username');
		$this->nama = $this->session->userdata('nama');

	}

	public function index()
	{
		$judul['judul'] = 'Resto Run || kasir';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('kasir/_menu',$data);
		$this->load->view('kasir/home');
		$this->load->view('_pattern/bawah');
	}

	public function kelola_user(){
		$judul['judul'] = 'Resto Run || kasir';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxUser';

		$this->load->model('M_user');

		$content['pelanggan'] = $this->M_user->getUserbyLevel('pelanggan');

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('kasir/_menu',$data);
		$this->load->view('kasir/kelola_user',$content);
		$this->load->view('_pattern/modalUser');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_meja()
	{
		$judul['judul'] = 'Resto Run || kasir';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxMeja';

		$this->load->model('M_meja');

		$content['meja'] = $this->M_meja->getmeja();

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('kasir/_menu',$data);
		$this->load->view('kasir/kelola_meja',$content);
		$this->load->view('_pattern/modalMeja');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_transaksi()
	{
		$judul['judul'] = 'Resto Run || kasir';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxTransaksi';

		$this->load->model('M_transaksi');

		$content['transaksi'] = $this->M_transaksi->getTransaksi(['status_transaksi' => 'sudah bayar']);
		$content['transaksiBaru'] = $this->M_transaksi->getTransaksi(['status_transaksi' => 'belum bayar']);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('kasir/_menu',$data);
		$this->load->view('kasir/data_transaksi',$content);
		$this->load->view('_pattern/modalTransaksi');
		$this->load->view('_pattern/modalCetak');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}
}

/* End of file Kasir.php */
/* Location: ./application/controllers/Kasir.php */

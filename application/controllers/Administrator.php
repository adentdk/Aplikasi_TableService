<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	private $id_user;
	private $username;
	private $nama;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('administrator')) {
			$this->session->set_flashdata('msg','akses ditolak');
			redirect('login/petugas','refresh');
		}

		$this->id_user = $this->session->userdata('id_user');
		$this->username = $this->session->userdata('username');
		$this->nama = $this->session->userdata('nama');

	}

	public function index()
	{
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/home');
		$this->load->view('_pattern/bawah');
	}

	public function kelola_user(){
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxUser';

		$this->load->model('M_user');

		$content['administrator'] = $this->M_user->getUserbyLevel('administrator');
		$content['pelayan'] = $this->M_user->getUserbyLevel('pelayan');
		$content['kasir'] = $this->M_user->getUserbyLevel('kasir');
		$content['pemilik'] = $this->M_user->getUserbyLevel('pemilik');
		$content['pelanggan'] = $this->M_user->getUserbyLevel('pelanggan');

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/kelola_user',$content);
		$this->load->view('_pattern/modalCetak');
		$this->load->view('_pattern/modalUser');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_meja()
	{
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxMeja';

		$this->load->model('M_meja');

		$content['meja'] = $this->M_meja->getmeja();

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/kelola_meja',$content);
		$this->load->view('_pattern/modalMeja');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_menu()
	{
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxMenu';

		$this->load->model('M_menu');

		$content['menu'] = $this->M_menu->getmenu();

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/kelola_menu',$content);
		$this->load->view('_pattern/modalMenu');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_pesanan()
	{
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxPesanan';

		$this->load->model('M_pesanan');

		$content['pesanan'] = $this->M_pesanan->getPesanan();

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/data_order',$content);
		$this->load->view('_pattern/modalPesanan');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_transaksi()
	{
		$judul['judul'] = 'Resto Run || administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxTransaksi';

		$this->load->model('M_transaksi');

		$content['transaksi'] = $this->M_transaksi->getTransaksi(['status_transaksi' => 'sudah bayar']);
		$content['transaksiBaru'] = $this->M_transaksi->getTransaksi(['status_transaksi' => 'belum bayar']);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/data_transaksi',$content);
		$this->load->view('_pattern/modalTransaksi');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function report()
	{
		$judul['judul'] = 'Resto Run || Administrator';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajax';

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/report');
		$this->load->view('_pattern/modalCetak');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function profile()
	{
		$judul['judul'] = 'Resto Run || '.$this->username;
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajax';

		$this->load->model('M_user');

		$content['profile'] = $this->M_user->getUserbyId($this->id_user);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('administrator/_menu',$data);
		$this->load->view('administrator/profile',$content);
		$this->load->view('_pattern/bawah',$ajax);
	}
	
}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */

<?php 


class Pelayan Extends CI_Controller
{
	private $id_user;
	private $username;
	private $nama;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('pelayan')) {
			$this->session->set_flashdata('msg','akses ditolak');
			redirect('login/petugas','refresh');
		}

		$this->id_user = $this->session->userdata('id_user');
		$this->username = $this->session->userdata('username');
		$this->nama = $this->session->userdata('nama');
	}

	public function index()
	{
		$judul['judul'] = 'Resto Run || Pelayan';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelayan/_menu',$data);
		$this->load->view('pelayan/home');
		$this->load->view('_pattern/bawah');
	}

	public function kelola_user(){
		$judul['judul'] = 'Resto Run || pelayan';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxUser';

		$this->load->model('M_user');

		$content['pelanggan'] = $this->M_user->getUserbyLevel('pelanggan');

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelayan/_menu',$data);
		$this->load->view('pelayan/kelola_user',$content);
		$this->load->view('_pattern/modalUser');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_meja()
	{
		$judul['judul'] = 'Resto Run || pelayan';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxMeja';

		$this->load->model('M_meja');

		$content['meja'] = $this->M_meja->getmeja();

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelayan/_menu',$data);
		$this->load->view('pelayan/kelola_meja',$content);
		$this->load->view('_pattern/modalMeja');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}

	public function kelola_pesanan()
	{
		$judul['judul'] = 'Resto Run || pelayan';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajaxPesanan';

		$this->load->model('M_pesanan');

		$content['pesanan'] = $this->M_pesanan->getPesanan("status_pesanan = 'diantrikan' or status_pesanan = 'disajikan' or status_pesanan = 'selesai' ");
		$content['pesananBaru'] = $this->M_pesanan->getPesanan(['status_pesanan' => 'terkirim']);

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pelayan/_menu',$data);
		$this->load->view('pelayan/data_pesanan',$content);
		$this->load->view('_pattern/modalPesanan');
		$this->load->view('_pattern/modalCetak');
		$this->load->view('_pattern/modalHapusdanAlert');
		$this->load->view('_pattern/bawah',$ajax);
	}
}
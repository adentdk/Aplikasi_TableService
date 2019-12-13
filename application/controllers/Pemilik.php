<?php

defined('BASEPATH') or exit('no script');

class Pemilik extends CI_Controller
{
	private $id_user;
	private $username;
	private $nama;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('pemilik')) {
			$this->session->set_flashdata('msg','akses ditolak');
			redirect('login/petugas','refresh');
		}

		$this->id_user = $this->session->userdata('id_user');
		$this->username = $this->session->userdata('username');
		$this->nama = $this->session->userdata('nama');

	}

	public function index()
	{
		$judul['judul'] = 'Resto Run || Pemilik';
		$data['nama'] = $this->nama;
		$data['username'] = $this->username;
		$ajax['ajax'] = 'ajax';

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('pemilik/_menu',$data);
		$this->load->view('pemilik/report');
		$this->load->view('_pattern/modalCetak');
		$this->load->view('_pattern/bawah',$ajax);
	}
}
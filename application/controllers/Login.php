<?php 

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login','login');
	}

	private function get_angka(){
		return random_int(200, 9999).random_int(1, 9999);
	}

	public function index()
	{
		redirect('login/pelanggan');
	}

	public function pelanggan()
	{
		$judul['judul'] = 'Login Pelanggan';

		$data['meja'] = $this->login->getMeja('kosong');

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('login/pelanggan',$data);
		$this->load->view('_pattern/bawah');

	}

	public function petugas()
	{
		$judul['judul'] = 'Login Petugas';

		$this->load->view('_pattern/atas',$judul);
		$this->load->view('login/petugas');
		$this->load->view('_pattern/bawah');
	}

	public function proses()
	{
		$page = $this->uri->segment(3);
		
		$post = $this->input->post();

		if(empty($post['username'])){
			$this->session->set_flashdata('msg','Username kosong');
			redirect('login/'.$page,'refresh');
		}
		$username = $post['username'];

		$cekusername = $this->login->getDataUser($username);

		if ($cekusername->num_rows() == 1) {
			$data = $cekusername->row_array();

			if (password_verify($post['password'],$data['password'])) {

				if ($data['level'] == 'administrator') {

					$userdata = [	
									'administrator' => 1,
									'id_user' => $data['id_user'],
									'username' => $data['username'],
									'nama' => $data['nama'],
									'user_akses' => 1,
									'meja_akses' => 1,
									'menu_akses' => 1,
									'pesanan_akses' => 1,
									'transaksi_akses' => 1,
									'report_akses' => 1
								];

					$this->session->set_userdata($userdata);
					redirect('administrator','refresh');

				}elseif ($data['level'] == 'pelayan') {

					$userdata = [
									'pelayan' => 1,
									'id_user' => $data['id_user'],
									'username' => $data['username'],
									'nama' => $data['nama'],
									'user_akses' => 1,
									'meja_akses' => 1,
									'pesanan_akses' => 1,
									'report_akses' => 1
								];

					$this->session->set_userdata($userdata);
					redirect('pelayan','refresh');

				}elseif ($data['level'] == 'kasir') {

					$userdata = [
									'kasir' => 1,
									'id_user' => $data['id_user'],
									'username' => $data['username'],
									'nama' => $data['nama'],
									'user_akses' => 1,
									'meja_akses' => 1,
									'transaksi_akses' => 1,
									'report_akses' => 1
								];

					$this->session->set_userdata($userdata);
					redirect('kasir','refresh');

				}elseif ($data['level'] == 'pemilik') {

					$userdata = [
									'pemilik' => 1,
									'id_user' => $data['id_user'],
									'username' => $data['username'],
									'nama' => $data['nama'],
									'report_akses' => 1
								];
					$this->session->set_userdata($userdata);
					redirect('pemilik','refresh');
				}elseif ($data['level'] == 'pelanggan') {
					$id_pesanan = 'P'.random_int(100, 900).random_int(500, 900);
					$pesanan = [
								'id_pesanan' => $id_pesanan,
								'waktu' => date('Y-m-d H:i:s'),
								'id_user' => $data['id_user'],
								'no_meja' => $post['no_meja']

							 ];

					$this->login->tambahPesanan($pesanan);
					$this->login->gantiMeja($post['no_meja'],'penuh');

					$userdata = [
									'pelanggan' => 1,
									'id_user' => $data['id_user'],
									'username' => $data['username'],
									'nama' => $data['nama'],
									'id_pesanan' => $id_pesanan,
									'no_meja' => $post['no_meja']
								];
					$this->session->set_userdata($userdata);
					redirect('pelanggan','refresh');
				}else{
					$this->session->set_flashdata('msg','Silahkan login kembali');
					redirect('login/'.$page,'refresh');	
				}



			}else{
				$this->session->set_flashdata('msg','Password salah');
				redirect('login/'.$page,'refresh');
			}
		}else{
			$this->session->set_flashdata('msg','Username tidak ditemukan');
			redirect('login/'.$page,'refresh');
		}
			
	}

	public function logout()
	{

		if ($this->session->userdata('pelanggan')) {
			$this->login->gantiMeja($this->session->userdata('no_meja'),'kosong');
			$this->session->sess_destroy();
			redirect('login/pelanggan','refresh');
		}
		$this->session->sess_destroy();
		redirect('login/petugas','refresh');
	}
}


/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
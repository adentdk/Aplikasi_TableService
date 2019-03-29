<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	private $level;

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('user_akses')){
			$this->session->set_flashdata('msg','Akses ditolak');
			redirect('login/petugas','refresh');
		}

		if($this->session->userdata('administrator')) $this->level = 'administrator';
		elseif($this->session->userdata('pelayan')) $this->level = 'pelayan';
		elseif($this->session->userdata('kasir')) $this->level = 'kasir';

		$this->load->model('M_user','usr');

	}

	// Add a new item
	public function add()
	{
		$data = $this->input->post();
		$data['foto'] = 'default.jpg';
		$data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

		unset($data['password_hidden']);
		unset($data['password_lama']);
		unset($data['password_baru']);
		unset($data['password_baru2']);


		$result = $this->usr->add($data);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Ditambah');
			redirect($this->level.'/kelola_user','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Ditambah');
			redirect($this->level.'/kelola_user','refresh');
		}
	}

	//Update one item
	public function update()
	{
		$data = $this->input->post();
		$data['foto'] = 'default.jpg';
		unset($data['password']);

		if ($this->input->post('ganti_password')) {
			
			if(password_verify($data['password_lama'],$data['password_hidden'])){

				if ($data['password_baru'] == $data['password_baru2']) {
					$data['password'] = password_hash($data['password_baru'],PASSWORD_DEFAULT);
				}else{	
					$this->session->set_flashdata('msg','Password baru tidak valid');
					redirect($this->level.'/kelola_user','refresh');
					exit();
				}

			}else{
				$this->session->set_flashdata('msg','Password lama salah');
				redirect($this->level.'/kelola_user','refresh');
				exit();
			}
		}

		unset($data['password_lama']);
		unset($data['password_baru']);
		unset($data['password_baru2']);
		unset($data['password_hidden']);
		unset($data['ganti_password']);

		$id_user = $data['id_user'];

		$result = $this->usr->update($id_user, $data);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Diedit');
			redirect($this->level.'/kelola_user','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Diedit');
			redirect($this->level.'/kelola_user','refresh');
		}
	}

	//Delete one item
	public function delete($id = 0)
	{
		if ($id == 0) {
			echo '<h1>NOT FOUND</h1>';
		}else{
			$result = $this->usr->delete($id);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Dihapus');
			redirect($this->level.'/kelola_user','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Dihapus');
			redirect($this->level.'/kelola_user','refresh');
		}
		}
	}

	public function getUser()
	{
		echo json_encode($this->usr->getUserbyID($this->input->post('id_user')));
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */

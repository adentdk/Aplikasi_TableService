<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meja extends CI_Controller {

	private $level;

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('meja_akses')){
			$this->session->set_flashdata('msg','Akses ditolak');
			redirect('login/petugas','refresh');
		}

		if($this->session->userdata('administrator')) $this->level = 'administrator';
		elseif($this->session->userdata('pelayan')) $this->level = 'pelayan';
		elseif($this->session->userdata('kasir')) $this->level = 'kasir';

		$this->load->model('M_meja','mj');

	}

	// Add a new item
	public function add()
	{
		$data = [
					'no_meja' => $this->input->post('no_meja')
				];

		$result = $this->mj->add($data);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Ditambah');
			redirect($this->level.'/kelola_meja','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Ditambah');
			redirect($this->level.'/kelola_meja','refresh');
		}
	}

	//Update one item
	public function update($no_meja = '', $status= '')
	{	

		if (!$no_meja|| !$status) {
			echo '<h1>ERROR 404 NOT FOUND</h1>';
			die();
		}

		$result = $this->mj->update($no_meja,$status);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Diganti');
			redirect($this->level.'/kelola_meja','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Diganti');
			redirect($this->level.'/kelola_meja','refresh');
		}
	}

	//Delete one item
	public function delete($no_meja = '')
	{

		if (!$no_meja) {
			echo '<h1>ERROR 404 NOT FOUND</h1>';
			die();
		}

		$result = $this->mj->delete($no_meja);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Dihapus');
			redirect($this->level.'/kelola_meja','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Dihapus');
			redirect($this->level.'/kelola_meja','refresh');
		}
	}
}

/* End of file Meja.php */
/* Location: ./application/controllers/Meja.php */

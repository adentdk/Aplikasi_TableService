<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	private $level;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('meja_akses')){
			$this->session->set_flashdata('msg','Akses ditolak');
			redirect('login/petugas','refresh');
		}

		if($this->session->userdata('administrator')) $this->level = 'administrator';
		elseif($this->session->userdata('pelanggan')) $this->level = 'pelanggan';

		$this->load->model('M_menu','mn');

	}

	private function _uploadFotoMenu()
	{
		$config = [
					'allowed_types' => 'jpg|png|jpeg',
					'upload_path' => './gambar/menu/'
				  ];

		// $this->load->library('upload',$config);

		// if ($this->upload->do_upload('foto_menu')) {
		// 	return $this->upload->data('file_name');
		// }else{
		// 	return 'default.jpg';
		// }	
			  
		$this->load->library('upload',$config);

		if ($this->upload->do_upload('foto')) {
			return $this->upload->data('file_name');
		}else{
			return 'default.jpg';
		}

	}
	public function getMenu()
	{
		echo json_encode($this->mn->getMenu($this->input->post()));
	}

	// Add a new item
	public function add()
	{
		$data = $this->input->post();

		$data['foto'] = $this->_uploadFotoMenu();

		unset($data['id_menu']);

		$result = $this->mn->add($data);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Ditambah');
			redirect($this->level.'/kelola_menu','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Ditambah');
			redirect($this->level.'/kelola_menu','refresh');
		}
	}

	//Update one item
	public function update( $id = NULL )
	{
		$data = $this->input->post();
		$id_menu = $data['id_menu'];
		
		
		$result = $this->mn->update($id_menu,$data);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Diedit');
			redirect($this->level.'/kelola_menu','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Diedit');
			redirect($this->level.'/kelola_menu','refresh');
		}
	}

	//Delete one item
	public function delete( $id = NULL )
	{
		$result = $this->mn->delete($id);

		if($result > 0){
			$this->session->set_flashdata('msg','Berhasil Dihapus');
			redirect($this->level.'/kelola_menu','refresh');
		}else{
			$this->session->set_flashdata('msg','Gagal Dihapus');
			redirect($this->level.'/kelola_menu','refresh');
		}
	}
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */

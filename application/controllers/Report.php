<?php

class Report extends CI_Controller
{
	public $pdf;

	public function __construct()
	{
		parent::__construct();
		 $this->load->library('pdf');

		if (!$this->session->userdata('report_akses')) {
			$this->session->set_flashdata('msg','akses ditolak');
			redirect('login/','refresh');
		}
	}

	private function _headerBuktiPemayaran()
	{
		$this->pdf->Image(base_url('gambar/restorun/logo.png'),10,8,20);

		$this->pdf->Cell(25);
		$this->pdf->SetFont('Arial','B',12);
		$this->pdf->Cell(35,7,'Restorun',0,1,'C');

		$this->pdf->Cell(25);
		$this->pdf->SetFont('Arial','',7);
		$this->pdf->Cell(35,2,'Jalan Jalan Saja',0,1,'C');

		$this->pdf->Cell(25);
		$this->pdf->SetFont('Arial','B',5);
		$this->pdf->Cell(35,2,'Telp. 021-221-789-29',0,1,'C');
		
		$this->pdf->Cell(1,3,'',0,1);
		$this->pdf->Cell(80,1,'','B',1,'L');
    	$this->pdf->Cell(80,1,'','B',1,'L');

    	$this->pdf->Ln(5);
	}

	private function _header()
	{
		$this->pdf->Image(base_url('gambar/restorun/logo.png'),10,8,30);

		$this->pdf->Cell(35);
		$this->pdf->SetFont('Arial','B',16);
		$this->pdf->Cell(120,10,'Restorun',0,1,'C');

		$this->pdf->Cell(35);
		$this->pdf->SetFont('Arial','',9);
		$this->pdf->Cell(120,5,'Jalan Jalan Saja',0,1,'C');

		$this->pdf->Cell(35);
		$this->pdf->SetFont('Arial','B',7);
		$this->pdf->Cell(120,5,'Telp. 021-221-789-29',0,1,'C');
		
		$this->pdf->Cell(1,3,'',0,1);
		$this->pdf->Cell(190,1,'','B',1,'L');
    	$this->pdf->Cell(190,1,'','B',1,'L');

    	$this->pdf->Ln(5);
	}

	private function _footer()
	{
	    // Posisi 15 cm dari bawah
	    $this->pdf->SetY(-31);
	    
	    // Arial italic 8
	    $this->pdf->SetFont('Arial','I',8);
	    
	    // Page number
	    $this->pdf->Cell(0,10,'Page '.$this->pdf->PageNo().'/{nb}',0,0,'C');
	}

	public function pegawai()
	{
		$this->load->model('M_user');

		$kasir = $this->M_user->getUserbyLevel('kasir');
		$pelayan = $this->M_user->getUserbyLevel('pelayan');

		$this->pdf = new FPDF('p','mm','A4');

		$this->pdf->AliasNbPages();

		// membuat halaman baru
		$this->pdf->AddPage();

		// load Header
		$this->_header();

		// content
		$this->pdf->SetFont('Arial','B',16);
		$this->pdf->Cell(190,8,'Data Pegawai',0,1,'C');


		$this->pdf->Cell(190,1,'',0,1);

		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(10,10,'No.',1,0,'C');
		$this->pdf->Cell(60,10,'Nama Pegawai',1,0,'C');
		$this->pdf->Cell(60,10,'Username',1,0,'C');
		$this->pdf->Cell(60,10,'Jabatan',1,1,'C');

		$this->pdf->SetFont('Arial','',11);
		$no = 1;
		foreach($pelayan as $pegawai){
			$this->pdf->Cell(10,10,$no++,1,0,'C');
			$this->pdf->Cell(60,10,$pegawai['nama'],1,0);
			$this->pdf->Cell(60,10,$pegawai['username'],1,0);
			$this->pdf->Cell(60,10,$pegawai['level'],1,1);
		}
		foreach($kasir as $pegawai){
			$this->pdf->Cell(10,10,$no++,1,0);
			$this->pdf->Cell(60,10,$pegawai['nama'],1,0);
			$this->pdf->Cell(60,10,$pegawai['username'],1,0);
			$this->pdf->Cell(60,10,$pegawai['level'],1,1);
		}


		$this->_footer();

		$this->pdf->Output();
	}

	public function pesanan()
	{
		$this->load->model('M_pesanan');

		$pesanan = $this->M_pesanan->getPesanan(['status_pesanan' => 'selesai']);

		$this->pdf = new FPDF('p','mm','A4');

		$this->pdf->AliasNbPages();

		// membuat halaman baru
		$this->pdf->AddPage();

		// load Header
		$this->_header();

		// content
		$this->pdf->SetFont('Arial','B',16);
		$this->pdf->Cell(190,8,'Data Pesanan',0,1,'C');


		$this->pdf->Cell(190,1,'',0,1);

		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(10,10,'No.',1,0,'C');
		$this->pdf->Cell(60,10,'ID. Pesanan',1,0,'C');
		$this->pdf->Cell(60,10,'No. Meja',1,0,'C');
		$this->pdf->Cell(60,10,'Waktu',1,1,'C');

		$this->pdf->SetFont('Arial','',11);
		$no = 1;
		foreach($pesanan as $psn){
			$this->pdf->Cell(10,10,$no++,1,0,'C');
			$this->pdf->Cell(60,10,$psn['id_pesanan'],1,0);
			$this->pdf->Cell(60,10,$psn['no_meja'],1,0);
			$this->pdf->Cell(60,10,$psn['waktu'],1,1);
		}


		$this->_footer();

		$this->pdf->Output();	
	}

	public function transaksi()
	{
		$this->load->model('M_transaksi');

		$data = $this->M_transaksi->reportTransaksi();

		$this->pdf = new FPDF('p','mm','A4');

		$this->pdf->AliasNbPages();

		// membuat halaman baru
		$this->pdf->AddPage();

		// load Header
		$this->_header();

		// content
		$this->pdf->SetFont('Arial','B',16);
		$this->pdf->Cell(190,8,'Data Transaksi',0,1,'C');


		$this->pdf->Cell(190,1,'',0,1);

		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(10,10,'No.',1,0,'C');
		$this->pdf->Cell(90,10,'Tanggal',1,0,'C');
		$this->pdf->Cell(90,10,'Pemasukan',1,1,'C');

		$this->pdf->SetFont('Arial','',11);
		$no = 1;
		foreach($data as $data){
			$this->pdf->Cell(10,10,$no++,1,0,'C');
			$this->pdf->Cell(90,10,$data['waktu'],1,0);
			$this->pdf->Cell(90,10,$data['pemasukan'],1,1);
		}


		$this->_footer();

		$this->pdf->Output();	


	}

	public function kartuPengguna($id)
	{
		$this->load->model('M_user');

		$data = $this->M_user->getUserbyID($id);

		$this->pdf = new FPDF('p','mm',[100,100]);

		// membuat halam baru
		$this->pdf->AddPage();

		$this->_headerBuktiPemayaran();

		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(20,8,'Nama',0,0);
		$this->pdf->Cell(10,8,':',0,0);
		$this->pdf->Cell(60,8,$data['nama'],0,1);

		$this->pdf->Cell(20,8,'Username',0,0);
		$this->pdf->Cell(10,8,':',0,0);
		$this->pdf->Cell(60,8,$data['username'],0,1);

		$this->pdf->Cell(20,8,'Password',0,0);
		$this->pdf->Cell(10,8,':',0,0);
		$this->pdf->Cell(60,8,'12345678',0,1);
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(80,2,'Ini hanya password default',0,0,'R');

		$this->pdf->Output();

	}

	public function buktiPembayaran($id_transaksi = null)
	{
		if ($id_transaksi) {

			$this->load->model('M_transaksi','tsk');

			$transaksi = $this->tsk->getTransaksi(['id_transaksi' => $id_transaksi]);
			$detail = $this->tsk->getDetail($transaksi['id_pesanan']);

			$this->pdf = new FPDF('p','mm',[100,200]);

			// membuat halam baru
			$this->pdf->AddPage();

			$this->_headerBuktiPemayaran();

			// seting font
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(40,4,'Id Transaksi : '.$transaksi['id_transaksi'],0,0,'L');
			$this->pdf->Cell(40,4,'Id Pesanan : '.$transaksi['id_pesanan'],0,1,'R');
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->Cell(40,4,'Nama : '.$transaksi['nama'],0,0,'L');
			$this->pdf->Cell(40,4,'Tanggal : '.$transaksi['waktu'],0,1,'R');
			$this->pdf->Cell(80,4,'No. Meja : '.$transaksi['no_meja'],0,1,'L');

			$this->pdf->Ln(3);

			$this->pdf->Cell(80,4,'Detail Pesanan :',0,1,'L');
			$this->pdf->SetFont('Arial','B',10);

			$this->pdf->Cell(40,6,'Pesanan','BT',0,'C');
			$this->pdf->Cell(40,6,'Harga','BT',1,'C');

			$this->pdf->SetFont('Arial','',8);
			foreach($detail as $pesanan) { 
				$this->pdf->Cell(40,5,'('.$pesanan['qty'].') '.$pesanan['nama_menu'],0,0,'L');
				$this->pdf->Cell(40,5,'Rp. '.number_format($pesanan['subtotal']),0,1,'R');
			}

			$this->pdf->Cell(80,1,'','B',1);
			$this->pdf->SetFont('Arial','B',10);

			$this->pdf->Cell(80,6,'Total : Rp. '.number_format($transaksi['total_bayar']),'B',1,'R');

			$this->pdf->ln(10);

			$this->pdf->Cell(40,6,'Dibayar : ',0,0,'L');
			$this->pdf->Cell(40,6,'Rp. '.number_format($transaksi['bayar']),0,1,'R');		

			$this->pdf->SetFont('Arial','B',12);
			$this->pdf->Cell(40,6,'Total Bayar : ',0,0,'L');
			$this->pdf->Cell(40,6,'Rp. '.number_format($transaksi['total_bayar']),0,1,'R');

			$this->pdf->Cell(80,1,'',0,1);

			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(40,6,'Kembali : ',0,0,'L');
			$this->pdf->Cell(40,6,'Rp. '.number_format($transaksi['kembalian']),0,1,'R');

			$this->pdf->ln(30);
			$this->pdf->SetFont('Arial','',10);	
			$this->pdf->Cell(80,6,'Terimakasih telah berkunjung',0,0,'C');


			$this->pdf->Output();
		}
	}

	public function coba()
	{
		$this->pdf = new FPDF('p','mm',[100,200]);

		// membuat halam baru
		$this->pdf->AddPage();

		$this->_headerBuktiPemayaran();

		// seting font
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(40,4,'Id Transaksi : T001',0,0,'L');
		$this->pdf->Cell(40,4,'Id Pesanan : P001',0,1,'R');
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(40,4,'Nama : Aden Trisna',0,0,'L');
		$this->pdf->Cell(40,4,'Tanggal : 2019-08-01',0,1,'R');
		$this->pdf->Cell(80,4,'No. Meja : M001',0,1,'L');

		$this->pdf->Ln(3);

		$this->pdf->Cell(80,4,'Detail Pesanan :',0,1,'L');
		$this->pdf->SetFont('Arial','B',10);

		$this->pdf->Cell(30,6,'Nama Menu','BT',0,'C');
		$this->pdf->Cell(20,6,'Harga','BT',0,'C');
		$this->pdf->Cell(10,6,'Qty','BT',0,'C');
		$this->pdf->Cell(20,6,'Jumlah','BT',1,'C');

		$this->pdf->SetFont('Arial','',8);
		for ($i=0; $i <5 ; $i++) { 
			$this->pdf->Cell(30,5,'Goreng Pisang',0,0,'C');
			$this->pdf->Cell(20,5,'Rp. '.number_format(1000),0,0,'R');
			$this->pdf->Cell(10,5,'10',0,0,'C');
			$this->pdf->Cell(20,5,'Rp. '.number_format(10000),0,1,'R');
		}

		$this->pdf->Cell(80,1,'','B',1);
		$this->pdf->SetFont('Arial','B',10);

		$this->pdf->Cell(40,6,'Total : ','B',0,'L');
		$this->pdf->Cell(40,6,'Rp. '.number_format(50000),'B',1,'R');

		$this->pdf->Cell(40,6,'Bayar : ',0,0,'L');
		$this->pdf->Cell(40,6,'Rp. '.number_format(100000),0,1,'R');

		$this->pdf->Cell(80,1,'',0,1);
		$this->pdf->SetFont('Arial','B',12);

		$this->pdf->Cell(40,6,'Kembalian : ',0,0,'L');
		$this->pdf->Cell(40,6,'Rp. '.number_format(50000),0,1,'R');		


		$this->pdf->Output();
	}
}
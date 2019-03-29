$(document).ready(function(){


const base_url = 'http://localhost/restoran/transaksi/';


$('.lihat').on('click',function(){

	var id_pesanan = $(this).data('pesanan');
	var id_transaksi = $(this).data('transaksi');

	$.ajax({

		url : base_url+'getDataTransaksi',
		method : 'post',
		data : { 
				id_transaksi : id_transaksi
				},
		dataType : 'json',

		success : function(data){
			$('#id_order').text(data.id_pesanan);
			$('#no_meja').text(data.no_meja);
			$('#nama_pelanggan').text(data.nama);
			$('#status').text(data.status_transaksi);
			$('#total_bayar_label').text(data.total_bayar);

			$('#cetak').attr('href','http://localhost/restoran/report/buktiPembayaran/'+id_transaksi);

			if (data.status_transaksi == 'belum bayar') {
				$('#form-bayar').removeClass('d-none');
				$('#id_transaksi').val(data.id_transaksi);
				$('#total_bayar').val(data.total_bayar);
				$('#bayar').val('');
				$('#bayar').attr('disabled',false);
				$('#kembalian').val('');
				$('#kembalian').attr('disabled',false);
				$('#cetak').addClass('d-none');
			}else if(data.status_transaksi == 'sudah bayar'){
				$('#form-bayar').addClass('d-none');
				$('#id_transaksi').val('');
				$('#total_bayar').val('');
				$('#bayar').val(data.bayar);
				$('#bayar').attr('disabled',true);
				$('#kembalian').val(data.kembalian);
				$('#kembalian').attr('disabled',true);
				$('#cetak').removeClass('d-none');
				$('#cetaklink').attr('onclick',"tampilCetak('buktiPembayaran/"+data.id_transaksi+"')");
			}
		}

	});

	$.ajax({
		url : base_url+'detailPesanan',
		method : 'post',
		data : {
			id_pesanan : id_pesanan
		},

		success : function(data){
			$('.detailPesanan').html(data);
			$('#modalLihat').modal('show');
		;}
	})

});

});
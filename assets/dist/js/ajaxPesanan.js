$(document).ready(function(){

const base_url = 'http://localhost/restoran/pesanan/';


$('.lihat').on('click',function(){

	var id_pesanan = $(this).data('id');

	$.ajax({
		url : base_url+'getpesanan',
		method : 'post',
		data : {id_pesanan : id_pesanan},
		dataType : 'json',

		success : function(data){
			$('#id_pesanan').text(data.id_pesanan);
			$('#no_meja').text(data.no_meja);
			$('#nama_pelanggan').text(data.nama);
			$('#status').text(data.status_pesanan);
			$('#waktu').text(data.waktu);
			$('#keterangan').text(data.keterangan);

			if (data.status_pesanan == 'terkirim') {
				$('.btn-ambil').removeClass('d-none');
				$('.btn-ambil').attr('href',base_url+'ambilPesanan/'+data.id_pesanan);
				$('.btn-ambil').text('Ambil');
			}else if(data.status_pesanan == 'diantrikan'){
				$('.btn-ambil').removeClass('d-none');
				$('.btn-ambil').attr('href',base_url+'hantarPesanan/'+data.id_pesanan);
				$('.btn-ambil').text('Hantarkan');
			}else{
				$('.btn-ambil').addClass('d-none');
			}
		}
	});

	$.ajax({
		url : base_url+'detailPesanan',
		method : 'post',
		data : {id_pesanan : id_pesanan},

		success : function(data){
			$('.detailPesanan').html(data);
		}
	});

});

});
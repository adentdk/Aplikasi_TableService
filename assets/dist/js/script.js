const base_url = 'http://localhost/restoran/'

// ==============FUNCTION=============
function hapusConfirm(url){
	console.log('OK');
	$('.btn-hapus').attr('href',url);
	$('#modalHapus').modal('show');
}

function hitungSubTotal(){
	var harga = $('#harga').text();
	var qty = $('#qty').val();
	
	$('#total').val(qty*harga);
}

function hitungKembalian(){
	var bayar = $('#bayar').val();
	var total_bayar = $('#total_bayar').val();

	if (bayar-total_bayar > -1) {
		$('#kembalian').val(bayar-total_bayar);
		$('#tombol-bayar').removeClass('disabled');
		$('#tombol-bayar').attr('disabled', false);
	}else{
		$('#kembalian').val('');
		$('#kembalian').attr('placeholder','Kembalian kurang');
		$('#tombol-bayar').addClass('disabled');
		$('#tombol-bayar').attr('disabled', true);
	}
}

function tampilCetak(doc){
	$('#plugin').attr('src',base_url+'/report/'+doc);
}

// ===========ENDFUNCTION============


const flashdata = $('#flashdata').data('flashdata');

if (flashdata) {
	console.log(flashdata);
	$('#modalAlert').modal('show');
}

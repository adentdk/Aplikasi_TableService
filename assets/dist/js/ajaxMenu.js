$(document).ready(function(){

const base_url = 'http://localhost/restoran/menu/';

	
$('.tambah').click(function(){
	
	$('#modalUserTitle').text('Tambah menu');
	$('.modal-content form').attr('action',base_url+'add');
	$('.form-tambah').removeClass('d-none');
	$('.form-edit').addClass('d-none');

	$('#id_menu').val(null);
	$('#nama_menu').val('');
	$('#qty').val(1);
	$('#harga').val(0);
	$('#keterangan').val('-');

	$('.modal-footer button[type=submit]').text('Tambah Data');

});

$('.edit').click(function(){
	
	$('#modalUserTitle').text('Edit menu');
	$('.modal-content form').attr('action',base_url+'update');
	$('.form-tambah').removeClass('d-none');
	$('.form-edit').addClass('d-none');

	$('.modal-footer button[type=submit]').text('Edit Data');

	var  id_menu = $(this).data('id');
	$.ajax({
		url : base_url+'getMenu',
		method : 'post',
		data : {id_menu : id_menu},
		dataType : 'json',

		success : function(data){
			$('#id_menu').val(data.id_menu);
			$('#nama_menu').val(data.nama_menu);
			$('#qty').val(data.qty);
			$('#harga').val(data.harga);
			$('#keterangan').val(data.keterangan);

			$('#modalMenu').modal('show');
		}
	})

});

});
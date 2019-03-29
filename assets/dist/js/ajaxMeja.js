$(document).ready(function(){

const base_url = 'http://localhost/restoran/meja/';


$('.tambah-meja').click(function(){
	
	$('#modalUserTitle').text('Tambah User');
	$('.modal-content form').attr('action',base_url+'add');
	$('.form-tambah').removeClass('d-none');
	$('.form-edit').addClass('d-none');

	$('#no_meja').val('');
	$('#id_user').val('');

	$('.modal-footer button[type=submit]').text('Tambah Data');

});

});
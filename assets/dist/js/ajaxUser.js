$(document).ready(function(){

const base_url = 'http://localhost/restoran/user/';


$('.tambah-user').click(function(){

	$('#modalUserTitle').text('Tambah User');
	$('.modal-content form').attr('action',base_url+'add');
	$('.form-tambah').removeClass('d-none');
	$('.form-edit').addClass('d-none');

	$('#id_user').val('');
	$('#username').val('');
	$('#password').val(12345678);
	$('#password_hidden').val('');
	$('#passwordLabel').removeClass('d-none');
	$('#nama').val('');

	$('.modal-footer button[type=submit]').text('Tambah Data');

});

$('.edit-user').click(function(){

	var id_user = $(this).data('id');

	$('#modalUserTitle').text('Edit User');
	$('.modal-content form').attr('action',base_url+'update');
	$('.form-edit').removeClass('d-none');
	$('.form-tambah').addClass('d-none');

	$('.modal-footer button[type=submit]').text('Edit Data');

	$.ajax({
		url : base_url+'getUser',
		method : 'post',
		data : {id_user : id_user},
		dataType : 'json',

		success : function(data){
			$('#id_user').val(data.id_user);
			$('#username').val(data.username);
			$('#password').val('');
			$('#passwordLabel').addClass('d-none');
			$('#password_hidden').val(data.password);
			$('#nama').val(data.nama);
			$('#id_level').val(data.id_level);
		}
	});

});














});
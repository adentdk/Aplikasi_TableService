$(document).ready(function(){
const base_url = 'http://localhost/restoran/';

$('.pesan').click(function(){
    var id_menu = $(this).data('id');


    $.ajax({
        url : base_url+'pelanggan/getDetailMenu',
        method : 'post',
        data : {id_menu : id_menu},
        dataType : 'json',

        success : function(data){
            $('#foto').attr('src',base_url+'gambar/menu/'+data.foto);
            $('#id_menu').val(data.id_menu);
            $('#nama_menu').text(data.nama_menu);
            $('#harga').text(data.harga);
            $('#total').val(data.harga);
            $('#qty').attr('max',data.qty);
            $('#keterangan').text(data.keterangan);
        	$('#modalMenu').modal('show');
        }
    })
})


});
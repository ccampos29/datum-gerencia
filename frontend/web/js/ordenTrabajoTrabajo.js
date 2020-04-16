$(document).ready(function () {
   $('.buscar').click(function(){
       console.log($('#select-opciones').val());
       $.ajax({
        url: '../ordenes-trabajos/listar-trabajos',
        method: 'GET',
        data: {},
        success: function (data) {
            console.log(data);
            $('#modal-trabajos').modal('show');
            if( $('#tabla-trabajos').children().lenght > 0){
                $('#tabla-trabajos').children().remove();
            }
            $('#tabla-trabajos').append(data);
        }
    });
   });
   $('.tipo').fadeOut();
   $('#select-opciones').change(function(){
       $('.tipo').fadeOut();
       if($('.tipo').hasClass(this.value))
       $('.'+ this.value).fadeIn(300);
   })
});
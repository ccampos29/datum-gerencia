$(document).ready(function () {
    $('#campo-medicion-mostrar').attr('value', $('#campo-medicion').val());
    $('#campo-medicion-compare').attr('value', $('#campo-medicion').val());
    $('#campo-fecha-mostrar').attr('value', $('#campo-fecha').val());
    $('#campo-hora-mostrar').attr('value', $('#campo-hora').val());
    $('#campo-nevento-mostrar').attr('value', $('#campo-nevento').val());
    $('#campo-tipo-mostrar').attr('value', $('#campo-tipo').val());
    
    $('#select-placa').change(function(){
        $.ajax({
            url: '../mediciones/consulta-medicion?idVehiculo=' + $(this).val(),
            method: 'GET',
            data: {},
            
            success: function (data) {
                arrayWebService = JSON.parse(data);
                console.log(arrayWebService);
                if(arrayWebService.function == 'horom'){
                    $('#campo-medicion').attr('value', arrayWebService.valor/60);
                    $('#campo-medicion-mostrar').attr('value', Math.round(arrayWebService.valor/60));
                    $('#campo-medicion-compare').attr('value', arrayWebService.valor/60);
                
                }else{
                    $('#campo-medicion').attr('value', arrayWebService.valor);
                    $('#campo-medicion-mostrar').attr('value', arrayWebService.valor);
                    $('#campo-medicion-compare').attr('value', arrayWebService.valor);
                
                }
                $('#campo-fecha').attr('value', arrayWebService.fecha);
                $('#campo-hora').attr('value', arrayWebService.hora);
                $('#campo-nevento').attr('value', arrayWebService.estado);
                $('#campo-tipo').attr('value', arrayWebService.tipo);
                
                $('#campo-fecha-mostrar').attr('value', arrayWebService.fecha);
                $('#campo-hora-mostrar').attr('value', arrayWebService.hora);
                $('#campo-nevento-mostrar').attr('value', arrayWebService.estado);
                $('#campo-tipo-mostrar').attr('value', arrayWebService.tipo);
                
                //$('#campo-medicion').val(data);
                
                //$('#campo-nevento').val('');
                
            }
        });
    })
});

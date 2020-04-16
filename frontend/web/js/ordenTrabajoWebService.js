$(document).ready(function () {
    $('#campo-medicion-mostrar').attr('value', $('#campo-medicion').val());
    $.ajax({
        url: '../ordenes-trabajos/consulta-medicion?idVehiculo=' + $('#select-placa').val(),
        method: 'GET',
        data: {},
        success: function (data) {
            arrayWebService = JSON.parse(data);
            console.log(arrayWebService);
            if(arrayWebService.function == 'horom'){
                $('#campo-medicion').attr('value', Math.round(arrayWebService.valor/60));
                $('#campo-medicion-mostrar').attr('value', Math.round(arrayWebService.valor/60));
               
            
            }else{
                $('#campo-medicion').attr('value', arrayWebService.valor);
                $('#campo-medicion-mostrar').attr('value', arrayWebService.valor);
          
            
            }
        }
    });
    $('#select-placa').change(function(){
        $.ajax({
            url: '../ordenes-trabajos/consulta-medicion?idVehiculo=' + $(this).val(),
            method: 'GET',
            data: {},
            success: function (data) {
                arrayWebService = JSON.parse(data);
                console.log(arrayWebService);
                if(arrayWebService.function == 'horom'){
                    $('#campo-medicion').attr('value', Math.round(arrayWebService.valor/60));
                    $('#campo-medicion-mostrar').attr('value', Math.round(arrayWebService.valor/60));
                   
                
                }else{
                    $('#campo-medicion').attr('value', arrayWebService.valor);
                    $('#campo-medicion-mostrar').attr('value', arrayWebService.valor);
              
                
                }
            }
        });
    })
});
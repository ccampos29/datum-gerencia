$(document).ready(function () {
    $('#select-placa').change(function(){
        $.ajax({
            
            url: '../checklist/consulta-medicion?idVehiculo=' + $(this).val(),
            method: 'GET',
            data: {},
            success: function (data) {
                arrayWebService = JSON.parse(data);
                console.log(arrayWebService);
                value=Number(arrayWebService.valor)+100;
                if(arrayWebService.function == 'horom'){
                    $('#campo-medicion').attr('value', Math.round(arrayWebService.valor/60));
                    $('#campo-medicion-mostrar').attr('value', Math.round(arrayWebService.valor/60));
                    $('#campo-medicion-compare').attr('value', Math.round(arrayWebService.valor/60));
                
                }else{
                    $('#campo-medicion').attr('value', arrayWebService.valor);
                    $('#campo-medicion-mostrar').attr('value', arrayWebService.valor);
                    $('#campo-medicion-compare').attr('value', arrayWebService.valor);
                
                }
                
            }
        });
    })
});

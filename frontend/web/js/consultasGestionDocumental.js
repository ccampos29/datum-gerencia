$(document).ready(function () {
    data = ($('#select-vehiculo').val());
    $('#select-vehiculo').change(function(){
        $('#impuestos').removeAttr('value');
        $('#documentos').removeAttr('value');
        if($('#select-vehiculo').val() != undefined){
        console.log("hola");
        $('#impuestos').attr('value', $('#select-vehiculo').val());
        $('#documentos').attr('value', $('#select-vehiculo').val());
        }
    })
});
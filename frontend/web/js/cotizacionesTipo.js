$(document).ready(function () {
    tipo = ($('.tipoSolicitud').val());
    data = ($('.solicitud').attr('id'));
    console.log(data);
    console.log(tipo);
    $('#solicitud-mostrar').attr('value', data);
    if(tipo == 'Repuestos'){
        $('.tipoTrabajos').hide();
    }
    else {
        $('.tipoRepuestos').hide();
    }
});
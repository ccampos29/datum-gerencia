
$(document).ready(function () {
    if($('#criteriosId').val() == "Lista" || $('#criteriosId').val() == "Botones"){
        $('#editable').fadeOut();
    }
    else{
        $('#editable').fadeIn(300);
    }

    $('.btn-eliminar-imagen').click(function (e) {
        e.preventDefault();
        var btn = $(this);
        var valor = $(this).attr('id-imagen');
        $.ajax({
            url: 'producto/eliminar-imagen-segundaria?idImagen=' + valor,
            method: 'POST',
            data: {},
            success: function (data) {
                if (data) {
                    btn.parent().parent().parent().remove();
                    toastr.success('Imagen eliminada');
                } else {
                    toastr.error('Ocurrio un error al momento de la eliminación, contactese con los\n\
                                    administradores.');
                }
            }
        });

    });

});
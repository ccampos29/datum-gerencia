$(document).ready(function () {
    var rutina_id;
    var trabajo_id;
    var cantidad;
    var observacion;
    $("#btn-guardar-trabajos").click(function () {
        var arrayTrTrabajos = $("#cualquiercosa")
            .children()
            .children()
            .last()
            .children();
        var arrayInformacionCompleta = new Array();
        for (i = 0; i < arrayTrTrabajos.length; i++) {
            //console.log($(arrayTrTrabajos[i]).children());
            for (j = 0; j < $(arrayTrTrabajos[i]).children().length; j++) {
                var arrayInformacion = new Array();
                if ($($(arrayTrTrabajos[i]).children()[j]).hasClass("list-cell__rutina_id")) {
                    rutina_id = $($(arrayTrTrabajos[i]).children()[j]).children().children('input').val();
                    //arrayInformacion.push({'rutina_id':rutina_id});
                    //arrayInformacion['rutina_id'] = rutina_id;
                    arrayInformacion = {'rutina_id':rutina_id};
                }
                if ($($(arrayTrTrabajos[i]).children()[j]).hasClass("list-cell__trabajo_id")) {
                    trabajo_id = $($(arrayTrTrabajos[i]).children()[j]).children().children('select').val();
                    arrayInformacion = {'trabajo_id':trabajo_id};
                    //arrayInformacion.push({'trabajo_id':trabajo_id});
                    //arrayInformacion['trabajo_id'] = trabajo_id;
                }
                if ($($(arrayTrTrabajos[i]).children()[j]).hasClass("list-cell__cantidad")) {
                    cantidad = $($(arrayTrTrabajos[i]).children()[j]).children().children('input').val();
                    arrayInformacion = {'cantidad':cantidad};
                    //arrayInformacion.push({'cantidad':cantidad});
                    //arrayInformacion['cantidad'] = cantidad;
                }
                if ($($(arrayTrTrabajos[i]).children()[j]).hasClass("list-cell__observacion")) {
                    observacion = $($(arrayTrTrabajos[i]).children()[j]).children().children('input').val();
                    arrayInformacion = {'observacion':observacion};
                    //arrayInformacion.push({'observacion':observacion});
                    //arrayInformacion['observacion'] = observacion;
                }
                //console.log(arrayInformacion);
                arrayInformacionCompleta.push(arrayInformacion);
                //arrayInformacion['rutina_id'] = $($(arrayTrTrabajos[i]).children()[j]).hasClass('list-cell__rutina_id');

                //ajax
                rutina_id = null;
                trabajo_id = null;
                cantidad = null;
                observacion = null;
            }
        }

        console.log(arrayInformacionCompleta);

        $.ajax({
            url: '../rutinas/actualizar-trabajos',
            method: 'POST',
            data: {arrayInformacionCompleta},
            success: function (data) {
                console.log(data);
            }
        });
    });

    $(document).on('keyup', '.campo-cantidad', function () {
        var idRepuesto = $(this).parent().parent().prev().children().children('select').val();
        var cantidad = $(this).val();
        var campoCantidad = $(this);
        if(idRepuesto !== null && cantidad>0){
            $.ajax({
                url: '../repuestos/obtener-precio-multiplicado?idRepuesto='+idRepuesto+'&cantidad='+cantidad,
                method: 'GET',
                data: {},
                success: function (data) {
                    campoCantidad.parent().parent().next().children().children('input').val(data);
                }
            });
        }
        //console.log($(this).parent().parent().prev().children().children('select').val());
    });


    $('#cualquiercosa').on('beforeDeleteRow', function(e, row, currentIndex){
        // row - HTML container of the current row for removal.
        // For TableRenderer it is tr.multiple-input-list__item
        return confirm('Si este trabajo cuenta con insumos y repuestos asociados y es eliminado se eliminaran también esos insumos y repuestos, ¿Realmente quiere continuar?')
    });
});

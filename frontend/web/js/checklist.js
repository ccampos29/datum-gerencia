$(document).ready(function () {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  if($('#fecha-checklist').val()){
    $('#fecha-checklist-mostrar').attr('value', $('#fecha-checklist').val());
  }else{
    $("#fecha-checklist").attr('value', today);
    $("#fecha-checklist-mostrar").attr('value', today);
  }
  $('#campo-medicion-mostrar').attr('value', $('#campo-medicion').val());
  $('#campo-fecha-mostrar').attr('value', $('#fecha-siguiente').val());
  $('#campo-medicion-siguente-mostrar').attr('value', $('#campo-medicion-siguente').val());
  
  $("#select-tipo").change(function () {
    $.ajax({
      url: "../tipos-checklist/obtener-periodicidad-checklist?idTipoChecklist=" + $("#select-tipo").val(),
      method: "GET",
      dataType: 'json',
      success: function (data) {
        if (data) {
          let dia = data.dias;
          let horas = data.horas;
          let odometro = data.odometro;
          if (dia)
            calcularPorTiempo(today, dia, 'Día');
          if (horas)
            calcularPorTiempo(today, horas, 'Hora');
          if (odometro)
            calcularPorDistancia(parseInt($("#campo-medicion").val()), parseInt(odometro));
        } else {
          alert("No hay información disponible");
        }
      },
      error: function (e) {
        console.log(e);
      }
    });
  });

  function calcularPorTiempo(fecha_actual, cantidad, periodicidad) {
    $.ajax({
      url:
        "../tipos-checklist/calcular-tiempo?fechaActual=" +
        fecha_actual +
        "&cantidad=" +
        cantidad +
        "&periodicidad=" +
        periodicidad,
      method: "GET",
      data: {},
      success: function (data) {
        console.log(data);
        $("#fecha-siguiente").val(data);
        $("#campo-fecha-mostrar").val(data);
      }
    });
  }

  function calcularPorDistancia(medicionActual, cantidad) {
    console.log(typeof medicionActual);
    console.log(cantidad + medicionActual);
    medicionCalculada = medicionActual + cantidad;
    $("#campo-medicion-siguente").val(medicionCalculada);
    $("#campo-medicion-siguente-mostrar").val(medicionCalculada); //aqui se pone el nuevo valor
  }

});

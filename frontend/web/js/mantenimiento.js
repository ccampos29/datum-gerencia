$(document).ready(function () {
  $('#campo-duracion-mostrar').attr('value', $('#campo-duracion').val());
  $("#select-placa").change(function () {
    $.ajax({
      url:
        "../mantenimientos/consulta-duracion?idVehiculo=" +
        $(this).val() +
        "&idTrabajo=" +
        $("#select-trabajo").val(),
      method: "GET",
      data: {},
      success: function (data) {
        duracion = JSON.parse(data);
        console.log(duracion);
        if (duracion.duracion != "No") {
          $("#campo-duracion").attr("value", duracion.duracion);
          $("#campo-duracion-mostrar").attr("value", duracion.duracion);
        }
      },
    });

    $.ajax({
      url:
        "../mantenimientos/consulta-fecha?idVehiculo=" +
        $(this).val() +
        "&idTrabajo=" +
        $("#select-trabajo").val(),
      method: "GET",
      data: {},
      success: function (data) {
        fecha = JSON.parse(data);
        console.log(fecha);
        if (fecha.fecha != "No") {
          $("#campo-fecha").attr("value", fecha.fecha);
        }
      },
    });
  });

  $("#select-trabajo").change(function () {
    $.ajax({
      url:
        "../mantenimientos/consulta-duracion?idVehiculo=" +
        $("#select-placa").val() +
        "&idTrabajo=" +
        $(this).val(),
      method: "GET",
      data: {},
      success: function (data) {
        duracion = JSON.parse(data);
        console.log(duracion);
        if (duracion.duracion != "No") {
          $("#campo-duracion").attr("value", duracion.duracion);
          $("#campo-duracion-mostrar").attr("value", duracion.duracion);
        }
      },
    });

    $.ajax({
      url:
        "../mantenimientos/consulta-fecha?idVehiculo=" +
        $("#select-placa").val() +
        "&idTrabajo=" +
        $(this).val(),
      method: "GET",
      data: {},
      success: function (data) {
        fecha = JSON.parse(data);
        console.log(fecha);
        if (fecha.fecha != "No") {
          $("#campo-fecha").attr("value", fecha.fecha);
        }
      },
    });
  });
});

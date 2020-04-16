$(document).ready(function() {
  orden = $(".orden").attr("id");
  console.log(orden);
  console.log($("#vehiculo").attr("class"));
  $.ajax({
    url:
      "../ordenes-trabajos-trabajos/consulta-trabajo?idTrabajo=" +
      $('#select-trabajo').val() + "&idVehiculo=" + $('#vehiculo').attr('class'),
    method: "GET",
    data: {},
    success: function(data) {
      trabajo = JSON.parse(data);
      console.log(trabajo);
      $.ajax({
        url:
          "../ordenes-trabajos-trabajos/consulta-tipo-mantenimiento?idTipoMantenimiento=" +
          trabajo.tipoMantenimiento,
        method: "GET",
        data: {},
        success: function(data) {
          tipoMantenimiento = JSON.parse(data);
          console.log(tipoMantenimiento);
          $("#tipoMantenimiento-mostrar").attr(
            "value",
            tipoMantenimiento.nombre
          );
        }
      });

      $("#manoObra").attr("value", trabajo.manoObra);
      $("#manoObra-mostrar").attr("value", trabajo.manoObra);
      $("#cantidad").attr("value", trabajo.cantidad);
      $("#cantidad-mostrar").attr("value", trabajo.cantidad);
      $("#tipoMantenimiento").attr("value", trabajo.tipoMantenimiento);
    }
  });
  $("#orden-mostrar").attr("value", orden);
  $("#select-trabajo").change(function() {
    $.ajax({
      url:
        "../ordenes-trabajos-trabajos/consulta-trabajo?idTrabajo=" +
        $(this).val() + "&idVehiculo=" + $('#vehiculo').attr('class') + "&busca=1",
      method: "GET",
      data: {},
      success: function(data) {
        trabajo = JSON.parse(data);
        console.log(trabajo);
        $.ajax({
          url:
            "../ordenes-trabajos-trabajos/consulta-tipo-mantenimiento?idTipoMantenimiento=" +
            trabajo.tipoMantenimiento,
          method: "GET",
          data: {},
          success: function(data) {
            tipoMantenimiento = JSON.parse(data);
            console.log(tipoMantenimiento);
            $("#tipoMantenimiento-mostrar").attr(
              "value",
              tipoMantenimiento.nombre
            );
          }
        });

        $("#manoObra").attr("value", trabajo.manoObra);
        $("#manoObra-mostrar").attr("value", trabajo.manoObra);
        $("#cantidad").attr("value", trabajo.cantidad);
        $("#cantidad-mostrar").attr("value", trabajo.cantidad);
        $("#tipoMantenimiento").attr("value", trabajo.tipoMantenimiento);
      }
    });
  });
});

$(document).ready(function() {
  orden = $(".orden").attr("id");
  console.log(orden);
  proveedor = $(".proveedor").attr("id");
  idProveedor = $(".proveedor").val();
  console.log(idProveedor);
  $("#orden-mostrar").attr("value", orden);
  $("#proveedor-mostrar").attr("value", proveedor);
  $.ajax({
    url:
      "../ordenes-trabajos-repuestos/consulta-repuesto?idRepuesto=" +
      $('#select-repuesto').val(),
    method: "GET",
    data: {},
    success: function(data) {
      repuesto = JSON.parse(data);
      console.log(repuesto);
      $.ajax({
        url:
          "../ordenes-trabajos-repuestos/consulta-tipo-impuesto?idImpuesto=" +
          repuesto.impuesto,
        method: "GET",
        data: {},
        success: function(data) {
          tipoImpuesto = JSON.parse(data);
          console.log(tipoImpuesto);
          $("#impuesto-mostrar").attr("value", tipoImpuesto.nombre);
        }
      });
      $.ajax({
        url:
          "../ordenes-trabajos-repuestos/consulta-tipo-descuento?idDescuento=" +
          repuesto.tipoDescuento,
        method: "GET",
        data: {},
        success: function(data) {
          tipoDescuento = JSON.parse(data);
          console.log(tipoDescuento);
          $("#tipoDescuento-mostrar").attr("value", tipoDescuento.tipo);
        }
      });
      $("#tipoDescuento").attr("value", repuesto.tipoDescuento);
      $("#impuesto").attr("value", repuesto.impuesto);
      $("#costo").attr("value", repuesto.costoUnitario);
      $("#descuento").attr("value", repuesto.descuento);
      $("#costo-mostrar").attr("value", repuesto.costoUnitario);
      $("#descuento-mostrar").attr("value", repuesto.descuento);
      $("#cantidad-mostrar").attr("value", repuesto.cantidad);
      $("#cantidad").attr("value", repuesto.cantidad);
      
    }
  });
});
$("#select-repuesto").change(function() {
  $.ajax({
    url:
      "../ordenes-trabajos-repuestos/consulta-repuesto?idRepuesto=" +
      $(this).val()+"&idProveedor="+$(".proveedor").val(),
    method: "GET",
    data: {},
    success: function(data) {
      repuesto = JSON.parse(data);
      console.log(repuesto);
      $.ajax({
        url:
          "../ordenes-trabajos-repuestos/consulta-tipo-impuesto?idImpuesto=" +
          repuesto.impuesto,
        method: "GET",
        data: {},
        success: function(data) {
          tipoImpuesto = JSON.parse(data);
          console.log(tipoImpuesto);
          $("#impuesto-mostrar").attr("value", tipoImpuesto.nombre);
        }
      });
      $.ajax({
        url:
          "../ordenes-trabajos-repuestos/consulta-tipo-descuento?idDescuento=" +
          repuesto.tipoDescuento,
        method: "GET",
        data: {},
        success: function(data) {
          tipoDescuento = JSON.parse(data);
          console.log(tipoDescuento);
          $("#tipoDescuento-mostrar").attr("value", tipoDescuento.tipo);
        }
      });
      $("#tipoDescuento").attr("value", repuesto.tipoDescuento);
      $("#impuesto").attr("value", repuesto.impuesto);
      $("#costo").attr("value", repuesto.costoUnitario);
      $("#descuento").attr("value", repuesto.descuento);
      $("#costo-mostrar").attr("value", repuesto.costoUnitario);
      $("#descuento-mostrar").attr("value", repuesto.descuento);
      $("#cantidad-mostrar").attr("value", repuesto.cantidad);
      $("#cantidad").attr("value", repuesto.cantidad);
    }
  });
});


$(document).ready(function () {
  $.ajax({
    url:
      "../mantenimientos/consulta-medicion-ejecucion?idVehiculo=" +
      $("#select-placa").val() +
      "&idTrabajo=" +
      $("#select-trabajo").val(),
    method: "GET",
    data: {},
    success: function(data) {
      trabajo = JSON.parse(data);
        console.log(trabajo);
        if(trabajo.trabajoNormal != 'No'){
          dato = parseInt($('#campo-medicion').val()) + trabajo.trabajoNormal;
          console.log(typeof(dato));
        $('#campo-medicion-ejecucion').attr('value', dato);
      }
    }
  });
    $('#campo-medicion-mostrar').attr('value', $('#campo-medicion').val());
    $('#select-placa').change(function(){
        $.ajax({
            url: '../mantenimientos/consulta-medicion?idVehiculo=' + $(this).val(),
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

    $("#select-placa").change(function() {
        $.ajax({
          url:
            "../mantenimientos/consulta-medicion-ejecucion?idVehiculo=" +
            $(this).val() +
            "&idTrabajo=" +
            $("#select-trabajo").val(),
          method: "GET",
          data: {},
          success: function(data) {
            trabajo = JSON.parse(data);
              console.log(trabajo);
              if(trabajo.trabajoNormal != 'No'){
                dato = parseInt($('#campo-medicion').val()) + trabajo.trabajoNormal;
                console.log(typeof(dato));
              $('#campo-medicion-ejecucion').attr('value', dato);
            }
          }
        });
      });
      $("#select-trabajo").change(function() {
        $.ajax({
          url:
            "../mantenimientos/consulta-medicion-ejecucion?idVehiculo=" +
            $("#select-placa").val() +
            "&idTrabajo=" +
            $(this).val(),
          method: "GET",
          data: {},
          success: function(data) {
            trabajo = JSON.parse(data);
              console.log(trabajo);
              if(trabajo.trabajoNormal != 'No'){
                  dato = parseInt($('#campo-medicion').val()) + trabajo.trabajoNormal;
                  console.log(typeof(dato));
                $('#campo-medicion-ejecucion').attr('value', dato);
              }
          }
        });
      });

});
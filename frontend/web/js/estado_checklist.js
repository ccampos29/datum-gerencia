$(document).ready(function () {
    let estado_checklist = $("#estadoschecklistpersonal-usuario_id").change(function () {
        $.ajax({
          url: "../estados-checklist-personal/get-email?user="+$(this).val(),
          method: "GET",
          dataType: 'json',
          success: function (data) {
            if (data) {
              $('#estadoschecklistpersonal-email').val(data);
            } else {
              alert("No hay información disponible");
            }
          },
          error: function (e) {
            console.log(e);
          }
        });
    });

    let ch_tp_checklist = $("#select-checklist").change(function () {
      $.ajax({
        url: "../estados-checklist-configuracion/get-email?user="+$(this).val(),
        method: "GET",
        dataType: 'json',
        success: function (data) {
          if (data) {
            $('#estadoschecklistpersonal-email').val(data);
          } else {
            alert("No hay información disponible");
          }
        },
        error: function (e) {
          console.log(e);
        }
      });
  });

});
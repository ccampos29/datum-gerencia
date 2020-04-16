//Ingresa astericos automáticamente a los inputs required
$(".required")
    .closest(":has(label)")
    .find("label")
    .addClass("asterik");

//Loading automáticamente en los ajax
var $loading = $(".loading-mich").hide();
$(document)
    .ajaxStart(function() {
        $loading.fadeIn(300);
    })
    .ajaxStop(function() {
        $loading.fadeOut(300);
    });


$(document).on('click', 'button[type="reset"]', function() {
    window.location.reload(false);

});; //Validación inputs checklist tipos
$('#tiposchecklist-dias').keyup(function(e) {
    return (!$(this).val()) ? $('#tiposchecklist-horas').attr("readonly", false) : $('#tiposchecklist-horas').attr("readonly", true).val("0")
});
$('#tiposchecklist-horas').keyup(function(e) {
    return (!$(this).val()) ? $('#tiposchecklist-dias').attr("readonly", false) : $('#tiposchecklist-dias').attr("readonly", true).val("0")
});

//Refrese todos los botones de reset
$('button[type="reset"]').click(function(e) {
    location.reload();
});


// Sales chart
/*  var area = new Morris.Area({
  element   : 'revenue-chart',
  resize    : true,
  data      : [
    { y: '2011 Q1', item1: 2666, item2: 2666 },
    { y: '2011 Q2', item1: 2778, item2: 2294 },
    { y: '2011 Q3', item1: 4912, item2: 1969 },
    { y: '2011 Q4', item1: 3767, item2: 3597 },
    { y: '2012 Q1', item1: 6810, item2: 1914 },
    { y: '2012 Q2', item1: 5670, item2: 4293 },
    { y: '2012 Q3', item1: 4820, item2: 3795 },
    { y: '2012 Q4', item1: 15073, item2: 5967 },
    { y: '2013 Q1', item1: 10687, item2: 4460 },
    { y: '2013 Q2', item1: 8432, item2: 5713 }
  ],
  xkey      : 'y',
  ykeys     : ['item1', 'item2'],
  labels    : ['Item 1', 'Item 2'],
  lineColors: ['#a0d0e0', '#3c8dbc'],
  hideHover : 'auto'
}); */


$("#select-pais").change(function() {
    obtenerValorSelectPais();
});
$("#select-departamento").change(function() {
    obtenerValorSelectDepto();
});

function obtenerValorSelectPais() {
    if ($("#select-pais").val() != "") {
        $("#select-departamento").removeAttr("disabled");
        $("#select-departamento")
            .children()
            .remove();
        cargaSelectDepartamento($("#select-pais").val());
    } else {
        $("#select-departamento").attr("disabled", "disabled");
    }
}

function obtenerValorSelectDepto() {
    if ($("#select-departamento").val() != "") {
        $("#select-ciudad").removeAttr("disabled");
        $("#select-ciudad")
            .children()
            .remove();
        cargaSelectCiudad($("#select-departamento").val());
    } else {
        $("#select-ciudad").attr("disabled", "disabled");
    }
}

function cargaSelectDepartamento(id) {
    console.log(id);
    $.ajax({
        url: "../proveedores/listado-departamento?idPais=" + id,
        method: "POST",
        data: {},
        success: function(data) {
            $("#select-departamento").append(data);
        }
    });
}

function cargaSelectCiudad(id) {
    $.ajax({
        url: "../proveedores/listado-ciudad?idDepto=" + id,
        method: "POST",
        data: {},
        success: function(data) {
            $("#select-ciudad").append(data);
        }
    });
}
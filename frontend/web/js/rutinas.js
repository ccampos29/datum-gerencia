$(document).ready(function () {
    var count_row = 0;

    $('.plus_trabajos').click(function(e){
        
        let trabajoRutinas  = $('#rutinas-trabajosrutinas').select2('data')[0];
        let idInventariable = $('#idInventariable').select2('data');
        let nameRepuesto    = $('#idRepuesto option:selected').text();
        let idRepuesto      = $('#idRepuesto').val();
        let rutinas_cantidad= $('#rutinas-cantidad').val();
        let rutinas_valor   = $('#rutinas-valor').val();

        $('.repuestos_rutina tbody').prepend(`<tr id="trabajos${count_row}"><td><select class="form-control" name="Rutinas[trabajosRutinas][]"><option value="${trabajoRutinas.id}"> ${trabajoRutinas.text} </option> </select> </td><td>${idInventariable[0].text}</td><td>${nameRepuesto}</td><td>${rutinas_cantidad}</td><td>${rutinas_valor}</td><td> <button onclick="eliminarFila(${count_row})">Eliminar</button></td> </tr>`);
        count_row++;
    });
});

function eliminarFila(id){
    document.getElementById("trabajos"+id).remove();
}
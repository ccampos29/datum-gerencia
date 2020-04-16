$(document).ready(function () {
    data = $('.repuesto').val();
    data2 = $('.repuesto').attr('id');
    console.log(data2);
    $('#repuesto-mostrar').attr('value', data2);
});
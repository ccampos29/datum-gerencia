
$(document).ready(function () {
    data = $('#rutina').val();
    console.log(data);
    $('#rutina-mostrar').attr('value', data);
    $('.tipo').fadeOut();
    $('#tipoPeriodicidad').change(function(){
        $('.tipo').fadeOut();
        if($('.tipo').hasClass(this.value))
        $('.'+ this.value).fadeIn(300);
    })
});
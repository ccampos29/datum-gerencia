
$(document).ready(function () {
    data = $('#trabajo').val();
    console.log(data);
    $('#trabajo-mostrar').attr('value', data);
    $('.tipo').fadeOut();
    $('#tipoPeriodicidad').change(function(){
        $('.tipo').fadeOut();
        if($('.tipo').hasClass(this.value))
        $('.'+ this.value).fadeIn(300);
    })
});
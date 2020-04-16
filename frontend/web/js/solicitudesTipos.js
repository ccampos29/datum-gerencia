$(document).ready(function () {
    $('.tipo').hide();
    if($('#tipo').val() == 'Repuestos'){
        $('.tipo.Repuestos').fadeIn(300);
    }
    if($('#tipo').val() == 'Trabajos'){
        $('.tipo.Trabajos').fadeIn(300);
    }
    $('#tipo').change(function(){
        $('.tipo').hide();
        if($('.tipo').hasClass(this.value))
        $('.'+ this.value).fadeIn(300);
    })
});
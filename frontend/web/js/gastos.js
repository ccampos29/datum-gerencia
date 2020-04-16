$(document).ready(function () {
    $('#editable').fadeOut();
    $('#editable2').fadeOut();
    $('#select').change(function(){
        console.log($(this).val());
        
        if($(this).val() == 2){
            $('#editable').fadeOut();
            $('#editable2').fadeIn(300);
        }
        else{
            $('#editable2').fadeOut();
            $('#editable').fadeIn(300);
        }
    })
});
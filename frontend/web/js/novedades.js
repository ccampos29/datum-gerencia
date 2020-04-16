$(document).ready(function () {

   var disabled_selects = function ($this){
      let calificacion = $($this).children("option:selected").text();
      let data_index = $($this).attr('data-calificacion');
      if(calificacion == 'APROBADO'){
         $('#trabajo'+data_index).find('select').attr('disabled',true);
         $('#prioridad'+data_index).find('select').attr('disabled',true);
      }else{
         $('#trabajo'+data_index).find('select').attr('disabled',false);
         $('#prioridad'+data_index).find('select').attr('disabled',false);
      }
  }

   let selects_calificacion = $('.calificacion-select').each(function() {
      disabled_selects(this);
  });

   let change_selects    = $('.calificacion-select').change(function(e){
      disabled_selects(this);
   });

   $('#w0').submit(function(e){
      $('.calificacion-select').each(function() {
         let data_index = $(this).attr('data-calificacion');
         $('#trabajo'+data_index).find('select').attr('disabled',false);
         $('#prioridad'+data_index).find('select').attr('disabled',false);
     });
     
   });


});
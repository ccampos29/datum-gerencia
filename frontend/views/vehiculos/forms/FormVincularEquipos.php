<?php
    use kartik\select2\Select2;

    $list = [1 => 'Si', 0 => 'No'];
?>


<div class="container-fluid col-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>
                <i class="fa fa-question" aria-hidden="true"></i> ¿Permitir instalacion de nuevos equipos? 
            </label>
            
            <?= $form->field($model, 'vehiculo_equipo')->radioList($list, ['inline'=>true,
            'pluginEvents' => [
                    'change' => 'function() { if($(this).val() == 1){ $("#idTest").show() } else { $("#idTest").hide() }'
                ]
            ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" id="idTest">
            <label>
                <i class="fa fa-font" aria-hidden="true"></i> Observacion
            </label>
            <?= $form->field($model, 'vehiculo_equipo_observacion')->textInput()->label(false)?>
        </div>
    </div>
    <hr>
</div>
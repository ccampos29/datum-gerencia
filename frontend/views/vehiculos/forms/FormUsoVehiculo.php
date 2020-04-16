<div class="container-fluid col-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-arrows-v" aria-hidden="true"></i> Distancia maxima por dia 
            </label>
            <?= $form->field($model, 'distancia_maxima')->textInput(['type'=>'number'])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-arrows-h" aria-hidden="true"></i> Distancia promedio por dia
            </label>
            <?= $form->field($model, 'distancia_promedio')->textInput(['type'=>'number'])->label(false)?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hourglass-half" aria-hidden="true"></i> Horas de trabajo diarias
            </label>
            <?= $form->field($model, 'horas_dia')->textInput(['type'=>'number'])->label(false)?>
        </div>
    </div>
    <hr>
</div>
<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\number\NumberControl;

?>

<div class="container-fluid col-12">
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-user-circle" aria-hidden="true"></i> Nombre del vendedor
            </label>
            <?= $form->field($model, 'nombre_vendedor')->textInput(['maxlength' => true])->label(false) ?> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-usd" aria-hidden="true"></i> Precio de compra 
            </label>
            <?= $form->field($model, 'precio_compra')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false) ?>
            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-calendar" aria-hidden="true"></i> Fecha de compra del vehiculo 
            </label>
            <?= $form->field($model, 'fecha_compra')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha de ingreso ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'endDate' => date('Y-m-d'),
                        'autoclose' => true
                    ]
                ])->label(false) ?>            
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-usd" aria-hidden="true"></i> Precio accesorios
            </label>
                <?= $form->field($model, 'precio_accesorios')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                        'max' => 1000000000000000000
                    ],
                ])->label(false) ?> 
        </div>
    </div>
    <hr>
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion compra
            </label>
            <?= $form->field($model, 'medicion_compra')->textInput()->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Numero de importacion
            </label>
            <?= $form->field($model, 'numero_importacion')->textInput()->label(false) ?>  
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-calendar" aria-hidden="true"></i> Fecha de importacion
            </label>
            <?= $form->field($model, 'fecha_importacion')->widget(DatePicker::classname(),[
                'name' => 'fecha_importacion',
                'options' => ['placeholder' => 'Selecciona la fecha de importacion del vehiculo'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'endDate' => date('Y-m-d', strtotime('+15 days')),
                    'autoclose' => true,
                ]
            ])->label(false) ?> 
        </div>   
    </div>
    <hr>
</div>
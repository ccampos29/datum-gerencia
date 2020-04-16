<?php

use frontend\models\LineasMotores;
use frontend\models\MarcasMotores;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

$urlMarcasMotores = Yii::$app->urlManager->createUrl('marcas-motores/marcas-motores-list');
?>

<div class="container-fluid col-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Identificacion auxliar
            </label>
            <?= $form->field($model, 'identificacion_auxiliar')->textInput()->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-compass" aria-hidden="true"></i> Imei del GPS
            </label>
            <?= $form->field($model, 'vehiculo_imei_gps')->textInput(['type' => 'number'])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-user" aria-hidden="true"></i> Propietario del vehiculo
            </label>
            <?= $form->field($model, 'propietario_vehiculo')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Numero del chasis
            </label>
            <?= $form->field($model, 'numero_chasis')->textInput()->label(false) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>
                <i class="fa fa-cogs" aria-hidden="true"></i> Marca del motor
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'motor_id')->widget(Select2::classname(), [
                        'data' => !empty($model->motor_id) ? [$model->motor_id => MarcasMotores::findOne($model->motor_id)->nombre] : [],
                        'options' => ['id' => 'idMotor', 'placeholder' => 'Seleccione una marca de motor',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlMarcasMotores,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../marcas-motores/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una marca de motor" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>
                <i class="fa fa-cogs" aria-hidden="true"></i> Linea del Motor
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'linea_motor_id')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'idLineaMotor'],
                        'data' => !empty($model->linea_motor_id) ? [$model->linea_motor_id => LineasMotores::findOne($model->linea_motor_id)->descripcion] : [],

                        'pluginOptions' => [
                            'depends' => ['idMotor'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['marcas-motores/lineas'])
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../lineas-motores/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una linea de motor" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Numero de serie
            </label>
            <?= $form->field($model, 'numero_serie')->textInput()->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-cog" aria-hidden="true"></i> Tipo de carroceria
            </label>
            <?= $form->field($model, 'tipo_carroceria')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad de sillas
            </label>
            <?= $form->field($model, 'cantidad_sillas')->textInput(['type' => 'number'])->label(false) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Toneladas de carga
            </label>
            <?= $form->field($model, 'toneladas_carga')->textInput(['type' => 'number'])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo fasecolda
            </label>
            <?= $form->field($model, 'codigo_fasecolda')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-server" aria-hidden="true"></i> Tipo de servicio
            </label>
            <?= $form->field($model, 'tipo_servicio')->dropDownList(
                ['Maquinaria' => 'Maquinaria', 'Particular' => 'Particular', 'Acarreos' => 'Acarreos', 'Transporte' => 'Transporte'],
                ['prompt' => 'Seleciona uno...']
            )->label(false) ?>
        </div>
    </div>
    <hr>
</div>
<?php

use frontend\models\Municipios;
use frontend\models\Departamentos;
use frontend\models\Pais;
use frontend\models\GruposVehiculos;
use frontend\models\CentrosCostos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;

$urlPais = Yii::$app->urlManager->createUrl('pais/pais-list');
$urlPrimerGruposVehiculos = Yii::$app->urlManager->createUrl('grupos-vehiculos/primer-grupos-vehiculos-list');
$urlSegundoGruposVehiculos = Yii::$app->urlManager->createUrl('grupos-vehiculos/segundo-grupos-vehiculos-list');
$urlCentrosCostos = Yii::$app->urlManager->createUrl('centros-costos/centros-costos-list');

?>


<div class="container-fluid col-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-map" aria-hidden="true"></i> Pais
            </label>
            <?= $form->field($model, 'pais_id')->widget(Select2::classname(), [
                'data' => !empty($model->pais_id) ? [$model->pais_id => Pais::findOne($model->pais_id)->nombre] : [],
                'options' => ['id' => 'idPais', 'placeholder' => 'Seleccione un pais',],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 0,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                    ],
                    'ajax' => [
                        'url' => $urlPais,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ]
            ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-map-pin" aria-hidden="true"></i> Departamento
            </label>
            <?= $form->field($model, 'departamento_id')->widget(DepDrop::classname(), [
                'options' => ['id' => 'idDepartamento'],
                'data' => !empty($model->departamento_id) ? [$model->departamento_id => Departamentos::findOne($model->departamento_id)->nombre] : [],

                'pluginOptions' => [
                    'depends' => ['idPais'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['vehiculos/departamentos'])
                ]
            ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-map-mark" aria-hidden="true"></i> Municipio
            </label>
            <?= $form->field($model, 'municipio_id')->widget(DepDrop::classname(), [
                'options' => ['id' => 'idMunicipio'],
                'data' => !empty($model->municipio_id) ? [$model->municipio_id => Municipios::findOne($model->municipio_id)->nombre] : [],

                'pluginOptions' => [
                    'depends' => ['idDepartamento'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['vehiculos/municipios'])
                ]
            ])->label(false) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-building" aria-hidden="true"></i> Centro de costos
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                        'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                        'options' => ['placeholder' => 'Seleccione una marca de motor',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlCentrosCostos,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false)
                    ?>
                </div>
                <div class="col-xs-2">
                    <a href="../centros-costos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costos" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-cubes" aria-hidden="true"></i> Primer grupo del vehiculo
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'grupos[0]')->widget(Select2::classname(), [
                        'data' => !empty($model->grupos[0]) ? [$model->grupos[0] => GruposVehiculos::findOne($model->grupos[0])->nombre] : [],
                        'options' => ['placeholder' => 'Seleccione el primer grupo',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlPrimerGruposVehiculos,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false)
                    ?>
                </div>


                <div class="col-xs-2">
                    <a href="../grupos-vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear dato para el primer grupo" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-cubes" aria-hidden="true"></i> Segundo grupo del vehiculo
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'grupos[1]')->widget(Select2::classname(), [
                        'data' => !empty($model->grupos[1]) ? [$model->grupos[1] => GruposVehiculos::findOne($model->grupos[1])->nombre] : [],
                        'options' => ['placeholder' => 'Seleccione el segundo grupo',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlSegundoGruposVehiculos,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false)
                    ?>
                </div>
                <div class="col-xs-2">
                    <a href="../grupos-vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear dato para el segundo grupo" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div clas="col-12">
            <label>
                <i class="fa fa-font" aria-hidden="true"></i> Observaciones
            </label>
            <?= $form->field($model, 'observaciones')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
    <hr>
</div>
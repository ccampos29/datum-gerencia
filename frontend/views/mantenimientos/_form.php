<?php

use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mantenimientos */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlTrabajos = Yii::$app->urlManager->createUrl('trabajos/trabajos-list');
$urlTiposMantenimientos = Yii::$app->urlManager->createUrl('tipos-mantenimientos/tipos-mantenimientos-list');
?>

<div class="mantenimientos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un vehiculo...',
                                'id' => 'select-placa'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlVehiculos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['vehiculos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-briefcase" aria-hidden="true"></i> Trabajo
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'trabajo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->trabajo_id) ? [$model->trabajo_id => Trabajos::findOne($model->trabajo_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un trabajo...',
                                'id' => 'select-trabajo'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTrabajos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['trabajos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un trabajo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo de mantenimiento
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'tipo_mantenimiento_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_mantenimiento_id) ? [$model->tipo_mantenimiento_id => TiposMantenimientos::findOne($model->tipo_mantenimiento_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un tipo de mantenimiento...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposMantenimientos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['tipos-mantenimientos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de mantenimiento" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Medicion Actual
                </label><br>
                <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>

                <?= $form->field($model, 'medicion')->textInput([
                    'id' => 'campo-medicion', 'class' => 'hidden'
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-spinner" aria-hidden="true"></i> Medicion de ejecucion
                </label>
                <?= $form->field($model, 'medicion_ejecucion')->textInput([
                    'id' => 'campo-medicion-ejecucion', 'type' => 'number'
                ])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora de ejecucion
                </label>
                <?= $form->field($model, 'fecha_hora_ejecucion')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora ejecucion ...', 'id' => 'campo-fecha'],
                    'pluginOptions' => [
                        'startDate' => date('Y-m-d H:i'),
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-repeat" aria-hidden="true"></i> Duracion
                </label><br>
                <input class="form-control" readOnly="true" id='campo-duracion-mostrar'>

                <?= $form->field($model, 'duracion')->textInput([
                    'id' => 'campo-duracion', 'class' => 'hidden'
                ])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Descripcion
                </label>
                <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true])->label(false) ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['mantenimientos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();

    $this->registerJsFile(
        '@web/js/mantenimientoWebService.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    $this->registerJsFile(
        '@web/js/mantenimiento.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    ?>



</div>
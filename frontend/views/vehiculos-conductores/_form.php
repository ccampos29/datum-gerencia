<?php

use common\models\User;
use frontend\models\Vehiculos;
use frontend\models\VehiculosConductores;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosConductores */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$urlConductores = Url::to(['user/conductores-list']);
!empty($_GET['idv']) ? $placa = Vehiculos::findOne($_GET['idv']) : $placa = 0;

?>

<div class="vehiculos-conductores-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <?php
            if ($placa != null) { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>
                        <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                    </label>
                    <input class="form-control" readOnly="true" value=<?= $placa->placa; ?>>
                    </input>
                    <?= $form->field($model, 'vehiculo_id')->textInput([
                            'value' => $placa->id,
                            'class' => 'hidden',
                        ])->label(false) ?>
                </div>
            <?php
            } else { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
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
                            <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Conductor elegido
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'conductor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->conductor_id) ? [$model->conductor_id => User::findOne($model->conductor_id)->name] : [],
                            'options' => ['placeholder' => 'Seleccione un conductor... ',],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlConductores,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-otros-documentos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un documento" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha desde
                </label>
                
                <?= $form->field($model, 'fecha_desde')->widget(DatePicker::classname(), [
                    'name' => 'fecha_desde',
                    'options' => ['placeholder' => 'Selecciona la fecha desde que incia el conductor'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha hasta
                </label>
               
                <?= $form->field($model, 'fecha_hasta')->widget(DatePicker::classname(), [
                    'name' => 'fecha_hasta',
                    'options' => ['placeholder' => 'Selecciona la fecha hasta que esta el conductor'],
                    'pluginOptions' => [
                        'orientation' => 'bottom',
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hourglass-half" aria-hidden="true"></i> Dias para alertar
                </label>
                <?= $form->field($model, 'dias_alerta')->textInput(['type'=>'number'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-check" aria-hidden="true"></i> ¿Es conductor principal?
                </label>
                <?= $form->field($model, 'principal')->dropDownList([ '0' => 'No es principal', '1' => 'Principal' ], ['prompt' => 'Seleccione un estado'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-check" aria-hidden="true"></i> Estado
                </label>
                <?= $form->field($model, 'estado')->dropDownList([ '0' => 'Inactivo', '1' => 'Activo' ], ['prompt' => 'Seleccione un estado'])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-conductores/index', 'idv' => $_GET['idv']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\widgets\TimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Combustibles;
use frontend\models\Proveedores;
use frontend\models\User;
use frontend\models\CentrosCostos;
use frontend\models\Vehiculos;
use frontend\models\GruposVehiculos;
use yii\web\JsExpression;
use yii\helpers\Url;


$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/conductores-asignados-list');
?>

<div class="mediciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <?php if (empty($_GET['idSec'])) { ?>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                    </label>
                    <div class="row">
                        <div class="col-xs-10">
                            <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                                    'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                                    'options' => ['id' => 'select-placa', 'placeholder' => 'Selecciona una placa de un vehiculo'],
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
                                ])->label(false)
                                ?>
                        </div>
                        <div class="col-xs-2">
                            <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion
                    </label>
                    <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                    </input>
                    <?= $form->field($model, 'valor_medicion')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-medicion'
                        ])->label(false) ?>
                    <?= $form->field($model, 'medicion')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-medicion-compare'
                        ])->label(false) ?>
                </div>
                <?php } else { ?>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>
                            <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                        </label>
                        <div class="row">
                            <div class="col-xs-10">
                                <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                                        'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                                        'options' => ['id' => 'select-placa', 'placeholder' => 'Selecciona una placa de un vehiculo'],
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
                                    ])->label(false)
                                    ?>
                            </div>
                            <div class="col-xs-2">
                                <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion
                        </label>

                        <?= $form->field($model, 'valor_medicion')->textInput([
                                //'class' => 'hidden',
                                //'id' => 'campo-medicion'
                                'type' => 'number'
                            ])->label(false) ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion web Service
                        </label>
                        <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                        </input>
                        <?= $form->field($model, 'medicion')->textInput([
                                'class' => 'hidden',
                                'id' => 'campo-medicion'
                            ])->label(false) ?>
                    
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-calendar" aria-hidden="true"></i> Fecha de la medicion
                        </label>
                        <input class="form-control" readOnly="true" id='campo-fecha-mostrar'>
                        </input>
                        <?= $form->field($model, 'fecha_medicion')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-fecha'
                        ])->label(false) ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-clock-o" aria-hidden="true"></i> Hora de la medicion
                        </label>
                        <input class="form-control" readOnly="true" id='campo-hora-mostrar'>
                        </input>
                        <?= $form->field($model, 'hora_medicion')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-hora'
                        ])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-power-off" aria-hidden="true"></i> Estado del vehiculo
                        </label>
                        <input class="form-control" readOnly="true" id='campo-nevento-mostrar'>
                        </input>
                        <?= $form->field($model, 'estado_vehiculo')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-nevento'
                        ])->label(false) ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-tachometer" aria-hidden="true"></i> Tipo de la Medicion
                        </label>
                        <input class="form-control" readOnly="true" id='campo-tipo-mostrar'>
                        </input>
                        <?= $form->field($model, 'tipo_medicion')->textInput([
                            'class' => 'hidden',
                            'id' => 'campo-tipo'
                        ])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-battery-full" aria-hidden="true"></i> Fuente de la medicion
                        </label>
                        <?php if(empty($_GET['idSec'])){
                            echo $form->field($model, 'proviene_de')->textInput(['readonly'=>true, 'value'=>'Web Service'])->label(false);
                        }else {
                            echo $form->field($model, 'proviene_de')->textInput(['readonly'=>true, 'value'=>'Manual'])->label(false);
                        }?>
                        
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label>
                            <i class="fa fa-user" aria-hidden="true"></i> Conductor
                        </label>
                        <div class="row">
                            <div class="col-xs-10">
                                <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                                    'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
                                    'options' => ['placeholder' => 'Seleccione un conductor',],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 0,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => $urlUsuarios,
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term, vehiculo_id: $("#select-placa").val() }; }')
                                        ],
                                    ]
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-xs-2">
                                <a href="../user/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un conductor" target="_blank"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <label>
                            <i class="fa fa-font" aria-hidden="true"></i> Observacion
                        </label>
                        <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
                    </div>
                </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['mediciones/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end();

        $this->registerJsFile(
            '@web/js/medicionesWebService.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );
        ?>

    </div>
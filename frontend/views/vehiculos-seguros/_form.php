<?php

use frontend\models\Vehiculos;
use frontend\models\TiposSeguros;
use frontend\models\Proveedores;
use frontend\models\CentrosCostos;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSeguros */
/* @var $form yii\widgets\ActiveForm */

$urlTiposSeguros = Url::to(['tipos-seguros/tipos-seguros-list']);
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$urlProveedores = Url::to(['proveedores/proveedores-list']);
$urlCentrosCostos = Url::to(['centros-costos/centros-costos-list']);
!empty($_GET['idv']) ? $placa = Vehiculos::findOne($_GET['idv']) : $placa = 0;
?>

<div class="vehiculos-seguros-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid col-12">
        
        <div class="row">
            <?php
            if ($placa != null) { ?>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <label>
                        <i class="fa fa-bank" aria-hidden="true"></i> Vehiculo
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
                        <i class="fa fa-bank" aria-hidden="true"></i> Vehiculo
                    </label>
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                                    'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                                    'options' => ['placeholder' => 'Seleccione un vehiculo',],

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
                                ])->label(false) ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-bank" aria-hidden="true"></i> Tipo de seguro
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'tipo_seguro_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_seguro_id) ? [$model->tipo_seguro_id => TiposSeguros::findOne($model->tipo_seguro_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un tipo de seguro',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposSeguros,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false);
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-seguros/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de seguro" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Valor del seguro
                </label>
                <?= $form->field($model, 'valor_seguro')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Numero de poliza
                </label>
                <?= $form->field($model, 'numero_poliza')->textInput([
                    'type' => 'number'
                ])->label(false) ?>
            </div>
        </div>
        <hr>
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hourglass-start" aria-hidden="true"></i> Fecha de expedicion del seguro
                </label>
                <?= $form->field($model, 'fecha_expedicion')->widget(DatePicker::classname(), [
                    'name' => 'fecha_expedicion',
                    'options' => ['placeholder' => 'Selecciona la fecha de expedicion del seguro'],

                    'pluginOptions' => [
                        
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

                <label>
                    <i class="fa fa-hourglass-half" aria-hidden="true"></i> Fecha de vigencia
                </label>
                <?= $form->field($model, 'fecha_vigencia')->widget(DatePicker::classname(), [
                    'name' => 'fecha_expiracion',
                    'options' => ['placeholder' => 'Selecciona la fecha de vigencia del seguro'],

                    'pluginOptions' => [
                        
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

                <label>
                    <i class="fa fa-hourglass-end" aria-hidden="true"></i> Fecha de expiracion
                </label>
                <?= $form->field($model, 'fecha_expiracion')->widget(DatePicker::classname(), [
                    'name' => 'fecha_expiracion',
                    'options' => ['placeholder' => 'Selecciona la fecha de expiracion del seguro'],
                    'pluginOptions' => [
                        
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
        </div>
        <hr>
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-industry" aria-hidden="true"></i> Selecciona un proveedor
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un proveedor',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlProveedores,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../proveedores/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-building" aria-hidden="true"></i> Centro de costos
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un centro de costos',],

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
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-seguros/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
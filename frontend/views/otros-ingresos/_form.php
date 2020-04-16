<?php

use frontend\models\Clientes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Vehiculos;
use frontend\models\TiposIngresos;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\number\NumberControl;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosIngresos */
/* @var $form yii\widgets\ActiveForm */
$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlTiposIngresos = Yii::$app->urlManager->createUrl('tipos-ingresos/tipos-ingresos-list');
$urlClientes = Yii::$app->urlManager->createUrl('clientes/clientes-list');
?>

<div class="otros-ingresos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Valor Ingreso 
                </label>
                <?= $form->field($model, 'valor_ingreso')->widget(NumberControl::classname(), [
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
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                                'options' => ['placeholder' => 'Seleccione una placa de un vehiculo',],
                                
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
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-bank" aria-hidden="true"></i> Tipo del ingreso 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'tipo_ingreso_id')->widget(Select2::classname(), [
                                'data' => !empty($model->tipo_ingreso_id) ? [$model->tipo_ingreso_id => TiposIngresos::findOne($model->tipo_ingreso_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un tipo de ingreso',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlTiposIngresos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                    ?>
                    </div>
                        <div class="col-xs-2">
                            <a href="../tipos-ingresos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de ingreso" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del ingreso 
                </label>
                <?= $form->field($model, 'fecha')->widget(DatePicker::classname(),[
                    'name' => 'fecha',
                    'options' => ['placeholder' => 'Selecciona la fecha del ingreso'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'endDate' => date('Y-m-d'),
                        'autoclose' => true,
                    ]
                ])->label(false)?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre del cliente 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'cliente_id')->widget(Select2::classname(), [
                                'data' => !empty($model->cliente_id) ? [$model->cliente_id => Clientes::findOne($model->cliente_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un cliente',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlClientes,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false) ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../clientes/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un cliente" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i>  Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea()->label(false)?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['otros-ingresos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

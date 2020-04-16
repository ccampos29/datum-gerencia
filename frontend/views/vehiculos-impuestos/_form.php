<?php

use frontend\models\Vehiculos;
use frontend\models\TiposImpuestos;
use frontend\models\CentrosCostos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\number\NumberControl;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestos */
/* @var $form yii\widgets\ActiveForm */
$urlTiposImpuestos = Yii::$app->urlManager->createUrl('tipos-impuestos/tipos-impuestos-list');
$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlCentrosCostos = Yii::$app->urlManager->createUrl('centros-costos/centros-costos-list');
!empty($_GET['idv']) ? $placa = Vehiculos::findOne($_GET['idv']) : $placa=0;

?>

<div class="vehiculos-impuestos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <?php 
            if($placa!=null){?>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-bank" aria-hidden="true"></i> Vehiculo 
                </label>
                <input class = "form-control" readOnly = "true" value=<?= $placa->placa;?> >
                </input>
                <?= $form->field($model, 'vehiculo_id')->textInput([
                    'value' => $placa->id,
                            'class' => 'hidden',
                        ])->label(false) ?>
                    </div>
                <?php
                }else{?>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label>
                        <i class="fa fa-bank" aria-hidden="true"></i> Vehiculo  
                    </label>
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
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
                                ])->label(false) ?>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>
                    </div>
               <?php }?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-bank" aria-hidden="true"></i> Tipo de impuesto  
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'tipo_impuesto_id')->widget(Select2::classname(), [
                                'data' => !empty($model->tipo_impuesto_id) ? [$model->tipo_impuesto_id => TiposImpuestos::findOne($model->tipo_impuesto_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione una placa de un vehiculo',],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlTiposImpuestos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                    ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-impuestos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de impuesto" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Valor del impuesto  
                </label>
                <?= $form->field($model, 'valor_impuesto')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?> 
            </div>
        </div>
        <hr>
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-building" aria-hidden="true"></i> Centro de costo  
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione una placa de un vehiculo',],
                                
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
                <i class="fa fa-hourglass-start" aria-hidden="true"></i> Fecha de expedicion del impuesto 
            </label>
            <?= $form->field($model, 'fecha_expedicion')->widget(DatePicker::classname(),[
            'name' => 'fecha_expedicion',
            'options' => ['placeholder' => 'Selecciona la fecha de expedicion del seguro'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true
            ]
        ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-hourglass-end" aria-hidden="true"></i> Fecha de expiracion del impuesto  
            </label>
            <?= $form->field($model, 'fecha_expiracion')->widget(DatePicker::classname(),[
            'name' => 'fecha_expiracion',
            'options' => ['placeholder' => 'Selecciona la fecha de expiracion del seguro'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true
            ]
        ])->label(false) ?> 
        </div>
    </div>
    <hr>
     <div class="row">
        <div class="col-12">
            <label>
                <i class="fa fa-font" aria-hidden="true"></i> descripcion
            </label>
            <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-impuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

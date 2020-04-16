<?php

use frontend\models\Repuestos;
use frontend\models\UbicacionesInsumos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Traslados */
/* @var $form yii\widgets\ActiveForm */

$urlUbicaciones = Yii::$app->urlManager->createUrl('ubicaciones-insumos/ubicaciones-insumos-list');
$urlRepuestos = Yii::$app->urlManager->createUrl('repuestos/repuestos-list');
?>

<div class="traslados-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Ubicacion Origen
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'ubicacion_origen_id')->widget(Select2::classname(), [
                            'data' => !empty($model->ubicacion_origen_id) ? [$model->ubicacion_origen_id => UbicacionesInsumos::findOne($model->ubicacion_origen_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione una ubicacion...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUbicaciones,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['ubicaciones-insumos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una ubicacion" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-gear" aria-hidden="true"></i> Repuesto
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'repuesto_id')->widget(Select2::classname(), [
                            'data' => !empty($model->repuesto_id) ? [$model->repuesto_id => Repuestos::findOne($model->repuesto_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un repuesto...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlRepuestos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['repuestos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un repuesto" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Ubicacion Destino
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'ubicacion_destino_id')->widget(Select2::classname(), [
                            'data' => !empty($model->ubicacion_destino_id) ? [$model->ubicacion_destino_id => UbicacionesInsumos::findOne($model->ubicacion_destino_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione una ubicacion...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUbicaciones,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['ubicaciones-insumos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una ubicacion" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-list-ol" aria-hidden="true"></i> Cantidad
                </label>
                <?= $form->field($model, 'cantidad')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha Traslado
                </label>
                <?= $form->field($model, 'fecha_traslado')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha de la solucion ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'orientation' => 'bottom',

                    ]
                ])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 3])->label(false) ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['traslados/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
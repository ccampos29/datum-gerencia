<?php

use frontend\models\Repuestos;
use frontend\models\TiposVehiculos;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropiedadesTrabajos */
/* @var $form yii\widgets\ActiveForm */

$urlTiposVehiculos = Yii::$app->urlManager->createUrl('tipos-vehiculos/tipos-vehiculos-list');
$urlRepuestos = Yii::$app->urlManager->createUrl('repuestos/repuestos-list');
?>

<div class="propiedades-trabajos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo de Vehiculo
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'tipo_vehiculo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_vehiculo_id) ? [$model->tipo_vehiculo_id => TiposVehiculos::findOne($model->tipo_vehiculo_id)->descripcion] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un tipo...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposVehiculos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['tipos-vehiculos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una unidad de medida" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-clock-o" aria-hidden="true"></i> Duración
                </label>
                <?= $form->field($model, 'duracion')->textInput(['type' => 'number', 'min' => 0])->label(false); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Costo mano de Obra
                </label>
                <?= $form->field($model, 'costo_mano_obra')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad Trabajo
                </label>
                <?= $form->field($model, 'cantidad_trabajo')->textInput(['type' => 'number', 'min' => 0])->label(false); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Repuesto
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
                        <a href="<?= Url::to(['repuestos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una unidad de medida" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad Repuesto
                </label>
                <?= $form->field($model, 'cantidad_repuesto')->textInput(['type' => 'number', 'min' => 0])->label(false); ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['propiedades-trabajos/index?idTrabajo='. $idTrabajo]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

</div>

<?php ActiveForm::end(); ?>

</div>
<?php

use frontend\models\Repuestos;
use frontend\models\UbicacionesInsumos;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosInventariables */
/* @var $form yii\widgets\ActiveForm */

$urlUbicaciones = Yii::$app->urlManager->createUrl('ubicaciones-insumos/ubicaciones-insumos-list');
?>

<div class="repuestos-inventariables-form">

    <?php $form = ActiveForm::begin();
    $repuesto = Repuestos::findOne($idRepuesto); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Repuesto
                </label>
                <input class="form-control" readOnly="true" id="repuesto-mostrar">
                <?= $form->field($model, 'repuesto_id')->textInput(['id' => $repuesto->nombre, 'class' => 'hidden repuesto', 'value' => $repuesto->id])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Ubicacion
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'ubicacion_id')->widget(Select2::classname(), [
                            'data' => !empty($model->ubicacion_id) ? [$model->ubicacion_id => UbicacionesInsumos::findOne($model->ubicacion_id)->nombre] : [],
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
                        <a href="<?= Url::to(['ubicaciones-insumos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad
                </label>
                <?= $form->field($model, 'cantidad')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Valor Unitario
                </label>
                <?= $form->field($model, 'valor_unitario')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad Minima
                </label>
                <?= $form->field($model, 'cantidad_minima')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad Maxima
                </label>
                <?= $form->field($model, 'cantidad_maxima')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['repuestos-inventariables/index?idRepuesto=' . $idRepuesto]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/repuestosInventariables.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
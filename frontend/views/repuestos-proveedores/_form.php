<?php

use frontend\models\Proveedores;
use frontend\models\Repuestos;
use frontend\models\TiposImpuestos;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosProveedores */
/* @var $form yii\widgets\ActiveForm */

$urlProveedores = Yii::$app->urlManager->createUrl('proveedores/proveedores-list');
$urlImpuestos = Yii::$app->urlManager->createUrl('tipos-impuestos/tipos-impuestos-list');
?>

<div class="repuestos-proveedores-form">

    <?php $form = ActiveForm::begin();
    $repuesto = Repuestos::findOne($idRepuesto); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Repuesto
                </label>
                <input class="form-control" readOnly="true" id="repuesto-mostrar">
                <?= $form->field($model, 'repuesto_id')->textInput(['id' => 'repuesto', 'class' => 'hidden', 'value' => $repuesto->nombre])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Proveedor
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un proveedor...'
                            ],
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
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['proveedores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Valor Unitario
                </label>
                <?= $form->field($model, 'valor')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> Impuesto
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'impuesto_id')->widget(Select2::classname(), [
                            'data' => !empty($model->impuesto_id) ? [$model->impuesto_id => TiposImpuestos::findOne($model->impuesto_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un impuesto...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlImpuestos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['proveedores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Descuento Unitario
                </label>
                <?= $form->field($model, 'descuento_repuesto')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo descuento
                </label>
                <?= $form->field($model, 'tipo_descuento')->widget(Select2::classname(), [
                    'data'  => [1 => '%', 2 => '$'],
                    'options' => ['placeholder' => 'Seleccione un tipo ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-barcode" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Plazo de Pago(dias)
                </label>
                <?= $form->field($model, 'plazo_pago')->widget(NumberControl::classname(), [
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
                <a class="btn btn-default" href="<?= Url::to(['repuestos-proveedores/index?idRepuesto=' . $idRepuesto]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/repuestosProveedores.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
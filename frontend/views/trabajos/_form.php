<?php

use frontend\models\CuentasContables;
use frontend\models\Repuestos;
use frontend\models\Subsistemas;
use frontend\models\Sistemas;
use frontend\models\TiposMantenimientos;
use frontend\models\TiposVehiculos;
use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use unclead\multipleinput\MultipleInput;

use kartik\depdrop\DepDrop;

use yii\helpers\Url;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Trabajos */
/* @var $form yii\widgets\ActiveForm */

$urlSistemas = Yii::$app->urlManager->createUrl('sistemas/sistemas-list');
$urlTiposMantenimientos = Yii::$app->urlManager->createUrl('tipos-mantenimientos/tipos-mantenimientos-list');
$urlCuentasContables = Yii::$app->urlManager->createUrl('cuentas-contables/cuentas-contables-list');
?>

<div class="trabajos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo de Mantenimiento
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
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cogs" aria-hidden="true"></i> Sistema
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'sistema_id')->widget(Select2::classname(), [
                            'data' => !empty($model->sistema_id) ? [$model->sistema_id => Sistemas::findOne($model->sistema_id)->nombre] : [],
                            'options' => [
                                'id' => 'idSistemas',
                                'placeholder' => 'Seleccione un Sistema...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlSistemas,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['sistemas/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un sistema" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Subsistema
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'subsistema_id')->widget(DepDrop::classname(), [
                            'data' => $model->isNewRecord ? []:[$model->subsistema->id => $model->subsistema->nombre],
                            'options' => ['id' => 'idSubsistema'],
                            'pluginOptions' => [
                                'depends' => ['idSistemas'],
                                'initDepends' => ['idSistemas'],
                                'placeholder' => 'Select...',
                                'url' => Url::to(['/sistemas/subsistemas'])
                            ]
                        ])->label(false) ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['subsistemas/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un subsistema" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Cuenta contable
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'cuenta_contable_id')->widget(Select2::classname(), [
                            'data' => !empty($model->cuenta_contable_id) ? [$model->cuenta_contable_id => CuentasContables::findOne($model->cuenta_contable_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione una cuenta contable...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlCuentasContables,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['cuentas-contables/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una cuenta contable" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-barcode" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Estado
                </label>
                <?= $form->field($model, 'estado')->widget(Select2::classname(), [
                    'data' => [1 => 'Activo', 0 => 'Inactivo'],
                    'options' => ['placeholder' => 'Estado ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 4])->label(false) ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    
    $this->registerJsFile(
        '@web/js/trabajos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
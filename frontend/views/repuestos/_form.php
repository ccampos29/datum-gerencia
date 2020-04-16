<?php

use frontend\models\CuentasContables;
use frontend\models\GruposInsumos;
use frontend\models\Proveedores;
use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\TiposImpuestos;
use frontend\models\UbicacionesInsumos;
use frontend\models\UnidadesMedidas;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use kartik\depdrop\DepDrop;

use yii\helpers\Url;

use unclead\multipleinput\MultipleInput;

use kartik\number\NumberControl;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Repuestos */
/* @var $form yii\widgets\ActiveForm */

$urlUnidadesMedidas = Yii::$app->urlManager->createUrl('unidades-medidas/unidades-medidas-list');
$urlSistemas = Yii::$app->urlManager->createUrl('sistemas/sistemas-list');
$urlGruposRepuestos = Yii::$app->urlManager->createUrl('grupos-insumos/grupos-insumos-list');
$urlCuentasContables = Yii::$app->urlManager->createUrl('cuentas-contables/cuentas-contables-list');
?>
<!--TabsX::widget([
        /*'items' => [
            [
                'label' => 'Repuestos',
                'content' => $this->render('forms/formDatosBasicos', ['model' => $model, 'form' => $form]),
                'active' => true
            ],
            [
                'label' => 'Proveedores',
                'content' => $this->render('forms/formProveedores', ['model' => $model, 'form' => $form]),
            ]
        ]
    ]);-->

<div class="repuestos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-list" aria-hidden="true"></i> Unidad de medida
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'unidad_medida_id')->widget(Select2::classname(), [
                            'data' => !empty($model->unidad_medida_id) ? [$model->unidad_medida_id => UnidadesMedidas::findOne($model->unidad_medida_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione una unidad de medida...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUnidadesMedidas,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['unidades-medidas/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una unidad de medida" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-barcode" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-address-card" aria-hidden="true"></i> Fabricante
                </label>
                <?= $form->field($model, 'fabricante')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Precio
                </label>
                <?= $form->field($model, 'precio')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>
                    <i class="fa fa-check-square" aria-hidden="true"></i> Inventariable
                </label>
                <?= $form->field($model, 'inventariable')->widget(Select2::classname(), [
                    'data' => ['1' => 'Si', '0' => 'No'],
                    'options' => ['placeholder' => 'Si / No', 'id' => 'inventariable'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Estado
                </label>
                <?= $form->field($model, 'estado')->widget(Select2::classname(), [
                    'data' => ['1' => 'Activo', '0' => 'Inactivo'],
                    'options' => ['placeholder' => 'Estado...'],
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

        <hr>
        <a data-toggle="collapse" href="#datosAgrupacion" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Datos de agrupacion </label>
        </a>
        <hr>

        <div id="datosAgrupacion" class="collapse">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-hashtag" aria-hidden="true"></i> Grupo del repuesto
                    </label>
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'grupo_repuesto_id')->widget(Select2::classname(), [
                                'data' => !empty($model->grupo_repuesto_id) ? [$model->grupo_repuesto_id => GruposInsumos::findOne($model->grupo_repuesto_id)->nombre] : [],
                                'options' => [
                                    'placeholder' => 'Seleccione un grupo de repuesto...'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlGruposRepuestos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false); ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="<?= Url::to(['grupos-insumos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
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
                                'options' => ['id' => 'idSubsistema'],
                                'pluginOptions' => [
                                    'depends' => ['idSistemas'],
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
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['repuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();?>

</div>
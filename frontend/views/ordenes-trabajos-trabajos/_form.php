<?php

use frontend\models\OrdenesTrabajos;
use frontend\models\Trabajos;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosTrabajos */
/* @var $form yii\widgets\ActiveForm */

$urlTrabajos = Yii::$app->urlManager->createUrl('trabajos/trabajos-list');
$urlTiposMantenimientos = Yii::$app->urlManager->createUrl('tipos-mantenimientos/tipos-mantenimientos-list');
?>

<div class="ordenes-trabajos-trabajos-form">

    <?php $form = ActiveForm::begin();
    $orden = OrdenesTrabajos::findOne($idOrden); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Orden N°
                </label>
                <input class="form-control" readOnly="true" id="orden-mostrar">
                <input class="<?= $orden->vehiculo_id ?>" readOnly="true" id="vehiculo" type="hidden">
                <?= $form->field($model, 'orden_trabajo_id')->textInput(['id' => $orden->consecutivo, 'class' => 'hidden orden', 'value' => $orden->id])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-briefcase" aria-hidden="true"></i> Trabajo
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'trabajo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->trabajo_id) ? [$model->trabajo_id => Trabajos::findOne($model->trabajo_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un trabajo...',
                                'id' => 'select-trabajo'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTrabajos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['trabajos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo Mantenimiento
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'tipo_mantenimiento_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_mantenimiento_id) ? [$model->tipo_mantenimiento_id => Trabajos::findOne($model->tipo_mantenimiento_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un trabajo...',
                                'id' => 'tipoMantenimiento'
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
                        <a href="<?= Url::to(['tipos-mantenimientos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Costo Mano de Obra
                </label>
                <?= $form->field($model, 'costo_mano_obra')->textInput(['id' => 'manoObra'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-list-ol" aria-hidden="true"></i> Cantidad
                </label>
                <?= $form->field($model, 'cantidad')->textInput(['id' => 'cantidad'])->label(false) ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos-trabajos/index?idOrden=' . $idOrden]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();

    $this->registerJsFile(
        '@web/js/ordenesTrabajosTrabajos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
<?php

use frontend\models\OrdenesTrabajos;
use frontend\models\Proveedores;
use frontend\models\Repuestos;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosRepuestos */
/* @var $form yii\widgets\ActiveForm */

$urlRepuestos = Yii::$app->urlManager->createUrl('repuestos/repuestos-list');
?>

<div class="ordenes-trabajos-repuestos-form">

    <?php $form = ActiveForm::begin();
    $orden = OrdenesTrabajos::findOne($idOrden);
    $proveedor = Proveedores::findOne($orden->proveedor_id); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Orden N°
                </label>
                <input class="form-control" readOnly="true" id="orden-mostrar">
                <?= $form->field($model, 'orden_trabajo_id')->textInput(['id' => $orden->consecutivo, 'class' => 'hidden orden', 'value' => $orden->id])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Proveedor
                </label>
                <input class="form-control" readOnly="true" id="proveedor-mostrar">
                <?= $form->field($model, 'proveedor_id')->textInput(['id' => $proveedor->nombre, 'class' => 'hidden proveedor', 'value' => $proveedor->id])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Repuesto
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'repuesto_id')->widget(Select2::classname(), [
                            'data' => !empty($model->repuesto_id) ? [$model->repuesto_id => Repuestos::findOne($model->repuesto_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un repuesto...',
                                'id' => 'select-repuesto'
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
                        <a href="<?= Url::to(['repuestos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Costo Unitario
                </label>
                <?= $form->field($model, 'costo_unitario')->textInput(['id' => 'costo'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad
                </label>
                <?= $form->field($model, 'cantidad')->textInput(['id' => 'cantidad'])->label(false) ?>
            </div>
        </div>


        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos-repuestos/index?idOrden=' . $idOrden]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/ordenesTrabajosRepuestos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
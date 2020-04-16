<?php

use frontend\models\LineasMarcas;
use frontend\models\MarcasMotores;
use frontend\models\MarcasVehiculos;
use frontend\models\TiposPeriodicidades;
use frontend\models\TiposVehiculos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesTrabajos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodicidades-trabajos-form">

    <?php $form = ActiveForm::begin();
    if($model->isNewRecord){
    $trabajo = Trabajos::findOne($idTrabajo);
    }
    else {
        $trabajo = Trabajos::findOne($model->trabajo_id);
    } ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-briefcase" aria-hidden="true"></i> Trabajo
                </label>
                <input class="form-control" readOnly="true" id="trabajo-mostrar">
                <?= $form->field($model, 'trabajo_id')->textInput(['id' => 'trabajo', 'class' => 'hidden', 'value' => $trabajo->nombre])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-list" aria-hidden="true"></i> Unidad de Periodicidad
                </label>
                <?= $form->field($model, 'unidad_periodicidad')->widget(Select2::classname(), [
                    'data'  => ['Kilometros' => 'Km', 'Dias' => 'Dias', 'Horas' => 'Horas'],
                    'options' => ['placeholder' => 'Seleccione una Unidad ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hourglass-half" aria-hidden="true"></i> Trabajo Normal
                </label>
                <?= $form->field($model, 'trabajo_normal')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hourglass-o" aria-hidden="true"></i> Trabajo Bajo
                </label>
                <?= $form->field($model, 'trabajo_bajo')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4  ">
                <label>
                    <i class="fa fa-hourglass" aria-hidden="true"></i> Trabajo Severo
                </label>
                <?= $form->field($model, 'trabajo_severo')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-hourglass-half" aria-hidden="true"></i> Tipo de Periodicidad
                </label>
                <?= $form->field($model, 'tipo_periodicidad')->widget(Select2::classname(), [
                    'data'  => [1 => 'Por Vehiculo', 2 => 'Por linea de Vehiculo', 3 => 'Por tipo de Vehiculo y tipo de Motor', 4 => 'Por tipo de Vehiculo', 5 => 'Por tipo de Motor'],
                    'options' => ['placeholder' => 'Seleccione un Tipo ...', 'id' => 'tipoPeriodicidad'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 1">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                    'data'  => ArrayHelper::map(Vehiculos::find()->all(), 'id', 'placa'),
                    'options' => ['placeholder' => 'Seleccione un Vehiculo ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 2">
                <label>
                    <i class="fa fa-tag" aria-hidden="true"></i> Marca Vehiculo
                </label>
                <?= $form->field($model, 'tipos[marcaVehiculo]')->widget(Select2::classname(), [
                    'data'  => ArrayHelper::map(MarcasVehiculos::find()->all(), 'id', 'descripcion'),
                    'options' => ['placeholder' => 'Seleccione una Marca ...', 'id' => 'idMarcas'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 2">
                <label>
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Linea Vehiculo
                </label>
                <?= $form->field($model, 'tipos[lineaMarca]')->widget(DepDrop::classname(), [
                    'options' => ['id' => 'idLineas'],
                    'pluginOptions' => [
                        'depends' => ['idMarcas'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['/marcas-vehiculos/lineas'])
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 5 tipo 3">
                <label>
                    <i class="fa fa-cog" aria-hidden="true"></i> Marca Motor
                </label>
                <?= $form->field($model, 'tipos[marcaMotor]')->widget(Select2::classname(), [
                    'data'  => ArrayHelper::map(MarcasMotores::find()->all(), 'id', 'nombre'),
                    'options' => ['placeholder' => 'Seleccione una Marca ...', 'id' => 'idMotor'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 5 tipo 3">
                <label>
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Linea Motor
                </label>
                <?= $form->field($model, 'tipos[lineaMotor]')->widget(DepDrop::classname(), [
                    'options' => ['id' => 'idLineaMotor'],
                    'pluginOptions' => [
                        'depends' => ['idMotor'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['/marcas-motores/lineas'])
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 tipo 4 tipo 3">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo de Vehiculo
                </label>
                <?= $form->field($model, 'tipos[tipoVehiculo]')->widget(Select2::classname(), [
                    'data'  => ArrayHelper::map(TiposVehiculos::find()->all(), 'id', 'descripcion'),
                    'options' => ['placeholder' => 'Seleccione un tipo ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['periodicidades-trabajos/index?idTrabajo=' . $idTrabajo]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/periodicidadTrabajo.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
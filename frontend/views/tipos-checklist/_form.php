<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\TiposVehiculos;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposChecklist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-checklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Tipo del vehiculo
                </label>
                <?php
               
                echo $form->field($model, 'tipo_vehiculo_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TiposVehiculos::find()->all(), 'id', 'descripcion'),
                    'options' => ['placeholder' => 'Selecciona un vehiculo', 'id' => 'select-placa','multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo del checklist
                </label>
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Periodicidad:</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Días
                </label>
                <?= $form->field($model, 'dias')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Horas
                </label>
                <?= $form->field($model, 'horas')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Odómetro
                </label>
                <?= $form->field($model, 'odometro')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id . '/']), ['class' => 'btn btn-default']); ?>
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
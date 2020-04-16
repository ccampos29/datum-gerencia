<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposVehiculos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-vehiculos-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <i class="fa fa-laptop" aria-hidden="true"></i> <label>Descripción</label>
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true])->label(false) ?></div>
        <div class="col-sm-4">
        <i class="fa fa-barcode" aria-hidden="true"></i> <label>Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?></div>
        <div class="col-sm-4">
        <i class="fa fa-calendar" aria-hidden="true"></i> <label>Clase</label>
            <?= $form->field($model, 'clase')->dropDownList([ 'Pesado' => 'Pesado', 'Liviano' => 'Liviano', 'De carga' => 'De carga', ], ['prompt' => ''])->label(false) ?></div>
        <div class="col-sm-12">
        <i class="fa fa-comment" aria-hidden="true"></i> <label>Promedio Recorrido por Dia</label>
            <?= $form->field($model, 'promedio_recorrido_dia')->textInput(['type'=>'number'])->label(false) ?></div>
    </div>

    <div class="form-group">
        <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

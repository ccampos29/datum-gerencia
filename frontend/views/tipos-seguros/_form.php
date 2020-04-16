<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposSeguros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-seguros-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <i class="fa fa-laptop" aria-hidden="true"></i> <label>Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?></div>
        <div class="col-sm-4">
        <i class="fa fa-barcode" aria-hidden="true"></i> <label>Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?></div>
        <div class="col-sm-4">
        <i class="fa fa-calendar" aria-hidden="true"></i> <label>Días de alerta</label>
            <?= $form->field($model, 'dias_alerta')->textInput()->label(false) ?></div>
        <div class="col-sm-12">
        <i class="fa fa-comment" aria-hidden="true"></i> <label>Descripción</label>
            <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label(false) ?></div>
    </div>
    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

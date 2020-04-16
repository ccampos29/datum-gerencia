<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccionesTrabajos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acciones-trabajos-form">

    <?php $form = ActiveForm::begin(); ?>

    <label for="tipo_documento_id"><i class="fa fa-info" aria-hidden="true"></i> Nombre</label>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>

 

    <div class="form-group">
    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

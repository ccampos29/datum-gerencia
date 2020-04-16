<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MotoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="motores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'marca_motor_id') ?>

    <?= $form->field($model, 'linea_motor_id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'potencia') ?>

    <?php // echo $form->field($model, 'torque') ?>

    <?php // echo $form->field($model, 'rpm') ?>

    <?php // echo $form->field($model, 'cilindraje') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'creado_el') ?>

    <?php // echo $form->field($model, 'actualizado_por') ?>

    <?php // echo $form->field($model, 'actualizado_el') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

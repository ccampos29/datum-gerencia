<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TrabajosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'observacion') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'tipo_mantenimiento_id') ?>

    <?php // echo $form->field($model, 'sistema_id') ?>

    <?php // echo $form->field($model, 'subsistema_id') ?>

    <?php // echo $form->field($model, 'cuenta_contable_id') ?>

    <?php // echo $form->field($model, 'periodico') ?>

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

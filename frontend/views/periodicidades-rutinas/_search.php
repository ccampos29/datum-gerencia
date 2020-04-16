<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesRutinasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodicidades-rutinas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vehiculo_id') ?>

    <?= $form->field($model, 'rutina_id') ?>

    <?= $form->field($model, 'unidad_periodicidad') ?>

    <?= $form->field($model, 'trabajo_normal') ?>

    <?php // echo $form->field($model, 'trabajo_bajo') ?>

    <?php // echo $form->field($model, 'trabajo_severo') ?>

    <?php // echo $form->field($model, 'tipo_periodicidad_id') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'creado_el') ?>

    <?php // echo $form->field($model, 'actualizado_por') ?>

    <?php // echo $form->field($model, 'actualizado_el') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

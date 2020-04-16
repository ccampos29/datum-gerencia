<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosInventariablesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repuestos-inventariables-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'repuesto_id') ?>

    <?= $form->field($model, 'ubicacion_id') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'valor_unitario') ?>

    <?php // echo $form->field($model, 'cantidad_minima') ?>

    <?php // echo $form->field($model, 'cantidad_maxima') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'creado_el') ?>

    <?php // echo $form->field($model, 'actualizado_por') ?>

    <?php // echo $form->field($model, 'actualizado_el') ?>

    <?php // echo $form->field($model, 'empresa_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

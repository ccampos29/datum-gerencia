<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ComprasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compras-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'proveedor_id') ?>

    <?= $form->field($model, 'fecha_hora_hoy') ?>

    <?= $form->field($model, 'fecha_factura') ?>

    <?= $form->field($model, 'numero_factura') ?>

    <?php // echo $form->field($model, 'fecha_radicado') ?>

    <?php // echo $form->field($model, 'fecha_remision') ?>

    <?php // echo $form->field($model, 'numero_remision') ?>

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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\OtrosGastosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="otros-gastos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'factura') ?>

    <?= $form->field($model, 'codigo_interno') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'valor_unitario') ?>

    <?php // echo $form->field($model, 'cantidad_unitaria') ?>

    <?php // echo $form->field($model, 'vehiculo_id') ?>

    <?php // echo $form->field($model, 'tipo_gasto_id') ?>

    <?php // echo $form->field($model, 'tipo_descuento ') ?>

    <?php // echo $form->field($model, 'impuesto_id') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'empleado_id') ?>

    <?php // echo $form->field($model, 'proveedor_id') ?>

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

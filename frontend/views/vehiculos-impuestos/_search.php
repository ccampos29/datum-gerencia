<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiculos-impuestos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'valor_impuesto') ?>

    <?= $form->field($model, 'fecha_expedicion') ?>

    <?= $form->field($model, 'fecha_expiracion') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'centro_costo_id') ?>

    <?php // echo $form->field($model, 'tipo_impuesto_id') ?>

    <?php // echo $form->field($model, 'vehiculo_id') ?>

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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ordenes-trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vehiculo_id') ?>

    <?= $form->field($model, 'fecha_ingreso') ?>

    <?= $form->field($model, 'hora_ingreso') ?>

    <?= $form->field($model, 'fecha_orden') ?>

    <?php // echo $form->field($model, 'hora_orden') ?>

    <?php // echo $form->field($model, 'fecha_cierre') ?>

    <?php // echo $form->field($model, 'hora_cierre') ?>

    <?php // echo $form->field($model, 'medicion') ?>

    <?php // echo $form->field($model, 'proveedor_id') ?>

    <?php // echo $form->field($model, 'disponibilidad') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'tipo_orden_id') ?>

    <?php // echo $form->field($model, 'estado_orden') ?>

    <?php // echo $form->field($model, 'usuario_conductor_id') ?>

    <?php // echo $form->field($model, 'etiqueta_mantenimiento_id') ?>

    <?php // echo $form->field($model, 'centro_costo_id') ?>

    <?php // echo $form->field($model, 'municipio_id') ?>

    <?php // echo $form->field($model, 'grupo_vehiculo_id') ?>

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

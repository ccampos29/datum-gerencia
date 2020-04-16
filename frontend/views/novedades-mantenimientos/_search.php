<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="novedades-mantenimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vehiculo_id') ?>

    <?= $form->field($model, 'fecha_reporte') ?>

    <?= $form->field($model, 'hora_reporte') ?>

    <?= $form->field($model, 'usuario_reporte_id') ?>

    <?php // echo $form->field($model, 'prioridad_id') ?>

    <?php // echo $form->field($model, 'medicion') ?>

    <?php // echo $form->field($model, 'usuario_responsable_id') ?>

    <?php // echo $form->field($model, 'trabajo_id') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'fecha_solucion') ?>

    <?php // echo $form->field($model, 'estado') ?>

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

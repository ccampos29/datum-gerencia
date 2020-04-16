<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MedicionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mediciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_medicion') ?>

    <?= $form->field($model, 'hora_medicion') ?>

    <?= $form->field($model, 'valor_medicion') ?>

    <?= $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'grupo_vehiculo_id') ?>

    
    <?php // echo $form->field($model, 'combustible_id') ?>

    <?php // echo $form->field($model, 'vehiculo_id') ?>

    
    <?php // echo $form->field($model, 'proveedor_id') ?>

    <?php // echo $form->field($model, 'empleado_id') ?>

    <?php // echo $form->field($model, 'centro_costo_id') ?>

    
    <?php // echo $form->field($model, 'tipo_medicion_id') ?>

    
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

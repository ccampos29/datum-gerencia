<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentosProveedoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documentos-proveedores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tipo_documento_id') ?>

    <?= $form->field($model, 'valor_documento') ?>

    <?= $form->field($model, 'fecha_expedicion') ?>

    <?= $form->field($model, 'fecha_inicio_cubrimiento') ?>

    <?php // echo $form->field($model, 'fecha_fin_cubrimiento') ?>

    <?php // echo $form->field($model, 'es_actual') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'proveedor_id') ?>

    <?php // echo $form->field($model, 'nombre_archivo_original') ?>

    <?php // echo $form->field($model, 'nombre_archivo') ?>

    <?php // echo $form->field($model, 'ruta_archivo') ?>

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

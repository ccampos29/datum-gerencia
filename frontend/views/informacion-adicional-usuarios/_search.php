<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionAdicionalUsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informacion-adicional-usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'pais_id') ?>

    <?= $form->field($model, 'departamento_id') ?>

    <?= $form->field($model, 'municipio_id') ?>

    <?php // echo $form->field($model, 'numero_movil') ?>

    <?php // echo $form->field($model, 'numero_fijo_extension') ?>

    <?php // echo $form->field($model, 'numero_cuenta_bancaria') ?>

    <?php // echo $form->field($model, 'tipo_cuenta_bancaria') ?>

    <?php // echo $form->field($model, 'nombre_banco') ?>

    <?php // echo $form->field($model, 'usuario_id') ?>

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

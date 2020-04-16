<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RepuestosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repuestos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'fabricante') ?>

    <?= $form->field($model, 'precio') ?>

    <?= $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'codigo') 
    ?>

    <?php // echo $form->field($model, 'estado') 
    ?>

    <?php // echo $form->field($model, 'unidad_medida_id') 
    ?>

    <?php // echo $form->field($model, 'grupo_repuesto_id') 
    ?>

    <?php // echo $form->field($model, 'sistema_id') 
    ?>

    <?php // echo $form->field($model, 'subsistema_id') 
    ?>

    <?php // echo $form->field($model, 'cuenta_contable_id') 
    ?>

    <?php // echo $form->field($model, 'creado_por') 
    ?>

    <?php // echo $form->field($model, 'creado_el') 
    ?>

    <?php // echo $form->field($model, 'actualizado_por') 
    ?>

    <?php // echo $form->field($model, 'actualizado_el') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
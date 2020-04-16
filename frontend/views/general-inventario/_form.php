<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\GeneralInventario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="general-inventario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ubicacion_insumo_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descarga_respuestos')->textInput() ?>

    <?= $form->field($model, 'empresa_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creado_por')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creado_el')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actualizado_el')->textInput() ?>

    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>    </div>

    <?php ActiveForm::end(); ?>

</div>

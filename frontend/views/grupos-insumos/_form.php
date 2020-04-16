<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposInsumos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-insumos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6"> 
          <label for="nombre"><i class="fa fa-archive" aria-hidden="true"></i> Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?></div>
        <div class="col-sm-6"> 
        <label for="codigo"><i class="fa fa-hashtag" aria-hidden="true"></i> Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?></div>
    </div>
    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Conceptos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conceptos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <label for="codigo"><i class="fa fa-archive" aria-hidden="true"></i> Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="operador"><i class="fa fa-plus-circle" aria-hidden="true"></i> Operador</label>
            <?= $form->field($model, 'operador')->dropDownList(['+' => '+', '-' => '-',], ['prompt' => ''])->label(false) ?>
        </div>
        <div class="col-sm-12">
            <label for="descripcion"><i class="fa fa-comment" aria-hidden="true"></i> Descripción</label>
            <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
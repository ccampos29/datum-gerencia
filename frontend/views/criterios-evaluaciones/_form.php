<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="criterios-evaluaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
        <?= $form->field($model, 'tipo')->dropDownList([ 1 => 'Editable', 2 => 'Lista Despegable', 3 => 'Botones de opción', ]) ?>
        </div>
        <div class="col-sm-4">
        <?= $form->field($model, 'estado')->dropDownList([ '0' => 'Inactivo', '1' => 'Activo' ], ['prompt' => 'Seleccione un estado']) ?>
        </div>
    </div>

    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

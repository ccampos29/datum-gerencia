<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estados-checklist-form">

    <?php $form = ActiveForm::begin(); ?>

     <div class="container-fluid col-12">
        <div class="row">
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre
                </label>
                <?= $form->field($model, 'estado')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo del Estado
                </label>
                <?= $form->field($model, 'codigo')->textInput(['type'=>'number'])->label(false) ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Dias para alertar
                </label>
                <?= $form->field($model, 'dias_alerta')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?> 
            </div>
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-file" aria-hidden="true"></i> Descripcion
                </label>
                <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label(false) ?> 
            </div>
        </div>
        <div class="form-group">
        <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>  Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>

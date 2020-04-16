<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SemaforosTrabajos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semaforos-trabajos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-4">
            <h4><strong>Indicador</strong></h4>
        </div>
        <div class="col-xs-4">
            <h4><strong>Desde (%)</strong></h4>
        </div>
        <div class="col-xs-4">
            <h4><strong>Hasta (%)</strong></h4>
        </div>
    </div>
    <?php foreach ($semaforos as $key=>$semaforo) : ?>
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($model, 'indicador[]')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $semaforo->indicador])->label(false) ?>
            </div>
            <div class="col-xs-1">
                <div class="rounded" style="background:<?= @$indicadores[$semaforo->indicador]['color'] ?>;"></div>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'desde[]')->textInput(['type'=>'number'])->label(false) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'hasta[]')->textInput(['type'=>'number'])->label(false) ?>
            </div>
        </div>

    <?php endforeach; ?>


    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre del cliente 
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-list" aria-hidden="true"></i> Digito de verificacion  
                </label>
                <?= $form->field($model, 'digito_verificacion')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'max' => 99,
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
        </div>
        <div class ="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Numero de identificacion  
                </label>
                <?= $form->field($model, 'identificacion')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-files-o" aria-hidden="true"></i> Tipo de regimen del cliente  
                </label>
                <?= $form->field($model, 'regimen')->dropDownList([ 'Comun' => 'Comun', 'Gran contribuyente' => 'Gran contribuyente', 'Simplificado' => 'Simplificado', ], ['prompt' => ''])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['clientes/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

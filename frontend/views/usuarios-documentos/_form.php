<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-documentos-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="contairner-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre del documento
                </label>
                <?= $form->field($model, 'nombre')->textInput()->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['type' => 'number'])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Dias para alertar
                </label>
                <?= $form->field($model, 'dias_alerta')->textInput(['type' => 'number'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>
                    <i class="fa fa-text" aria-hidden="true"></i> Descripcion
                </label>
                <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label(false); ?>
            </div>
        </div>
    </div>

    
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['usuarios-documentos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    
    <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
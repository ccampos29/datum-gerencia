<?php

use frontend\models\CentrosCostos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ZonasCentrosCostos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zonas-centros-costos-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
 
       <div class="col-sm-6">
       <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number']) ?></div>

    </div>

   
  
  

    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

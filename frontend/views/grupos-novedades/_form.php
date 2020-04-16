<?php

use frontend\models\TiposChecklist;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposNovedades */
/* @var $form yii\widgets\ActiveForm */
$urlTiposChecklist = Yii::$app->urlManager->createUrl('tipos-checklist/tipos-checklist-list');
    
?>

<div class="grupos-novedades-form wide ">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <label for="nombre"><i class="fa fa-user-o" aria-hidden="true"></i> Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>          
        </div>
       
        <div class="col-sm-6">
             <label for="codigo"><i class="fa fa-hashtag" aria-hidden="true"></i> Código</label>
             <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
        <div class="col-sm-12">
             <label for="comentario"><i class="fa fa-comment" aria-hidden="true"></i> Comentario</label>
             <?= $form->field($model, 'comentario')->textarea(['rows' => 6])->label(false) ?>
        </div>
        
    </div>

    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
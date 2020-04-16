<?php

use frontend\models\MarcasMotores;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMotores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lineas-motores-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <div class="row">
        <div class="col-sm-6"> <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <label>Marca Motor</label>
            <?php
            $data = ArrayHelper::map(MarcasMotores::find()->where(['empresa_id'=>Yii::$app->user->identity->empresa_id])->all(), 'id', 'nombre');
            echo $form->field($model, 'marca_motor_id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione una marca...'],
                'pluginOptions' => [

                    'tokenSeparators' => [',', ' ']
                ],
            ])->label(false)
            ?>
        </div>

    </div>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
         <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

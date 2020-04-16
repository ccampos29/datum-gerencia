<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UbicacionesInsumos */
/* @var $form yii\widgets\ActiveForm */
$urlUsuarios = Yii::$app->urlManager->createUrl('user/nombres-usuarios-list');

?>

<div class="ubicaciones-insumos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
        <label for="codigo"><i class="fa fa-archive" aria-hidden="true"></i> Nombre</label>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
        <label for="codigo_interno"><i class="fa fa-hashtag" aria-hidden="true"></i> Código Interno</label>
        <?= $form->field($model, 'codigo_interno')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
        <label for="activo"><i class="fa fa-check-square" aria-hidden="true"></i> Activo</label>
        <?php
            $data = ArrayHelper::map(array(array('id'=>'1','nombre'=>'Activo'),array('id'=>'0','nombre'=>'Inactivo')), 'id', 'nombre');
            echo $form->field($model, 'activo')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => '¿Se encuentra Activo?'],
                'pluginOptions' => [

                    'tokenSeparators' => [',', ' ']
                ],
            ])->label(false)
            ?>
        </div>
        <div class="col-sm-6">
        <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Asignar a
                </label>
                <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(User::find()->select(['id', "concat(id_number,' - ',name,' ',surname) AS name"])->all(),'id','name'),
                    'options' => [
                        'placeholder' => 'Seleccione un usuario...'
                    ],
                    'pluginOptions' => [
                        'multiple' => true,
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        
                    ]
                ])->label(false); ?>

        </div>
        <div class="col-sm-12">
        <label for="observacion"><i class="fa fa-comment" aria-hidden="true"></i> Observación</label>
        <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

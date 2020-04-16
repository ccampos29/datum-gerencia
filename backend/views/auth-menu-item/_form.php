<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use common\models\AuthMenuItem;
use backend\models\AuthItem;

/**
 * @var yii\web\View $this
 * @var common\models\AuthMenuItem $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="auth-menu-item-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=> [
                'placeholder'=>'Enter Nombre del item...', 'maxlength'=>40]],
            
            'label'=>['type'=> Form::INPUT_TEXT, 'options'=>[
                'placeholder'=>'Enter Texto que verá el usuario...', 'maxlength'=>60]],

            'auth_item' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => ArrayHelper::map(AuthItem::find()->all(), 'name', 'name'),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],

            'tipo' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->ayudante
                                    ->datosEnum(AuthMenuItem::tableName(), 'tipo'),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],
            
            'separador' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->ayudante->booleanArray(),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],
            
            'padre' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => ArrayHelper::map(AuthMenuItem::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],
            
            'visible' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => Yii::$app->ayudante->booleanArray(),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],

            'orden'=>['type'=> Form::INPUT_TEXT, 'options'=>[
                'placeholder'=>'Enter Orden en que aparecerán las opciones...']],

            'ruta'=>['type'=> Form::INPUT_TEXT, 'options'=>[
                'placeholder'=>'Enter Ruta a la cual lleva el menú...', 'maxlength'=>200]],

            'icono'=>['type'=> Form::INPUT_TEXT, 'options'=>[
                'placeholder'=>'Enter Icono que se verá al lado del menú...', 'maxlength'=>30]],

            'descripcion'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>[
                'placeholder'=>'Enter Descripción...','rows'=> 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', [
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

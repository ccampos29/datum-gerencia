<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use backend\models\AuthItem;
/**
 * @var yii\web\View $this
 * @var administracion\models\AuthItemChild $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'parent' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => ArrayHelper::map(AuthItem::find()->orderBy('name')
                                ->asArray()->all(), 'name', 'name'),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
                'columnOptions'=>['colspan'=>1],
            ],
            
            'child' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => ArrayHelper::map(AuthItem::find()->orderBy('name')
                                ->asArray()->all(), 'name', 'name'),
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
                'columnOptions'=>['colspan'=>1],
            ],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? "Crear" : "Actualizar", 
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

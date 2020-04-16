<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var administracion\models\AuthAssignment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'item_name' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => ArrayHelper::map(backend\models\AuthItem::find()->all(), 'name', 'name'),
                        'options' => ['placeholder' => 'Seleccionar...'],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ],
                    ],
                    'columnOptions'=>['colspan'=>1],
                ],                

                'user_id' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => ArrayHelper::map(common\models\User::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Seleccionar...'],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ],
                    ],
                    'columnOptions'=>['colspan'=>1],
                ],                

            ]
        ]);

    echo Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

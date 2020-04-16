<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\User;
use frontend\models\AlertasTipos;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlertasUsuarios */
/* @var $form yii\widgets\ActiveForm */

$urlUsuarios = Yii::$app->urlManager->createUrl('user/tipos-usuarios-list');
?>

<div class="alertas-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-6">
        <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
            'options' => ['placeholder' => 'Seleccione un usuario',],

            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 0,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                ],
                'ajax' => [
                    'url' => $urlUsuarios,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
            ]
        ])
        ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'tipo_alerta_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AlertasTipos::find()->all(), 'id', 'nombre'),
            'options' => ['placeholder' => 'Seleccione un tipo de alerta',],
        ])
        ?>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', Url::to([Yii::$app->controller->id . '/']), ['class' => 'btn btn-default']); ?>
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
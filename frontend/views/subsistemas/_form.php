<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use frontend\models\Sistemas;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subsistemas */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="subsistemas-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <i class="fa fa-laptop" aria-hidden="true"></i> <label>Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <label>Sistema</label>
            <div class="row">
                <div class="col-sm-10">
                    <?php
                    echo $form->field($model, 'sistema_id')->widget(Select2::classname(), [
                        'data' => !empty($model->sistema_id) ? [$model->sistema_id => Sistemas::findOne($model->sistema_id)->nombre] : [],
                        'pluginOptions' => [
                            'placeholder' => 'Seleccione un Sistema',
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => Yii::$app->urlManager->createUrl('sistemas/sistemas-list'),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false);
                    ?>
                </div>
                <div class="col-sm-2">
                <a href="<?= Url::to(['sistemas/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear Sistema" target="_blank"><span class="fa fa-plus"></span></a>

                </div>
            </div>

        </div>
        <div class="col-sm-12">
            <i class="fa fa-hashtag" aria-hidden="true"></i> <label>Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
            <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
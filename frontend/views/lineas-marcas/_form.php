<?php

use frontend\models\MarcasVehiculos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\LineasMarcas */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="lineas-marcas-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
             <label for="descripcion"><i class="fa fa-comment" aria-hidden="true"></i> Descripción</label>
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <i class="fa fa-shopping-comment" aria-hidden="true"></i> <label>Marca Vehículo</label>
            <div class="row">
                <div class="col-sm-10">
                    <?php
                    echo $form->field($model, 'marca_id')->widget(Select2::classname(), [
                        'data' => !empty($model->marca_id) ? [$model->marca_id => MarcasVehiculos::findOne($model->marca_id)->descripcion] : [],
                        'pluginOptions' => [
                            'placeholder' => 'Seleccione una Marca',
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => Yii::$app->urlManager->createUrl('marcas-vehiculos/marcas-vehiculos-list'),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false);
                    ?>
                </div>
                <div class="col-sm-2">
                <a href="<?= Url::to(['marcas-vehiculos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear Marca Veh" target="_blank"><span class="fa fa-plus"></span></a>

                </div>
            </div>

        </div>
        <div class="col-sm-12">
            <label for="codigo"><i class="fa fa-hashtag" aria-hidden="true"></i> Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
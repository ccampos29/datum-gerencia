<?php

use frontend\models\LineasMotores;
use frontend\models\MarcasMotores;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Motores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="motores-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <i class="fa fa-car" aria-hidden="true"></i> <label>Marca de Motor</label>
            <div class="row">
                <div class="col-sm-10">
                <?php
                echo $form->field($model, 'marca_motor_id')->widget(Select2::classname(), [
                    'data' => !empty($model->marca_motor_id) ? [$model->marca_motor_id => MarcasMotores::findOne($model->marca_motor_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione una Marca Motor',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('marcas-motores/marcas-motores-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false);
                ?>
                </div>
                <div class="col-sm-2">
                <a href="<?= Url::to(['marcas-motores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear Marca Veh" target="_blank"><span class="fa fa-plus"></span></a>

                </div>
            </div>
           
        </div>
        <div class="col-sm-6">
            <i class="fa fa-car" aria-hidden="true"></i> <label>Línea de Motor</label>
            <div class="row">
                <div class="col-sm-10">
                <?php
                echo $form->field($model, 'linea_motor_id')->widget(Select2::classname(), [
                    'data' => !empty($model->linea_motor_id) ? [$model->linea_motor_id => LineasMotores::findOne($model->linea_motor_id)->descripcion] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione una Linea Motor',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('lineas-motores/lineas-motores-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false);
                ?>
                </div>
                <div class="col-sm-2">
                <a href="<?= Url::to(['lineas-motores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear Marca Veh" target="_blank"><span class="fa fa-plus"></span></a>

                </div>
            </div>         
            
        </div>
    </div>
    <div class="row">
    <div class="col-sm-6">
            <label for="codigo"><i class="fa fa-hashtag" aria-hidden="true"></i> Código</label>
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="potencia"><i class="fa fa-battery-2" aria-hidden="true"></i> Potencia</label>
            <?= $form->field($model, 'potencia')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="potencia"><i class="fa fa-gears" aria-hidden="true"></i> Torque</label>
            <?= $form->field($model, 'torque')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="potencia"><i class="fa fa-battery-4" aria-hidden="true"></i> Rpm</label>
            <?= $form->field($model, 'rpm')->textInput(['maxlength' => true,'type'=>'number'])->label(false) ?>
        </div>
        <div class="col-sm-12">
            <label for="potencia"><i class="fa fa-flash" aria-hidden="true"></i> Cilindraje</label>
            <?= $form->field($model, 'cilindraje')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-12">
            <label for="potencia"><i class="fa fa-comment" aria-hidden="true"></i> Observación</label>
            <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
        
    </div>
    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

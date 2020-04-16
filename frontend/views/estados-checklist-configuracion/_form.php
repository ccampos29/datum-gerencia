<?php

use frontend\models\EstadosChecklist;
use frontend\models\EstadosChecklistConfiguracion;
use frontend\models\TiposChecklist;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistConfiguracion */
/* @var $form yii\widgets\ActiveForm */

$get_tp_ck =  EstadosChecklist::find()->all();

if(!$model->isNewRecord)
$get_tp_ck =  EstadosChecklistConfiguracion::find()->where(['tipo_checklist_id'=>$_GET['id']])->all();

?>

<div class="estados-checklist-configuracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_checklist_id')->widget(Select2::classname(), [
        'data' => !empty($model->tipo_checklist_id) ? [$model->tipo_checklist_id => TiposChecklist::findOne($model->tipo_checklist_id)->nombre] : [],
        'options' => ['id' => 'select-checklist', 'placeholder' => 'Selecciona un tipo de checklist',],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['tipos-checklist/tipos-checklist-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
    ])
    ?>
    
    <div class="row">
        <div class="col-sm-3"><strong>Estado</strong></div>
        <div class="col-sm-3"><strong>Porcentaje Máximo Rechazadas</strong></div>
        <div class="col-sm-3"><strong>Cantidad Máxima Criticas</strong></div>
        <div class="col-sm-3"><strong>Descripción</strong></div>
    </div>
    <?php
    if (($model->isNewRecord)):
    foreach ($get_tp_ck as $tp_ck) :
    ?>
    <?= $form->field($model, 'estado_checklist_id[]')->textInput(['maxlength' => true, 'value' => $tp_ck->id, 'type' => 'hidden'])->label(false) ?>
        <div class="row">
            <div class="col-sm-3">
            <?= $form->field($model, 'estado_checklist_nm[]')->textInput(['maxlength' => true, 'value' => $tp_ck->estado,'readonly'=>true])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'porcentaje_maximo_rej[]')->textInput(['type'=>'number'])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'cantidad_maxima_crit[]')->textInput(['type'=>'number'])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'descripcion[]')->textInput()->label(false) ?>
            </div>
        </div>
    <?php endforeach; 
    else: 
        foreach ($get_tp_ck as $tp_ck) :
    ?>
    <?= $form->field($model, 'id[]')->textInput(['maxlength' => true, 'value' => $tp_ck->id, 'type' => 'hidden'])->label(false) ?>
    <?= $form->field($model, 'estado_checklist_id[]')->textInput(['maxlength' => true, 'value' => $tp_ck->estadoChecklist->id, 'type' => 'hidden'])->label(false) ?>
        <div class="row">
            <div class="col-sm-3">
            <?= $form->field($model, 'estado_checklist_nm[]')->textInput(['maxlength' => true, 'value' => $tp_ck->estadoChecklist->estado,'readonly'=>true])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'porcentaje_maximo_rej[]')->textInput(['type'=>'number','value'=>$tp_ck->porcentaje_maximo_rej])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'cantidad_maxima_crit[]')->textInput(['type'=>'number','value'=>$tp_ck->cantidad_maxima_crit])->label(false) ?>
            </div>
            <div class="col-sm-3">
            <?= $form->field($model, 'descripcion[]')->textInput(['value'=>$tp_ck->descripcion])->label(false) ?>
            </div>
        </div>
    <?php endforeach; 
    endif;
    ?>


    <div class="form-group">
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>    </div>

    <?php ActiveForm::end(); ?>

</div>

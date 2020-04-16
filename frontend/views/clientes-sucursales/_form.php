<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use frontend\models\Pais;
use frontend\models\Departamentos;
use frontend\models\Municipios;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use frontend\models\Clientes;
/* @var $this yii\web\View */
/* @var $model frontend\models\ClientesSucursales */
/* @var $form yii\widgets\ActiveForm */
$urlClientes = Yii::$app->urlManager->createUrl('clientes/clientes-list');
$urlPais = Yii::$app->urlManager->createUrl('pais/pais-list');
?>

<div class="clientes-sucursales-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre de la sucursal
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo de la sucursal
                </label>
                <?= $form->field($model, 'codigo')->textInput(['type' => 'number'])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre del cliente
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'cliente_id')->widget(Select2::classname(), [
                                'data' => !empty($model->cliente_id) ? [$model->cliente_id => Clientes::findOne($model->cliente_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un cliente',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlClientes,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                    ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../clientes/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un cliente" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-check" aria-hidden="true"></i> ¿Sucursal activa?
                </label>
                <?= $form->field($model, 'activo')->dropDownList([ 1 => 'Activo', 0 => 'Inactivo',], ['prompt' => ''])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-phone" aria-hidden="true"></i> Telefono fijo
                </label>
                <?= $form->field($model, 'telefono_fijo')->textInput(['type' => 'number'])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-mobile" aria-hidden="true"></i> Telefono movil
                </label>
                <?= $form->field($model, 'telefono_movil')->textInput(['type' => 'number'])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-envelope-open-o" aria-hidden="true"></i> Email
                </label>
                <?= $form->field($model, 'email')->textInput(['type' => 'email'])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre de contacto
                </label>
                 <?= $form->field($model, 'contacto')->textInput()->label(false); ?>
            </div>
        </div>
        <div class = "row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map" aria-hidden="true"></i> Pais
                </label>
                <?= $form->field($model, 'pais_id')->widget(Select2::classname(), [
                        'data' => !empty($model->pais_id) ? [$model->pais_id => Pais::findOne($model->pais_id)->nombre] : [],
                        'options' => ['id'=>'idPais', 'placeholder' => 'Seleccione un pais',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlPais,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                ]])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map-pin" aria-hidden="true"></i> Departamento
                </label>
                <?= $form->field($model, 'departamento_id')->widget(DepDrop::classname(), [
                    'options'=>['id'=>'idDepartamento'],
                    'data' => !empty($model->departamento_id) ? [$model->departamento_id => Departamentos::findOne($model->departamento_id)->nombre] : [],
                        
                    'pluginOptions'=>[
                        'depends'=>['idPais'],
                        'placeholder'=>'Select...',
                        'url'=>Url::to(['vehiculos/departamentos'])
                    ]
                ])->label(false) ?> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Municipio
                </label>
                <?= $form->field($model, 'municipio_id')->widget(DepDrop::classname(), [
                    'options'=>['id'=>'idMunicipio'],
                    'data' => !empty($model->municipio_id) ? [$model->municipio_id => Municipios::findOne($model->municipio_id)->nombre] : [],
                        
                    'pluginOptions'=>[
                        'depends'=>['idDepartamento'],
                        'placeholder'=>'Select...',
                        'url'=>Url::to(['vehiculos/municipios'])
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-globe" aria-hidden="true"></i> Direccion de la sucursal
                </label>
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false); ?>
            </div>
        </div>
        <div class = "row">
            <div class="col-12">
                <label>
                    <i class="fa fa-map-mark" aria-hidden="true"></i> Observaciones
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['clientes-sucursales/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

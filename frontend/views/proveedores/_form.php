<?php

use frontend\models\Departamentos;
use frontend\models\Municipios;
use frontend\models\Pais;
use frontend\models\TiposProveedores;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proveedor-form">
    <?php $form = ActiveForm::begin(); ?>
    <!-- <div class="box box-primary">-->
    <div>
        <div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="nombre"><i class="fa fa-archive" aria-hidden="true"></i> Nombre</label>
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?></div>
                <div class="col-sm-4">
                    <label for="tipo_proveedor_id"><i class="fa fa-user-o" aria-hidden="true"></i> Tipo de Proveedor</label>
                    <div class="row">
                        <div class="col-sm-10">
                            <?php 
                            echo $form->field($model, 'tipo_proveedor_id')->widget(Select2::classname(), [
                                'data' => !empty($model->tipo_proveedor_id) ? [$model->tipo_proveedor_id => TiposProveedores::findOne($model->tipo_proveedor_id)->nombre] : [],
                                'pluginOptions' => [
                                    'placeholder' =>'Seleccione un tipo de Proveedor',
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Yii::$app->urlManager->createUrl('proveedores/tipos-proveedores-list'),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false);?>
                        </div>
                        <div class="col-sm-2">
                            <a href="<?= Url::to(['tipos-proveedores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear tipo de proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>

                </div>

                <div class="col-sm-4">
                    <label for="identificacion"><i class="fa fa-address-book" aria-hidden="true"></i> Identificacion</label>
                    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-hashtag" aria-hidden="true"></i> Dígito de Verificación</label>
                    <?= $form->field($model, 'digito_verificacion')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?></div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-phone" aria-hidden="true"></i> Télefono</label>
                    <?= $form->field($model, 'telefono_fijo_celular')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?></div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-envelope" aria-hidden="true"></i> Email</label>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email'])->label(false) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-address-card-o" aria-hidden="true"></i> Dirección</label>
                    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?></div>
                <div class="col-sm-8">
                    <label for="codigo"><i class="fa fa-user-o" aria-hidden="true"></i> Nombre de contacto</label>
                    <?= $form->field($model, 'nombre_contacto')->textInput(['maxlength' => true])->label(false) ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-info" aria-hidden="true"></i> País</label>
                    <?=
                        $form->field($model, 'pais_id')->widget(Select2::classname(), [
                            'language' => 'es',
                            'data' => ArrayHelper::map(Pais::find()->all(), 'id', 'nombre'),
                            'options' => [
                                'placeholder' => 'Seleccione...',
                                'id' => 'select-pais'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false)
                    ?>
                </div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-info" aria-hidden="true"></i> Departamento</label>
                    <?=
                        $form->field($model, 'departamento_id')->widget(Select2::classname(), [
                            'language' => 'es',
                            'data' => !empty($model->departamento_id) ? [$model->departamento_id => Departamentos::findOne($model->departamento_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione...',
                                'disabled' => true,
                                'id' => 'select-departamento'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false)
                    ?>
                </div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-info" aria-hidden="true"></i> Municipio</label>
                    <?=
                        $form->field($model, 'municipio_id')->widget(Select2::classname(), [
                            'language' => 'es',
                            'data' => !empty($model->municipio_id) ? [$model->municipio_id => Municipios::findOne($model->municipio_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione...',
                                'disabled' => true,
                                'id' => 'select-ciudad'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false)
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-info-circle" aria-hidden="true"></i> Régimen</label>
                    <?= $form->field($model, 'regimen')->dropDownList(['Contributivo' => 'Contributivo', 'Simplificado' => 'Simplificado', 'Común' => 'Común',], ['prompt' => ''])->label(false) ?>
                </div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-info-circle" aria-hidden="true"></i> Tipo de Procedencia</label>
                    <?= $form->field($model, 'tipo_procedencia')->dropDownList(['Interno' => 'Interno', 'Externo' => 'Externo',], ['prompt' => ''])->label(false) ?>
                </div>
                <div class="col-sm-4">
                    <label for="codigo"><i class="fa fa-check-circle" aria-hidden="true"></i> ¿Está activo?</label>
                    <?php
                    $data = ArrayHelper::map(array(array('id' => '1', 'nombre' => 'Activo'), array('id' => '0', 'nombre' => 'Inactivo')), 'id', 'nombre');
                    echo $form->field($model, 'activo')->widget(Select2::classname(), [
                        'data' => $data,
                        'options' => ['placeholder' => '¿Se encuentra Activo?'],
                        'pluginOptions' => [

                            'tokenSeparators' => [',', ' ']
                        ],
                    ])->label(false)
                    ?>
                </div>
            </div>
            <div class="form-group">
            <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>

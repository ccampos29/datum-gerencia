<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Vehiculos;
use kartik\file\FileInput;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\select2\Select2;
use frontend\models\TiposOtrosDocumentos;
use frontend\models\VehiculosDocumentosArchivos;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosDocumentosArchivos */
/* @var $form yii\widgets\ActiveForm */

$vehiculo = Vehiculos::findOne($_GET['idv']);
$urlTiposDocumentos = Url::to(['tipos-documentos/tipos-documentos-list']);
!empty($_GET['idDocumento']) ? $var = 1 : $var = 0;
$documento = !empty($_GET['idDocumento']) ? TiposOtrosDocumentos::findOne($_GET['idDocumento']) : [];
?>

<div class="vehiculos-documentos-archivos-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid col-12">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                </label>
                <input class="form-control" readOnly="true" value=<?= $vehiculo->placa; ?>>
                </input>
                <?= $form->field($model, 'vehiculo_id')->textInput([
                    'value' => $vehiculo->id,
                    'class' => 'hidden',
                ])->label(false) ?>
            </div>
            <?php
            if ($var == 1) { ?>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <label>
                        <i class="fa fa-bank" aria-hidden="true"></i> Tipo de documento
                    </label>
                    <input class="form-control" readOnly="true" value=<?= $documento->nombre; ?>>
                    </input>
                    <?= $form->field($model, 'tipo_documento_id')->textInput([
                            'value' => $documento->id,
                            'class' => 'hidden',
                        ])->label(false) ?>
                </div>
            <?php
            } else { ?>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <div class="row">
                        <label>
                            <i class="fa fa-bank" aria-hidden="true"></i> Tipo de documento
                        </label>
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'tipo_documento_id')->widget(Select2::classname(), [
                                    'data' => !empty($model->tipo_documento_id) ? [$model->tipo_documento_id => TiposOtrosDocumentos::findOne($model->tipo_documento_id)->nombre] : [],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => $urlTiposDocumentos,
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                    ]
                                ])->label(false) ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="../tipos-otros-documentos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de documento" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> ¿Es actual?
                </label>
                <?= $form->field($model, 'es_actual')->dropDownList(['1' => 'Si', '0' => 'No'], ['prompt' => ''])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-upload" aria-hidden="true"></i> Archivo a cargar
                </label>
                <?php if ($model->isNewRecord) {
                    echo $form->field($model, 'documento')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'all/*',
                            'required' => $model->isNewRecord ? true : false
                        ],
                        'pluginOptions' => [
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-success',
                        ]
                    ])->label(false);
                } else {
                    echo  $form->field($model, 'documento')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'all/*',
                            'required' => $model->isNewRecord ? true : false
                        ],
                        'pluginOptions' => [
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-success',
                        ]
                    ])->label(false);

                    echo 'Archivo subido: ' . Html::a('Descargar archivo', Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaArchivosDocumentosV'] . $model->nombre_archivo));
                }

                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-documentos-archivos/index', 'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Vehiculos;
use kartik\file\FileInput;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\select2\Select2;
use frontend\models\TiposImpuestos;
/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestosArchivos */
/* @var $form yii\widgets\ActiveForm */

$vehiculo = Vehiculos::findOne($_GET['idv']);
$urlTiposImpuesto = Url::to(['tipos-impuestos/tipos-impuestos-list']);
!empty($_GET['idImpuesto']) ? $var = 1 : $var = 0;
$impuesto = !empty($_GET['idImpuesto']) ? TiposImpuestos::findOne($_GET['idImpuesto']) : [];
?>

<div class="vehiculos-impuestos-archivos-form">

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
                        <i class="fa fa-bank" aria-hidden="true"></i> Tipo de impuesto 
                    </label>
                    <input class="form-control" readOnly="true" value=<?= $impuesto->nombre; ?>>
                    </input>
                    <?= $form->field($model, 'tipo_impuesto_id')->textInput([
                            'value' => $impuesto->id,
                            'class' => 'hidden',
                        ])->label(false) ?>
                </div>
            <?php
            } else { ?>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <div class="row">
                        <label>
                            <i class="fa fa-bank" aria-hidden="true"></i> Tipo de impuesto
                        </label>
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'tipo_impuesto_id')->widget(Select2::classname(), [
                                    'data' => !empty($model->tipo_impuesto_id) ? [$model->tipo_impuesto_id => TiposImpuestos::findOne($model->tipo_impuesto_id)->nombre] : [],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => $urlTiposImpuestos,
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                    ]
                                ])->label(false) ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="../tipos-impuestos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de impuesto" target="_blank"><span class="fa fa-plus"></span></a>
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
                echo $form->field($model, 'impuesto')->widget(FileInput::classname(), [
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
                echo  $form->field($model, 'impuesto')->widget(FileInput::classname(), [
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
                
                echo 'Archivo subido: ' . Html::a('Descargar archivo', Yii::$app->urlManager->createUrl('../..'.Yii::$app->params['rutaArchivosImpuestos'] . $model->nombre_archivo));
            }?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-impuestos-archivos/index', 'idv'=>$_GET['idv'], 'idImpuesto'=>$_GET['idImpuesto']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
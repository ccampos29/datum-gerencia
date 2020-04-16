<?php

use frontend\models\TiposDocumentos;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentosProveedores */
/* @var $form yii\widgets\ActiveForm */

$value =  $model->isNewRecord ? $proveedor_id : NULL;

?>

<div class="documentos-proveedores-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="">
        <div class="content">
            <?= $form->field($model, 'proveedor_id')->textInput(['value' => $value, 'type' => 'hidden'])->label(false) ?>

            <div class="row">

                <div class="col-sm-6">
                    <label for="tipo_documento_id"><i class="fa fa-info" aria-hidden="true"></i> Tipo de Documento</label>
                    <?php
                    $data = ArrayHelper::map(TiposDocumentos::find()->all(), 'id', 'nombre');
                    echo $form->field($model, 'tipo_documento_id')->widget(Select2::classname(), [
                        'data' => $data,
                        'options' => ['placeholder' => 'Seleccione un tipo de documento..'],
                        'pluginOptions' => [

                            'tokenSeparators' => [',', ' ']
                        ],
                    ])->label(false)
                    ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'valor_documento')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="fecha_expedicion">Fecha de Expedición</label>
                    <?= $form->field($model, 'fecha_expedicion')->widget(DatePicker::classname(), [
                        'value' => date('Y-m-d', strtotime('+1 days')),
                        'type' => DatePicker::TYPE_INPUT,
                        'options' => ['placeholder' => 'Seleccione una fecha de inicio cubrimiento ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ])->label(false);
                    ?>

                </div>
                <div class="col-sm-4">
                    <label for="fecha_inicio_cubrimiento">Fecha de Inicio Cubrimiento</label>
                    <?= $form->field($model, 'fecha_inicio_cubrimiento')->widget(DatePicker::classname(), [
                        'value' => date('Y-m-d', strtotime('+1 days')),
                        'type' => DatePicker::TYPE_INPUT,
                        'options' => ['placeholder' => 'Seleccione una fecha de inicio cubrimiento ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ])->label(false);
                    ?>

                </div>
                <div class="col-sm-4">
                    <label for="fecha_fin_cubrimiento">Fecha de Fin Cubrimiento</label>
                    <?= $form->field($model, 'fecha_fin_cubrimiento')->widget(DatePicker::classname(), [
                        'value' => date('Y-m-d', strtotime('+1 days')),
                        'type' => DatePicker::TYPE_INPUT,
                        'options' => ['placeholder' => 'Seleccione una fecha de inicio cubrimiento ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ])->label(false);
                    ?>

                </div>

            </div>


            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'es_actual')->dropDownList(['1' => 'Si', '0' => 'No'], ['prompt' => '']) ?>
                </div>
                <div class="col-sm-12">
                    
                    <?=
                        $form->field($model, 'documento')->widget(FileInput::classname(), [
                            'options' => [
                                'accept' => 'image/*',
                                'required' => $model->isNewRecord ? true : false
                            ],
                            'pluginOptions' => [
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-danger',
                            ]
                        ]);
                    ?>
                       <?php if (!$model->isNewRecord) :
                        echo 'Archivo subido: '. Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaArchivosProveedores'] . $model->nombre_archivo));
                    endif; ?>
                 
                </div>
                <div class="col-sm-12"><br>
                    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id . '/']), ['class' => 'btn btn-default']); ?>

                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>



        <?php ActiveForm::end(); ?>

    </div>
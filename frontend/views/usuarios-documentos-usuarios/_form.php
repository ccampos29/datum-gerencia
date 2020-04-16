<?php

use common\models\User;
use frontend\models\CentrosCostos;
use frontend\models\Proveedores;
use frontend\models\UsuariosDocumentos;
use kartik\file\FileInput;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsuariosDocumentosUsuarios */
/* @var $form yii\widgets\ActiveForm */

$urlUsuarios = Url::to(['user/nombres-usuarios-list']);
$urlDocumentos = Url::to(['usuarios-documentos/documentos-list']);
$urlProveedores = Url::to(['proveedores/proveedores-list']);
$urlCentrosCostos = Url::to(['centros-costos/centros-costos-list']);
$usuario = User::findOne($_GET['iUs']);

?>

<div class="usuarios-documentos-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Usuarios
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <input class="form-control" readOnly="true" value=<?= $usuario->name; ?>>
                        </input>
                        <?= $form->field($model, 'usuario_id')->textInput([
                            'value' => $usuario->id,
                            'class' => 'hidden',
                        ])->label(false) ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../user/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un usuario" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-folder-open" aria-hidden="true"></i> Documentos
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'usuario_documento_id')->widget(Select2::classname(), [
                            'data' => !empty($model->usuario_documento_id) ? [$model->usuario_documento_id => UsuariosDocumentos::findOne($model->usuario_documento_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un usuario al que cargar el tanqueo',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlDocumentos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../usuarios-documentos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un documento" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['type' => 'number'])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Valor del documento
                </label>
                <?= $form->field($model, 'valor_documento')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <label>
                    <i class="fa fa-date" aria-hidden="true"></i> Fecha de expedición y expiración
                </label>
                <?php
                //echo '<label class="control-label">Select date range</label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_expedicion',
                    'attribute2' => 'fecha_expiracion',
                    'options' => ['placeholder' => 'Fecha de expedición'],
                    'options2' => ['placeholder' => 'Fecha de expiración'],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'clearBtn' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-check" aria-hidden="true"></i> Activo
                </label>
                <?= $form->field($model, 'actual')->dropDownList([1 => 'Activo', 0 => 'Inactivo',], ['prompt' => ''])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-folder-open" aria-hidden="true"></i> Proveedor
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un proveedor',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlProveedores,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../proveedores/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-folder-open" aria-hidden="true"></i> Centros de costos
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un centro de costos',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlCentrosCostos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../centros-costos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costos" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                 
                </div></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['usuarios-documentos-usuarios/index', 'iUs' => $_GET['iUs']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>

        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
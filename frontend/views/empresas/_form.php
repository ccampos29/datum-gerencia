<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresas-form">

    <?php
    $form = ActiveForm::begin();
    ?>


    <?php
    if ($model->getErrors()):
        ?>
        <div class="alert alert-danger">
            <label>
                Se encuentran los siguientes errores en la información de la empresa.
            </label>
            <ul>
                <?php foreach ($model->getErrors() as $error): ?>
                    <li>
                        <?= $error ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php
    if ($modelUsuario->getErrors()):
        ?>
        <div class="alert alert-danger">
            <label>
                Se encuentran los siguientes errores en la información del usuario.
            </label>
            <ul>
                <?php foreach ($modelUsuario->getErrors() as $error): ?>
                    <li>
                        <?= $error[0] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-building" aria-hidden="true"></i> Nombre 
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <label>
                    <i class="fa fa-id-card-o" aria-hidden="true"></i> NIT/Identificación
                </label>
                <?= $form->field($model, 'nit_identificacion')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
            <div class="col-sm-3">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Digito de verificación
                </label>
                <?= $form->field($model, 'digito_verificacion')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
            <div class="col-sm-3">
                <label>
                    <i class="fa fa-phone-square" aria-hidden="true"></i> Número fijo 
                </label>
                <?=
                $form->field($model, 'numero_fijo')->widget(MaskedInput::classname(), [
                    'mask' => ['999-99-99'],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => '999-99-99'
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-3">
                <label>
                    <i class="fa fa-mobile" aria-hidden="true"></i> Número celular
                </label>
                <?=
                $form->field($model, 'numero_celular')->widget(MaskedInput::classname(), [
                    'mask' => ['999-999-99-99'],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => '999-999-99-99'
                    ]
                ])->label(false)
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-envelope" aria-hidden="true"></i> Email de contacto 
                </label>
                <?=
                $form->field($model, 'correo_contacto')->widget(MaskedInput::classname(), [
                    'clientOptions' => [
                        'alias' => 'email'
                    ],
                ])->label(false)
                ?>

            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Dirección 
                </label>
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?>            
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-bullseye" aria-hidden="true"></i> Tipo 
                </label>
                <?= $form->field($model, 'tipo')->dropDownList(['Juridica' => 'Juridica', 'Natural' => 'Natural',], ['prompt' => ''])->label(false) ?>
            </div>
            <div class="col-sm-8">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Duración de la licencia 
                </label>
                <?php
//echo '<label class="control-label">Select date range</label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_inicio_licencia',
                    'attribute2' => 'fecha_fin_licencia',
                    'options' => ['placeholder' => 'Fecha inicio de la licencia'],
                    'options2' => ['placeholder' => 'Fecha fin de la licencia'],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-camera" aria-hidden="true"></i> Logo
                </label>
                <?php
                echo $form->field($model, 'logoEmpresa')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*', 'required' => ($model->isNewRecord) ? true : false],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png'],
                        'showUpload' => false,
                    ],
                ])->label(false);
                ?>
            </div>
        </div>
        <hr>
        <a data-toggle="collapse" href="#trabajosRutina" role="button" aria-expanded="true" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Información del usuario administrador </label>
        </a>
        <hr>
        <div id="trabajosRutina" class="collapse in">
            <?php if ($model->isNewRecord) { ?>

                <div class="row">
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-user" aria-hidden="true"></i> Nombres
                        </label>
                        <?= $form->field($modelUsuario, 'name')->textInput()->label(false) ?>            
                    </div>
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-user" aria-hidden="true"></i> Apellidos
                        </label>
                        <?= $form->field($modelUsuario, 'surname')->textInput()->label(false) ?>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-id-card-o" aria-hidden="true"></i> Número de identificación
                        </label>
                        <?= $form->field($modelUsuario, 'id_number')->textInput(['type' => 'number'])->label(false) ?>
                    </div>
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> Nombre de usuario
                        </label>
                        <?= $form->field($modelUsuario, 'username')->textInput()->label(false) ?>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-at" aria-hidden="true"></i> Correo electrónico
                        </label>
                        <?=
                        $form->field($modelUsuario, 'email')->widget(MaskedInput::classname(), [
                            'clientOptions' => [
                                'alias' => 'email'
                            ],
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <label>
                            <i class="fa fa-key" aria-hidden="true"></i> Contraseña
                        </label>
                        <?= $form->field($modelUsuario, 'password')->passwordInput()->label(false) ?>        
                    </div>
                </div>
            <?php } else { ?>
                <?php
                $attributes = [
                    'id_number',
                    'name',
                    'surname',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'estado',
                        'format' => 'raw',
                        'value' => $modelUsuario->estado ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Activo',
                                'offText' => 'Inactivo',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                            ]
                        ],
                    ],
                ];

                echo DetailView::widget([
                    'model' => $modelUsuario,
                    'attributes' => $attributes,
                    'panel' => [
                        'type' => DetailView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Datos generales </h3>',
                    ],
                    'buttons1' => '',
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => DetailView::ALIGN_LEFT,
                    'vAlign' => DetailView::ALIGN_CENTER,
                ]);
                ?>
            <?php } ?>
        </div>    
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>

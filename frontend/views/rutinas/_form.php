<?php

use frontend\models\Trabajos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rutinas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rutinas-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Nombre
                </label>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-barcode" aria-hidden="true"></i> Codigo
                </label>
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'type' => 'number'])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo
                </label>
                <?=
                    $form->field($model, 'tipo_rutina')->widget(Select2::classname(), [
                        'data' => ['Normal' => 'Normal', 'Secuencial' => 'Secuencial'],
                        'options' => ['placeholder' => 'Seleccione un tipo ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false)
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Estado
                </label>
                <?=
                    $form->field($model, 'estado')->widget(Select2::classname(), [
                        'data' => ['1' => 'Activo', '2' => 'Inactivo'],
                        'options' => ['placeholder' => 'Estado ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false)
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 4])->label(false) ?>
            </div>
        </div>

        <hr>
        <a data-toggle="collapse" href="#trabajosRutina" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Trabajos de la rutina </label>
        </a>
        <hr>

        <div id="trabajosRutina" class="collapse-in">
            <?php
            echo MultipleInput::widget([
                'model' => $model,
                'attribute' => 'trabajosFormulario',
                'id' => 'cualquiercosa',
                'allowEmptyList' => true,
                'addButtonOptions' => [
                    'class' => 'btn btn-success',
                ],
                'removeButtonOptions' => [
                    'class' => 'btn btn-danger'
                ],
                'columns' => [
                    [
                        'name' => 'rutina_id',
                        'options' => [
                            'class' => 'hidden',
                        ],
                    ],
                    [
                        'name' => 'id',
                        'options' => [
                            'class' => 'hidden',
                        ],
                    ],
                    [
                        'name' => 'trabajo_id',
                        'type' => \kartik\select2\Select2::className(),
                        'title' => 'Trabajo',
                        'options' => [
                            'data' => ArrayHelper::map(Trabajos::find()->all(), 'id', 'nombre'),
                            'class' => 'input-priority',
                        ],
                    ],
                    [
                        'name' => 'cantidad',
                        'title' => 'Cantidad',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority',
                            'type' => 'number'
                        ]
                    ],
                    [
                        'name' => 'observacion',
                        'title' => 'Observacion',
                        'enableError' => true,
                        'options' => []
                    ],
                ],
            ]);
            ?>
        </div>
        <hr>
        <?php if (!$tieneRutinaTrabajo) : ?>
            <div class="alert alert-warning">
                <strong>Para realizar la selección de los insumos y repuestos de la rutina es necesario guardar la rutina y seleccionar los trabajos.</strong>
            </div>
        <?php endif; ?>

        <!-- <a data-toggle="collapse" href="#repuestosRutina" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Insumos y Repuestos de la Rutina </label>
        </a>
        <hr> -->
        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['rutinas/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar y continuar a insumos y repuestos', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    $this->registerJsFile(
        '@web/js/rutinasTrabajos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    ?>

</div>
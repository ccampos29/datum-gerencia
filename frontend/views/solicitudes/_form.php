<?php

use common\models\User;
use frontend\models\Repuestos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Solicitudes */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
?>

<div class="solicitudes-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora de la Solicitud
                </label>
                <?= $form->field($model, 'fecha_hora_solicitud')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora de la solicitud ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo
                </label>
                <?= $form->field($model, 'tipo')->widget(Select2::classname(), [
                    'data'  => ['Repuestos' => 'Repuestos', 'Trabajos' => 'Trabajos'],
                    'options' => ['placeholder' => 'Seleccione un Tipo ...', 'id' => 'tipo'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div>

        <div class="row tipo Trabajos">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo<span style="color:red;">*</span>
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un vehiculo...',
                                'id' => 'select-placa'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlVehiculos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['vehiculos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="tipo Repuestos">
            <hr>
            <a data-toggle="collapse" href="#repuestos" role="button" aria-expanded="false" tabindex="-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> <label>
                    Repuestos </label>
            </a>
            <hr>
            <div id="repuestos" class="collapse in">
                <?= $form->field($model, 'repuestos')->widget(MultipleInput::className(), [
                    'addButtonPosition' => MultipleInput::POS_FOOTER,
                    'columns' => [
                        [
                            'name'  => 'repuesto_id',
                            'type'  => \kartik\select2\Select2::className(),
                            'title' => 'Repuesto<span style="color:red;">*</span>',
                            'options' => [
                                'data' => ArrayHelper::map(Repuestos::find()->where(['inventariable' => 1])->all(), 'id', 'nombre'),
                            ],
                        ],
                        [
                            'name'  => 'cantidad',
                            'title' => 'Cantidad Solicitada<span style="color:red;">*</span>',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name'  => 'usuario_reclama_id',
                            'type'  => \kartik\select2\Select2::className(),
                            'title' => 'Usuario que reclama<span style="color:red;">*</span>',
                            'options' => [
                                'data' => ArrayHelper::map(User::find()->where(['empresa_id' => Yii::$app->user->identity->empresa_id])->all(), 'id', 'name'),
                            ],
                        ],
                        [
                            'name'  => 'observacion',
                            'type'  => 'textarea',
                            'title' => 'Observacion<span style="color:red;">*</span>',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
        </div>

        <div class="tipo Trabajos">
            <hr>
            <a data-toggle="collapse" href="#trabajos" role="button" aria-expanded="false" tabindex="-1">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> <label>
                    Trabajos </label>
            </a>
            <hr>
            <div id="trabajos" class="collapse in">
                <?= $form->field($model, 'trabajos')->widget(MultipleInput::className(), [
                    'addButtonPosition' => MultipleInput::POS_FOOTER,
                    'columns' => [
                        [
                            'name'  => 'trabajo_id',
                            'type'  => \kartik\select2\Select2::className(),
                            'title' => 'Trabajo<span style="color:red;">*</span>',
                            'options' => [
                                'data' => ArrayHelper::map(Trabajos::find()->all(), 'id', 'nombre'),
                            ],
                        ],
                        [
                            'name'  => 'cantidad',
                            'title' => 'Cantidad Solicitada<span style="color:red;">*</span>',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name'  => 'observacion',
                            'type'  => 'textarea',
                            'title' => 'Observacion<span style="color:red;">*</span>',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['solicitudes/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/solicitudesTipos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
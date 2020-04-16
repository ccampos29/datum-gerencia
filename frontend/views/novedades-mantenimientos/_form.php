<?php

use common\models\User;
use frontend\models\PrioridadesMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\widgets\DateTimePicker;

use yii\web\JsExpression;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientos */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlPrioridades = Yii::$app->urlManager->createUrl('prioridades-mantenimientos/prioridades-mantenimientos-list');
$urlTrabajos = Yii::$app->urlManager->createUrl('trabajos/trabajos-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/conductores-list');
?>

<div class="novedades-mantenimientos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
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
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora del Reporte
                </label>
                <?= $form->field($model, 'fecha_hora_reporte')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Fecha y hora del reporte ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd hh:ii',
                            'orientation' => 'bottom',
                        ]
                    ])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Reportada por
                </label>
                <?= $form->field($model, 'usuario_reporte_id')->widget(Select2::classname(), [
                    'data' => !empty($model->usuario_conductor_id) ? [$model->usuario_conductor_id => User::findOne($model->usuario_conductor_id)->name] : [],
                    'options' => [
                        'placeholder' => 'Seleccione un usuario...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hourglass-half " aria-hidden="true"></i> Prioridad
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'prioridad_id')->widget(Select2::classname(), [
                            'data' => [1 => 'Bajo', 2 => 'Medio', 3 => 'Urgente'],
                            'options' => [
                                'placeholder' => 'Seleccione una prioridad...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Usuario Responsable
                </label>
                <?= $form->field($model, 'usuario_responsable_id')->widget(Select2::classname(), [
                    'data' => !empty($model->usuario_conductor_id) ? [$model->usuario_conductor_id => User::findOne($model->usuario_conductor_id)->name] : [],
                    'options' => [
                        'placeholder' => 'Seleccione un usuario...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Medicion
                </label>
                <br>
                <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                <?= $form->field($model, 'medicion')->textInput(['class' => 'hidden', 'id' => 'campo-medicion'])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha Solucion(Posible)
                </label>
                <?= $form->field($model, 'fecha_solucion')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha de la solucion ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'orientation' => 'top',

                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-briefcase" aria-hidden="true"></i> Trabajo
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'trabajo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->trabajo_id) ? [$model->trabajo_id => Trabajos::findOne($model->trabajo_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un trabajo...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTrabajos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['trabajos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un trabajo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 3])->label(false) ?>
            </div>
        </div>

        <div class="form-group">
        <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id.'/']),['class'=>'btn btn-default']);?>
            <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/novedadMantenimientoWebService.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
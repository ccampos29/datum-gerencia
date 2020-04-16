<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use common\models\User;
use frontend\models\CentrosCostos;
use frontend\models\Departamentos;
use frontend\models\EtiquetasMantenimientos;
use frontend\models\GruposVehiculos;
use frontend\models\Municipios;
use frontend\models\Proveedores;
use frontend\models\TiposOrdenes;

use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;

use yii\helpers\ArrayHelper;

use frontend\models\Vehiculos;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajos */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlTiposOrdenes = Yii::$app->urlManager->createUrl('tipos-ordenes/tipos-ordenes-list');
$urlProveedores = Yii::$app->urlManager->createUrl('proveedores/proveedores-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/conductores-list');
$urlEtiquetasMantenimientos = Yii::$app->urlManager->createUrl('etiquetas-mantenimientos/etiquetas-mantenimientos-list');
$urlCentrosCostos = Yii::$app->urlManager->createUrl('centros-costos/centros-costos-list');
$urlGruposVehiculos = Yii::$app->urlManager->createUrl('grupos-vehiculos/primer-grupos-vehiculos-list');
?>

<div class="ordenes-trabajos-form">

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
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Medicion
                </label><br>
                <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                <?= $form->field($model, 'medicion')->textInput(['class' => 'hidden', 'id' => 'campo-medicion'])->label(false) ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora de ingreso
                </label>
                <?= $form->field($model, 'fecha_hora_ingreso')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora de ingreso ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora de la orden
                </label>
                <?= $form->field($model, 'fecha_hora_orden')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora de la orden ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora de cierre(Posible)
                </label>
                <?= $form->field($model, 'fecha_hora_cierre')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora de cierre ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Afecta disponibilidad
                </label>
                <?= $form->field($model, 'disponibilidad')->widget(Select2::classname(), [
                    'data'  => ['0' => 'No', '1' => 'Si'],
                    'options' => ['placeholder' => 'Disponibilidad ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-random" aria-hidden="true"></i> Tipo de Orden
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'tipo_orden_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_orden_id) ? [$model->tipo_orden_id => TiposOrdenes::findOne($model->tipo_orden_id)->descripcion] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un tipo de orden...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposOrdenes,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['tipos-ordenes/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de orden" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Proveedor
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un proveedor...'
                            ],
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
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['proveedores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-id-card-o" aria-hidden="true"></i> Conductor
                </label>
                <?= $form->field($model, 'usuario_conductor_id')->widget(Select2::classname(), [
                    'data' => !empty($model->usuario_conductor_id) ? [$model->usuario_conductor_id => User::findOne($model->usuario_conductor_id)->name] : [],
                    'options' => [
                        'placeholder' => 'Seleccione un conductor...'
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
        </div>
        <hr>

        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-tag" aria-hidden="true"></i> Etiquetas
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'etiqueta_mantenimiento_id')->widget(Select2::classname(), [
                            'data' => !empty($model->etiqueta_mantenimiento_id) ? [$model->etiqueta_mantenimiento_id => EtiquetasMantenimientos::findOne($model->etiqueta_mantenimiento_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione etiquetas...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlEtiquetasMantenimientos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['etiquetas-mantenimientos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una etiqueta" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 4])->label(false) ?>
            </div>
        </div>

        <hr>
        <a data-toggle="collapse" href="#datosAgrupacion" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Datos de agrupacion </label>
        </a>
        <hr>

        <div id="datosAgrupacion" class="collapse">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-map" aria-hidden="true"></i> Departamento
                    </label>
                    <?= $form->field($model, 'departamento_id')->widget(Select2::classname(), [
                        'data'  => ArrayHelper::map(Departamentos::find()->all(), 'id', 'nombre'),
                        'options' => ['placeholder' => 'Seleccione un Departamento ...', 'id' => 'idDepartamento'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false) ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-map-marker" aria-hidden="true"></i> Municipio
                    </label>
                    <?= $form->field($model, 'municipio_id')->widget(DepDrop::classname(), [
                        //'data' => $model->isNewRecord ? [] : [$model->municipio->id => $model->municipio->nombre],
                        'options' => ['id' => 'idMunicipio'],
                        'pluginOptions' => [
                            'depends' => ['idDepartamento'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['vehiculos/municipios'])
                        ]
                    ])->label(false) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-university" aria-hidden="true"></i> Centro de costos
                    </label>
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                                'options' => [
                                    'placeholder' => 'Seleccione un centro de costo...'
                                ],
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
                            ])->label(false); ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="<?= Url::to(['centros-costos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <label>
                        <i class="fa fa-cubes" aria-hidden="true"></i> Grupo
                    </label>
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <?= $form->field($model, 'grupo_vehiculo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->grupo_vehiculo_id) ? [$model->grupo_vehiculo_id => GruposVehiculos::findOne($model->grupo_vehiculo_id)->nombre] : [],
                                'options' => [
                                    'placeholder' => 'Seleccione un grupo...'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlGruposVehiculos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false); ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <a href="<?= Url::to(['grupos-vehiculos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo" target="_blank"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();

    $this->registerJsFile(
        '@web/js/ordenTrabajoWebService.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    $this->registerJsFile(
        '@web/js/ordenTrabajoTrabajo.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    ); ?>

</div>
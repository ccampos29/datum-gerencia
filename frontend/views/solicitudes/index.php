<?php

use common\models\User;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SolicitudesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlUsuarios = Url::to(['user/usuarios-list']);
$usuario = empty($searchModel->creado_por) ? '' : User::findOne($searchModel->creado_por)->name;
$usuario2 = empty($searchModel->actualizado_por) ? '' : User::findOne($searchModel->actualizado_por)->name;
?>
<div class="solicitudes-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Solicitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaCerrar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{cerrar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'cerrar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-record"></span>',
                    Yii::$app->urlManager->createUrl(['solicitudes/cerrar', 'idSolicitud' => $model->id]),
                    [
                        'title' => 'Cerrar Solicitud',
                    ]
                );
            },
        ]
    ];

    $columnaAnular = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{anular}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'anular' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-remove"></span>',
                    Yii::$app->urlManager->createUrl(['solicitudes/anular', 'idSolicitud' => $model->id]),
                    [
                        'title' => 'Anular Solicitud',
                    ]
                );
            },
        ]
    ];

    $columnaProveedor = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{proveedor}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'proveedor' => function ($url, $model) {
                if ($model->estado == 'Aprobada' || $model->estado == 'Aprobada y Descargada') {
                    return Html::a(
                        '<span class="glyphicon glyphicon-user"></span>',
                        Yii::$app->urlManager->createUrl(['cotizaciones/index', 'idSolicitud' => $model->id]),
                        [
                            'title' => 'Asignar Proveedor',
                        ]
                    );
                } else {
                    return null;
                }
            },
        ]
    ];

    $columnaAprobar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{aprobar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'aprobar' => function ($url, $model) {
                if (Yii::$app->user->can('r-jefe-taller-empresa') || Yii::$app->user->can('r-administrativo-empresa')) {
                    if ($model->estado != 'Aprobada' && $model->estado != 'Aprobada y Descargada') {
                        return Html::a(
                            '<span class="glyphicon glyphicon-check"></span>',
                            Yii::$app->urlManager->createUrl(['solicitudes/aprobar', 'idSolicitud' => $model->id]),
                            [
                                'title' => 'Aprobar Solicitud',
                            ]
                        );
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            },
        ]
    ];

    $columnaDescargar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{descargar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'descargar' => function ($url, $model) {
                if (Yii::$app->user->can('r-jefe-inventario-empresa') || Yii::$app->user->can('r-administrativo-empresa')) {
                    if ($model->tipo != 'Trabajos') {
                        if ($model->estado == 'Aprobada') {
                            return Html::a(
                                '<span class="glyphicon glyphicon-download"></span>',
                                Yii::$app->urlManager->createUrl(['solicitudes/descargar', 'idSolicitud' => $model->id]),
                                [
                                    'title' => 'Aprobar Descargue',
                                ]
                            );
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            },
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'fecha_hora_solicitud',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_solicitud',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-M-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_solicitud') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'vehiculo_id',
                'value' => function ($data) {
                    if ($data->vehiculo_id === null) {
                        return 'No Aplica';
                    } else {
                        return $data->vehiculo->placa;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $vehiculo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlVehiculos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'tipo',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Repuestos' => 'Repuestos',
                    'Trabajos' => 'Trabajos',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 'Aprobada':
                            return '<label class="label label-success">Aprobada</label>';
                            break;
                        case 'Cerrada':
                            return '<label class="label label-primary">Cerrada</label>';
                            break;
                        case 'Anulada':
                            return '<label class="label label-danger">Anulada</label>';
                            break;
                        case 'Pendiente':
                            return '<label class="label label-warning">Pendiente</label>';
                            break;
                        case 'Aprobada y Descargada':
                            return '<label class="label label-info">Aprobada y Descargada</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Aprobada' => 'Aprobada',
                    'Cerrada' => 'Cerrada',
                    'Anulada' => 'Anulada',
                    'Pendiente' => 'Pendiente',
                    'Aprobada y Descargada' => 'Aprobada y Descargada'
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            [
                'label' => 'Creada por',
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->name . ' ' . $data->creadoPor->surname;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un usuario ...'],
                    'initValueText' => $usuario,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'creado_el',
            [
                'label' => 'Aprobada por',
                'attribute' => 'actualizado_por',
                'value' => function ($data) {
                    if ($data->estado != 'Aprobada') {
                        return 'Sin aprobar';
                    } else {
                        return $data->actualizadoPor->name . ' ' . $data->actualizadoPor->surname;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $usuario2,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaAprobar,
            $columnaDescargar,
            $columnaCerrar,
            $columnaAnular,
            $columnaProveedor
        ],
    ]); ?>


</div>
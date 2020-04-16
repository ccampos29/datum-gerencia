<?php

use frontend\models\OrdenesTrabajosRepuestos;
use frontend\models\TiposOrdenes;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdenesTrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordenes Trabajos';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlTiposOrdenes = Url::to(['tipos-ordenes/tipos-ordenes-list']);
$tipoOrden = empty($searchModel->tipo_orden_id) ? '' : TiposOrdenes::findOne($searchModel->tipo_orden_id)->descripcion;
?>
<div class="ordenes-trabajos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Orden de Trabajo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaCerrar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{cerrar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'cerrar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-ok"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/cerrar', 'idOrden' => $model->id]),
                    [
                        'title' => 'Cerrar Orden',
                    ]
                );
            },
        ]
    ];

    $columnaTrabajos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{trabajos}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'trabajos' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-paste"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos-trabajos/index', 'idOrden' => $model->id]),
                    [
                        'title' => 'Agregar Trabajos',
                    ]
                );
            },
        ]
    ];

    $columnaRepuestos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{repuestos}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'repuestos' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-cog"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos-repuestos/index', 'idOrden' => $model->id]),
                    [
                        'title' => 'Agregar Repuestos',
                    ]
                );
            },
        ]
    ];

    $columnaNovedades = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{novedades}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'novedades' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-bell"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/formulario-novedades', 'idOrden' => $model->id]),
                    [
                        'title' => 'Validar Novedades',
                    ]
                );
            },
        ]
    ];

    $columnaMantenimientos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{mantenimientos}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'mantenimientos' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-wrench"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/formulario-mantenimientos', 'vehiculoId' => $model->vehiculo_id]),
                    [
                        'title' => 'Validar Mantenimientos',
                    ]
                );
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
                'attribute' => 'vehiculo_id',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:140px;  min-width:140px;  '],
                'value' => function ($data) {
                    return $data->vehiculo->placa;
                },
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
            //'fecha_ingreso',
            //'hora_ingreso',
            [
                'attribute' => 'fecha_hora_orden',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_orden',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_orden') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'fecha_hora_cierre',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_cierre',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_cierre') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            //'medicion',
            //'proveedor_id',
            //'disponibilidad',
            //'observacion',
            [
                'attribute' => 'tipo_orden_id',
                'value' => function ($data) {
                    return $data->tipoOrden->descripcion;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un tipo ...'],
                    'initValueText' => $tipoOrden,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTiposOrdenes,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'total_valor_trabajo',
                'value' => function ($data) {
                    if ($data->total_valor_trabajo === null || $data->total_valor_trabajo == 0) {
                        return 'Sin Trabajos';
                    } else {
                        return '$ ' . number_format($data->total_valor_trabajo, 0, '', '.');
                    }
                },
            ],
            [
                'attribute' => 'total_valor_repuesto',
                'value' => function ($data) {
                    $totalRepuesto = 0;
                    $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $data->id])->all();
                    foreach ($repuestos as $repuesto) {
                            $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad));
                    }
                    if ($totalRepuesto == 0 || $totalRepuesto == null) {
                        return 'Sin Repuestos';
                    } else {
                        return '$ ' . number_format($totalRepuesto, 0, '', '.');
                    }
                },
            ],
            [
                'label' => 'Estado',
                'attribute' => 'estado_orden',
                'value' => function ($data) {
                    switch ($data->estado_orden) {
                        case 0:
                            return '<label class="label label-primary">Cerrada</label>';
                            break;
                        case 1:
                            return '<label class="label label-success">Abierta</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    0 => 'Cerrada',
                    1 => 'Abierta',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'usuario_conductor_id',
            //'etiqueta_mantenimiento_id',
            //'centro_costo_id',
            //'municipio_id',
            //'grupo_vehiculo_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaCerrar,
            $columnaTrabajos,
            $columnaRepuestos,
            $columnaNovedades,
            $columnaMantenimientos
        ],
    ]); ?>


</div>
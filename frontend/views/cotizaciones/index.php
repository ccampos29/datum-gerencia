<?php

use frontend\models\Proveedores;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CotizacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cotizaciones';
$this->params['breadcrumbs'][] = $this->title;

$urlProveedores = Url::to(['proveedores/proveedores-list']);
$proveedor = empty($searchModel->proveedor_id) ? '' : Proveedores::findOne($searchModel->proveedor_id)->nombre;
?>
<div class="cotizaciones-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Cotizacion', ['create', 'idSolicitud' => $idSolicitud], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaOrdenCompra = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{orden}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'orden' => function ($url, $model) {
                if ($model->estado != 'Aprobada') {
                    return Html::a(
                        '<span class="glyphicon glyphicon-share"></span>',
                        Yii::$app->urlManager->createUrl(['cotizaciones/crear-orden-compra?idCotizacion=' . $model->id]),
                        [
                            'title' => 'Crear Orden de Compra',
                        ]
                    );
                } else {
                    return null;
                }
            },
        ]
    ];

    $columnaEnviar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{enviar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'enviar' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-envelope"></span>',
                        Yii::$app->urlManager->createUrl(['cotizaciones/enviar-correo-proveedor?idCotizacion=' .$model->id]),
                        [
                            'title' => 'Enviar Cotizacion al Proveedor',
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
                    Yii::$app->urlManager->createUrl(['cotizaciones/anular?idCotizacion=' . $model->id]),
                    [
                        'title' => 'Anular Cotizacion',
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
                'attribute' => 'fecha_hora_cotizacion',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_cotizacion',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_cotizacion') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'solicitud_id',
                'value' => function ($data) {
                    return $data->solicitud->consecutivo;
                },
            ],
            [
                'attribute' => 'proveedor_id',
                'value' => function ($data) {
                    return $data->proveedor->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una ubicacion ...'],
                    'initValueText' => $proveedor,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlProveedores,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'fecha_hora_vigencia',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_vigencia',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_vigencia') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'observacion',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 'Aprobada':
                            return '<label class="label label-success">Aprobada</label>';
                            break;
                        case 'Pendiente':
                            return '<label class="label label-primary">Pendiente</label>';
                            break;
                        case 'Anulada':
                            return '<label class="label label-danger">Anulada</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Aprobada' => 'Aprobada',
                    'Pendiente' => 'Pendiente',
                    'Anulada' => 'Anulada',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaEnviar,
            $columnaAnular,
            $columnaOrdenCompra
        ],
    ]); ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['solicitudes/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>
<?php

use frontend\models\OrdenesComprasRepuestos;
use frontend\models\Proveedores;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdenesComprasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordenes Compras';
$this->params['breadcrumbs'][] = $this->title;

$urlProveedores = Url::to(['proveedores/proveedores-list']);
$proveedor = empty($searchModel->proveedor_id) ? '' : Proveedores::findOne($searchModel->proveedor_id)->nombre;
?>
<div class="ordenes-compras-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Orden de Compra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaGuardarOrden = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{guardar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'guardar' => function ($url, $model) {
                if ($model->estado != 0) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-ok"></span>',
                        Yii::$app->urlManager->createUrl(['ordenes-compras/guardar', 'idOrdenCompra' => $model->id]),
                        [
                            'title' => 'Guardar la orden de compra',
                        ]
                    );
                } else {
                    return null;
                }
            },
        ]
    ];

    $columnaCrearCompra = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{crear}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'crear' => function ($url, $model) {
                if ($model->estado != 0) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-plus"></span>',
                        Yii::$app->urlManager->createUrl(['ordenes-compras/crear-compra', 'idOrdenCompra' => $model->id]),
                        [
                            'title' => 'Crear compra',
                        ]
                    );
                } else {
                    return null;
                }
            },
        ]
    ]
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'consecutivo',
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
            'forma_pago',
            'direccion',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<label class="label label-success">Abierta</label>';
                            break;
                        case 0:
                            return '<label class="label label-primary">Cerrada</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Abierta',
                    0 => 'Cerrada',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            [
                'attribute' => 'proviene_de',
                'value' => function ($data) {
                    return $data->proviene_de;
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Manualmente' => 'Manualmente',
                    'Cotizaciones' => 'Cotizaciones',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'observacion',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaGuardarOrden,
            $columnaCrearCompra
        ],
    ]); ?>


</div>
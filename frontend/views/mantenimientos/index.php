<?php

use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MantenimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mantenimientos';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlTrabajos = Url::to(['trabajos/trabajos-list']);
$trabajo = empty($searchModel->trabajo_id) ? '' : Trabajos::findOne($searchModel->trabajo_id)->nombre;
$tipoMantenimiento = empty($searchModel->tipo_mantenimiento_id) ? '' : TiposMantenimientos::findOne($searchModel->tipo_mantenimiento_id)->nombre;
$urlTiposMantenimientos = Url::to(['tipos-mantenimientos/tipos-mantenimientos-list']);
?>
<div class="mantenimientos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Mantenimiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaCancelar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{cambiar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'cambiar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-retweet"></span>',
                    Yii::$app->urlManager->createUrl(['mantenimientos/cambiar', 'idMantenimiento' => $model->id]),
                    [
                        'title' => 'Cambiar Estado',
                    ]
                );
            },
        ]
    ];

    $columnaSolucionar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{solucionar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'solucionar' => function ($url, $model) {
                if($model->estado == 'Pendiente'){
                return Html::a(
                    '<span class="glyphicon glyphicon-ok"></span>',
                    Yii::$app->urlManager->createUrl(['mantenimientos/solucionar', 'idMantenimiento' => $model->id, 'idVehiculo' => $model->vehiculo_id]),
                    [
                        'title' => 'Solucionar Mantenimiento',
                    ]
                );
            }
            else {
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
            
            [
                'attribute' => 'vehiculo_id',
                'contentOptions' => ['style' => 'width:120px;  max-width:120px;  '],
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
            [
                'attribute' => 'trabajo_id',
                'value' => function ($data) {
                    return $data->trabajo->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un trabajo ...'],
                    'initValueText' => $trabajo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTrabajos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'tipo_mantenimiento_id',
                'value' => function ($data) {
                    return $data->tipoMantenimiento->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un tipo ...'],
                    'initValueText' => $tipoMantenimiento,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTiposMantenimientos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'fecha_hora_ejecucion',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_ejecucion',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_ejecucion') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'descripcion',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 'Solucionado':
                            return '<label class="label label-success">Solucionado</label>';
                            break;
                        case 'Cancelado':
                            return '<label class="label label-primary">Cancelado</label>';
                            break;
                        case 'Pendiente':
                            return '<label class="label label-danger">Pendiente</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Solucionado' => 'Solucionado',
                    'Pendiente' => 'Pendiente',
                    'Cancelado' => 'Cancelado',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'hora_ejecucion',
            //'medicion',
            //'duracion',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaSolucionar,
            $columnaCancelar
        ],
    ]); ?>


</div>

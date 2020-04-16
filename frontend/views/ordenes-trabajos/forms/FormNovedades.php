<?php

use common\models\User;
use frontend\models\OrdenesTrabajos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Novedades Mantenimiento';

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlTrabajos = Url::to(['trabajos/trabajos-list']);
$trabajo = empty($searchModel->trabajo_id) ? '' : Trabajos::findOne($searchModel->trabajo_id)->nombre;
$urlUsuarios = Url::to(['user/usuarios-list']);
$usuario = empty($searchModel->usuario_reporte_id) ? '' : User::findOne($searchModel->usuario_reporte_id)->name;
$urlOrdenesTrabajos = Url::to(['ordenes-trabajos/ordenes-trabajos-list']);
?>

<?php $columnaSolucion = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{solucion}',
    'header' => "",
    'width' => '1%',
    'buttons' => [
        'solucion' => function ($url, $model) {
            if ($model->estado == 'Pendiente') {
                return Html::a(
                    '<span class="glyphicon glyphicon-ok"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/cambiar-estado-novedad?novedadId=' . $model->id]),
                    [
                        'title' => 'Solucionar la Novedad',
                    ]
                );
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
            'attribute' => 'vehiculo_id',
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
        'medicion',
        [
            'attribute' => 'usuario_reporte_id',
            'value' => function ($data) {
                return $data->usuarioReporte->name . ' ' . $data->usuarioReporte->surname;
            },
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
        [
            'attribute' => 'fecha_hora_reporte',
            'hAlign' => GridView::ALIGN_CENTER,
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'fecha_hora_reporte',
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
                    "apply.daterangepicker" => "function() { apply_filter('fecha_hora_reporte') }",
                    "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                    //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                ],
            ]),
            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
        ],
        [
            'attribute' => 'prioridad_id',
            'value' => function ($data) {
                switch ($data->prioridad_id) {
                    case 1:
                        return 'Bajo';
                        break;
                    case 2:
                        return 'Medio';
                        break;
                    case 3:
                        return 'Urgente';
                        break;
                }
            },
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [
                1 => 'Bajo',
                2 => 'Medio',
                3 => 'Urgente'
            ],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
        ],
        [
            'label' => 'Estado',
            'attribute' => 'estado',
            'value' => function ($data) {
                switch ($data->estado) {
                    case 'Pendiente':
                        return '<label class="label label-danger">Pendiente</label>';
                        break;
                    case 'Solucionada':
                        return '<label class="label label-success">Solucionada</label>';
                        break;
                }
            },
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [
                'Pendiente' => 'Pendiente',
                'Solucionada' => 'Solucionada',
            ],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
        ],
        'proviene_de',
        [
            'attribute' => 'orden_trabajo_id',
            'value' => function ($data) {
                return $data->ordenTrabajo->consecutivo;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => 'Buscar por un checklist ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 0,
                    'language' => [
                        'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                    ],
                    'ajax' => [
                        'url' => $urlOrdenesTrabajos,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ]
            ],
            'filterInputOptions' => ['placeholder' => ''],
        ],
        //'usuario_responsable_id',
        //'observacion',
        //'fecha_solucion',
        //'creado_por',
        //'creado_el',
        //'actualizado_por',
        //'actualizado_el',
        $columnaSolucion
    ],
]); ?>

<div class="form-group pull-left">
    <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
</div>
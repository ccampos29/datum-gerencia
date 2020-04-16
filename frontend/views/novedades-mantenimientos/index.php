<?php

use common\models\User;
use frontend\models\Checklist;
use frontend\models\PrioridadesMantenimientos;
use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\NovedadesMantenimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Novedades Mantenimientos';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlTrabajos = Url::to(['trabajos/trabajos-list']);
$trabajo = empty($searchModel->trabajo_id) ? '' : Trabajos::findOne($searchModel->trabajo_id)->nombre;
$urlUsuarios = Url::to(['user/usuarios-list']);
$usuario = empty($searchModel->usuario_reporte_id) ? '' : User::findOne($searchModel->usuario_reporte_id)->name;
$urlChecklists = Url::to(['checklist/checklist-list']);
$checklist = empty($searchModel->checklist_id) ? '' : Checklist::findOne($searchModel->checklist_id)->consecutivo;
?>
<div class="novedades-mantenimientos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Novedad de Mantenimiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaOrden = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{orden}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'orden' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-share"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/create?idVehiculo='.$model->vehiculo_id.'&idNovedad='.$model->id]),
                    [
                        'title' => 'Crear Orden de Trabajo',
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
                    return $data->usuarioReporte->name.' '.$data->usuarioReporte->surname;
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
                'value'=> function ($data) {
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
                'attribute' => 'checklist_id',
                'value' => function ($data) {
                    if($data->checklist_id == null){
                        return 'No proviene de checklist';
                    }
                    else{
                        return $data->checklist_id;
                    }
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
                            'url' => $urlChecklists,
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

            ['class' => 'yii\grid\ActionColumn'],
            $columnaOrden
        ],
    ]); ?>


</div>
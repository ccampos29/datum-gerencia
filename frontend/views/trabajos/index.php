<?php

use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\TiposMantenimientos;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trabajos';
$this->params['breadcrumbs'][] = $this->title;

$tipoMantenimiento = empty($searchModel->tipo_mantenimiento_id) ? '' : TiposMantenimientos::findOne($searchModel->tipo_mantenimiento_id)->nombre;
$urlTiposMantenimientos = Url::to(['tipos-mantenimientos/tipos-mantenimientos-list']);
$urlSistemas = Url::to(['sistemas/sistemas-list']);
$sistema = empty($searchModel->sistema_id) ? '' : Sistemas::findOne($searchModel->sistema_id)->nombre;
$urlSubsistemas = Url::to(['subsistemas/subsistemas-list']);
$subsistema = empty($searchModel->subsistema_id) ? '' : Subsistemas::findOne($searchModel->subsistema_id)->nombre;
?>
<div class="trabajos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Trabajo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaAcciones = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => "",
        'width' => '1%',
        'template' => '{view}{update}{delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => 'Ver',
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => 'Actualizar',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => 'Eliminar',
                ]);
            },
        ]
    ];

    $columnaAcciones2 = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{periodicidad}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'periodicidad' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-calendar"></span>',
                    Yii::$app->urlManager->createUrl(['periodicidades-trabajos/index', 'idTrabajo' => $model->id]),
                    [
                        'title' => 'Definir periodicidad',
                    ]
                );
            },
        ]
    ];

    $columnaAcciones3 = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{propiedad}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'propiedad' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-option-horizontal"></span>',
                    Yii::$app->urlManager->createUrl(['propiedades-trabajos/index', 'idTrabajo' => $model->id]),
                    [
                        'title' => 'Propiedades del Trabajo',
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
            [
                'attribute' => 'nombre',
                 'headerOptions' => ['style' => 'width:20%'],
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
                'attribute' => 'sistema_id',
                'contentOptions' => [
                    'style' => 'max-width:350px; overflow: auto; white-space: normal; word-wrap: break-word;'
                ],
                'value' => function ($data) {
                    return $data->sistema->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un sistema ...'],
                    'initValueText' => $sistema,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlSistemas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'subsistema_id',
                'value' => function ($data) {
                    return $data->subsistema->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un subsistema ...'],
                    'initValueText' => $subsistema,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlSubsistemas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'cuenta_contable_id',
            /*[
                'label' => '¿Tiene periodicidad?',
                'attribute' => 'periodico',
                'value' => function ($data) {
                    switch ($data->periodico) {
                        case 1:
                            return 'Si';
                            break;
                        case 0:
                            return 'No';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Si',
                    0 => 'No',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],*/
          //  'observacion',
            //'codigo',
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<div class="label label-success">Activo</div>';
                            break;
                        case 0:
                            return '<div class="label label-danger">Inactivo</div>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Activo',
                    0 => 'Inactivo',
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
            ['class' => 'yii\grid\ActionColumn'],
            $columnaAcciones2,
            $columnaAcciones3
        ],
    ]); ?>



</div>
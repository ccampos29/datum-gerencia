<?php

use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdenesTrabajosTrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordenes de Trabajos: Trabajos';
$this->params['breadcrumbs'][] = $this->title;

$urlTrabajos = Url::to(['trabajos/trabajos-list']);
$trabajo = empty($searchModel->trabajo_id) ? '' : Trabajos::findOne($searchModel->trabajo_id)->nombre;
$urlTiposMantenimientos = Url::to(['tipos-mantenimientos/tipos-mantenimientos-list']);
$tipoMantenimiento = empty($searchModel->tipo_mantenimiento_id) ? '' : TiposMantenimientos::findOne($searchModel->tipo_mantenimiento_id)->nombre;
?>
<div class="ordenes-trabajos-trabajos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Agregar Trabajos a la Orden', ['create', 'idOrden' => $idOrden], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaSolicitar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{solicitar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'solicitar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-wrench"></span>',
                    Yii::$app->urlManager->createUrl(['solicitudes/create?idVehiculo='.$model->ordenTrabajo->vehiculo_id]),
                    [
                        'title' => 'Solicitar Trabajo/Repuesto',
                    ]
                );
            },
        ]
    ];

    $columnaNovedad = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{novedad}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'novedad' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-retweet"></span>',
                    Yii::$app->urlManager->createUrl(['ordenes-trabajos/crear-novedad', 'idTrabajo' => $model->id]),
                    [
                        'title' => 'Convertir en Novedad',
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
                'attribute' => 'orden_trabajo_id',
                'value' => function ($data) {
                    return $data->ordenTrabajo->consecutivo;
                },
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
                'attribute' => 'costo_mano_obra',
                'value' => function ($data) {
                        return '$ ' . number_format($data->costo_mano_obra, 0, '', '.');
                },
            ],
            'cantidad',
            [
                'label' => 'Total',
                'value' => function ($data) {
                    return   '$ ' . number_format(($data->cantidad*$data->costo_mano_obra), 0, '', '.');  
                },
            ],
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaSolicitar,
            $columnaNovedad
        ],
    ]); ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>
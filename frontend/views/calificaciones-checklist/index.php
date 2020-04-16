<?php

use frontend\models\CriteriosEvaluacionesDetalle;
use frontend\models\GruposNovedades;
use frontend\models\Novedades;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CalificacionesChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificaciones Checklists';
$this->params['breadcrumbs'][] = $this->title;
$urlDetalles = Url::to(['criterios-evaluaciones-detalle/detalles-list']);
$detalle = empty($model->valor_texto_calificacion) ? '' : CriteriosEvaluacionesDetalle::findOne($model->valor_texto_calificacion)->detalle;
$urlGrupos = Url::to(['grupos-novedades/grupos-novedades-list']);
$grupo = empty($model->grupo_novedad_id) ? '' : GruposNovedades::findOne($model->grupo_novedad_id)->nombre;
$urlNovedades = Url::to(['grupos-novedades/grupos-novedades-list']);
$novedad = empty($model->novedad_id) ? '' : Novedades::findOne($model->novedad_id)->nombre;
?>
<div class="calificaciones-checklist-index">

    
    

    <?php $acciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'width' => '1%',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    Yii::$app->urlManager->createUrl(['calificaciones-checklist/view', 'id' => $model->id, 'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]),
                    [
                        'title' => 'Ver',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Yii::$app->urlManager->createUrl(['calificaciones-checklist/update', 'id' => $model->id, 'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']]),
                    [
                        'title' => 'Actualizar',
                    ]
                );
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'idv' => $_GET['idv'], 'idDocumento' => $_GET['idDocumento']], [
                    'data' => [
                        'confirm' => 'Estas seguro de eliminar este item?',
                        'method' => 'post',
                    ],
                ]);
            },
        ]
    ]; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'Detalle de la calificacion' => 
            [
                'attribute' => 'valor_texto_calificacion',
                'value' => function ($data) {
                    return $data->detalle->detalle;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $detalle,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlDetalles,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Grupo de la novedad' => 
            [
                'attribute' => 'grupo_novedad_id',
                'value' => function ($data) {
                    return $data->grupoNovedad->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $grupo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlGrupos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Novedades' => 
            [
                'attribute' => 'novedad_id',
                'value' => function ($data) {
                    return $data->novedad->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $novedad,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlNovedades,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'tipo_checklist_id',
            //'vehiculo_id',
            //'criterio_calificacion_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

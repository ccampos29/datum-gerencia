<?php

use frontend\models\EstadosChecklist;
use frontend\models\TiposChecklist;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EstadosChecklistConfiguracionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuraciones de Estados Checklist ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-checklist-configuracion-index">


<p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $acciones =
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
            'width' => '1%',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        Yii::$app->urlManager->createUrl(['estados-checklist-configuracion/view', 'id' => $model->tipo_checklist_id]),
                        [
                            'title' => 'Ver',
                        ]
                    );
                },
               'update' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->urlManager->createUrl(['estados-checklist-configuracion/update', 'id' => $model->tipo_checklist_id]),
                        [
                            'title' => 'Actualizar',
                        ]
                    );
                }, 
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->tipo_checklist_id], [
                        'data' => [
                            'confirm' => 'Estas seguro de eliminar este item?',
                            'method' => 'post',
                        ],
                    ]);
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
                'attribute' => 'tipo_checklist_id',
                'value'=>function($data){ return $data->tipoChecklist->nombre;},
                'filter' => ArrayHelper::map(TiposChecklist::find()->all(), 'id', 'nombre'),
                'class' => '\kartik\grid\DataColumn',
                'vAlign' => GridView::ALIGN_MIDDLE,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],
            [ 
                'attribute' => 'estado_checklist_id',
                'value'=>function($data){ return $data->estadoChecklist->estado;},
                'filter' => ArrayHelper::map(EstadosChecklist::find()->all(), 'id', 'estado'),
                'class' => '\kartik\grid\DataColumn',
                'vAlign' => GridView::ALIGN_MIDDLE,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ],
            'porcentaje_maximo_rej',
            'cantidad_maxima_crit',
            //'descripcion:ntext',
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            $acciones,
        ],
    ]); ?>


</div>

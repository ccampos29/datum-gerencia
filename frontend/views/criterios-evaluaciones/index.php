<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CriteriosEvaluacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Criterios Evaluaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criterios-evaluaciones-index">

    

    <!-- <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php $configuracionCriterio = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{configuracion}',
        'header' => "Configuracion",
        'width' => '1%',
        'buttons' => [
            'configuracion' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-cog"></span>',
                        Yii::$app->urlManager->createUrl(['criterios-evaluaciones-detalle/index','idCriterio' => $model->id]),
                        [
                            'title' => 'Configuracion del criterio',
                        ]
                    );
            },
        ]
    ];?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'tipo',
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 0:
                            return '<label class="label label-warning">Inactivo</label>';
                            break;
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    0 => 'Inactivo',
                    1 => 'Activo',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',*/
            //'actualizado_por',
            //'actualizado_el',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}  {delete}',
                
                ],
            $configuracionCriterio
        ],
    ]); ?>


</div>

<?php

use frontend\models\Rutinas;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RutinasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rutinas';
$this->params['breadcrumbs'][] = $this->title;
$rutinas = Rutinas::find()->all();

?>
<div class="rutinas-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Rutina', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $columnaAcciones2 = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{prueba}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'prueba' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-calendar"></span>',
                    Yii::$app->urlManager->createUrl(['periodicidades-rutinas/index', 'idRutina' => $model->id]),
                    [
                        'title' => 'Definir periodicidad',
                    ]
                );
            },
            /*'revivir-contrato' => function ($url, $model) {
            if (
                (Yii::$app->user->can('r-super-admin') ||
                    Yii::$app->user->can('r-secretario-general') ||
                    Yii::$app->user->can('r-presupuesto-revision-contrato') ||
                    Yii::$app->user->can('r-vaf') ||
                    $model->user_responsable_id == Yii::$app->user->id) && !$model->activo
            ) {
                return Html::a('<span class="glyphicon glyphicon-play-circle"></span>', 'javascript:void(0)', [
                    'title' => 'Reactivar contrato',
                    'class' => 'btn-modal-revivir-contrato',
                    'id-contrato' => $model->id
                ]);
            }
        },*/
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'observacion',
            'codigo',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-danger">Inactivo</label>';
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
            [
                'attribute' => 'costo_total',
                'value' => function ($data) {
                    return '$ ' . number_format($data->costo_total, 0, '', '.');
                }
            ],
            //'tipo_rutina',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaAcciones2
        ],
    ]); ?>


</div>
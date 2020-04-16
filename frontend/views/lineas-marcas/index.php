<?php

use frontend\models\LineasMarcas;
use frontend\models\MarcasVehiculos;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LineasMarcasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Líneas de Marcas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lineas-marcas-index">

   

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [ 
                'attribute' => 'descripcion',
                'value' => 'descripcion',
                'filter' => ArrayHelper::map(LineasMarcas::find()->all(), 'descripcion', 'descripcion'),
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
                'attribute' => 'codigo',
                'value' => 'codigo',
                'filter' => ArrayHelper::map(LineasMarcas::find()->all(), 'codigo', 'codigo'),
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
                'attribute' => 'marca_id',
                'value' => 'marca.descripcion',
                'filter' => ArrayHelper::map(MarcasVehiculos::find()->all(), 'id', 'descripcion'),
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
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            */
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use frontend\models\TiposVehiculos;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TiposChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Checklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-checklist-index">

   

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
            'nombre',
            /* [
                'attribute' => 'tipo_vehiculo_id',
                'value'=>function($data){
                    return $data->tipoVehiculo->descripcion;
                },
                'filter' => ArrayHelper::map(TiposVehiculos::find()->all(), 'id', 'descripcion'),
                'class' => '\kartik\grid\DataColumn',
                'vAlign' => GridView::ALIGN_MIDDLE,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Seleccionar...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ],
                ],
            ], */
            'codigo',
            ['attribute'=>'dias', 'label'=>'Periodicidad en Días'],
            ['attribute'=>'horas', 'label'=>'Periodicidad en Horas'],
            'odometro',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

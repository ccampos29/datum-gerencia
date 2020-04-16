<?php

use frontend\models\MarcasVehiculos;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MarcasVehiculosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marcas de Vehículos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marcas-vehiculos-index">

    

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
        [
            'label'=>'Descripción',
            'attribute' => 'id',
            'value' => 'descripcion',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

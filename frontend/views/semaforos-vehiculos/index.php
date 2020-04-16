<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SemaforosVehiculosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semaforos Vehiculos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semaforos-vehiculos-index">

<p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Semaforos', ['create', 'idv' => $_GET['idv']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'indicador',
                'format' => 'raw',
                'value' => function ($data,$index) {
                    $indicadores = ['Bueno'=>['color'=>'green'],'Regular'=>['color'=>'orange'],'Malo'=>['color'=>'red']];
                    return '<span class="semaforo" style="background-color:'.@$indicadores[$data->indicador]["color"].' ">'.$data->indicador.'</span>';
                }
            ],
            [
                'attribute' => 'desde',
                'value' => function ($data) {
                    return '$ '.number_format($data->desde, 0, '', '.');
                },
            ],
            [
                'attribute' => 'hasta',
                'value' => function ($data) {
                    return '$ '.number_format($data->hasta, 0, '', '.');
                },
            ],
            [
                'attribute' => 'vehiculo_id',
                'value' => function ($data) {
                    return $data->vehiculo->placa;
                },
            ],
            
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?= Html::a( '<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to(['/vehiculos']),['class'=>'btn btn-default']);?>
    

</div>

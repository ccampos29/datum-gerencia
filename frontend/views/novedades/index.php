<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\NovedadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Novedades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="novedades-index">


    <p>
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Novedad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'observacion:ntext',
            [
                'attribute' => 'criterio_evaluacion_id',
                'value' => function ($data) {
                    return $data->criterioEvaluacion->nombre;
                }
            ],
            [
                'attribute' => 'grupo_novedad_id',
                'value' => function ($data) {
                    return $data->grupoNovedad->nombre;
                }
            ],
           
            //'empresa_id',

            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

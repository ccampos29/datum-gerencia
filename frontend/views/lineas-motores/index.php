<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LineasMotoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lineas de Motores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lineas-motores-index">

   

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
            'descripcion',
            [
                'attribute' => 'marca_motor_id',
                  'value' => function($data){
                      return $data->marcaMotor->nombre;
                  }
                ],
            'observacion:ntext',
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',
            //'actualizado_por',
            //'actualizado_el',*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

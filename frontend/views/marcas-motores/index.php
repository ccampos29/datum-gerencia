<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MarcasMotoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marcas Motores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marcas-motores-index">

    

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
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',*/
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

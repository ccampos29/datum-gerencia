<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GruposNovedadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos Novedades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-novedades-index">

  
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>  Crear Grupo Novedades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'codigo',
            'comentario:ntext',
            /*[
                'attribute' => 'creado_por',
                'value' => function ($data) {
                    return $data->creadoPor->username;
                }
            ],
            'creado_el',*/
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

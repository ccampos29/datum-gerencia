<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TiposOrdenesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Órdenes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ordenes-index">

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
            'descripcion:ntext',
            'codigo',
            
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

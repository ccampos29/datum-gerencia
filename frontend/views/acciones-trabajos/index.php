<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AccionesTrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acciones Trabajos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acciones-trabajos-index">


    <p>
        <?= Html::a('<span class="glyphicon glyphicon glyphicon-plus"></span>  Crear Acciones Trabajos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
     
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TiposGastosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Gastos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-gastos-index">


    <p>
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Tipo Gasto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',

            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

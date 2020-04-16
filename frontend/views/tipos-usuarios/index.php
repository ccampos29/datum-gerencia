<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TiposUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-usuarios-index">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear tipo de usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'descripcion',
            'permiso_rol',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TiposProveedoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Proveedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-proveedores-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Tipo Proveedor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'codigo',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

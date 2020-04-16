<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EtiquetasMantenimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Etiquetas de Mantenimiento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-mantenimientos-index">

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
            'codigo',
            /*[
                'attribute' => 'empresa_id',
                  'value' => function($data){
                      return $data->empresa_id.' - '.$data->empresa->nombre;
                  }
                ],*/
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

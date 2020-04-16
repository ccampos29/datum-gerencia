<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AlertasTiposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alertas Tipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-tipos-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear tipo de alerta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'medicion',
            [
                'attribute' => 'empresa_id',
                'value' => function ($data) {
                    return $data->empresa->nombre;
                }
            ],
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SemaforosTrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semaforos Trabajos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="semaforos-trabajos-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Semaforos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'indicador',
                'format' => 'raw',
                'value' => function ($data,$index) {
                    $indicadores = ['Muy Eficiente'=>['color'=>'darkgreen'],'Eficiente'=>['color'=>'green'],'Deficiente'=>['color'=>'orange'],'Muy Deficiente'=>['color'=>'red']];
                    return '<span class="semaforo" style="background-color:'.@$indicadores[$data->indicador]["color"].' ">'.$data->indicador.'</span>';
                }

            ],
            'desde',
            'hasta',
            //   'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
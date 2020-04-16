<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AcuerdoPreciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acuerdo Precios';
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['//proveedores/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acuerdo-precios-index">


    <p>
        <?= Html::a('<span class="glyphicon glyphicon glyphicon-list-alt "></span> Crear Acuerdo', ['create', 'id' =>$_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'aplica_para',
            'fecha_inicial',
            'fecha_final',
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-warning">Inactivo</label>';
                            break;
                    }
                },
                'format' => 'raw',
            ],
            //'comentario:ntext',
            //'empresa_id',
           
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
        $sucursales = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{sucursales}',
        'header' => "Sucursales",
        'width' => '1%',
        'buttons' => [
            'sucursales' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-home"></span>',
                        Yii::$app->urlManager->createUrl(['/clientes-sucursales','idSucurusal' => $model->id]),
                        [
                            'title' => 'Añadir sucursales',
                        ]
                    );
            },
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'digito_verificacion',
            'identificacion',
            'regimen',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
            $sucursales
        ],
    ]); ?>


</div>

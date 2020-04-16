<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EstadosChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados Checklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-checklist-index">


    <!-- <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 -->
    <?php $configuracionPersonal = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{configuracion}',
        'header' => "Configuracion",
        'width' => '1%',
        'buttons' => [
            'configuracion' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-cog"></span>',
                        Yii::$app->urlManager->createUrl(['estados-checklist-personal/index','idEstados' => $model->id]),
                        [
                            'title' => 'Configuracion del criterio',
                        ]
                    );
            },
        ]
    ]; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'estado',
            'codigo',
            'dias_alerta',
            'descripcion:ntext',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}  {delete}',
                
                ],
            $configuracionPersonal
        ],
    ]); ?>


</div>

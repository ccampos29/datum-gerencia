<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Titulo;
use backend\models\AuthItem;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var administracion\models\AuthItemSearch $searchModel
 */

$this->title = 'Roles y permisos';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización avanzada';
$this->params['breadcrumbs'][] = $this->title;

$botonCrear = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
        ['class' => 'btn btn-success', 'title' => 'Crear']);

$contenido = [
    'content' => $botonCrear
        . Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], 
            ['class' => 'btn btn-default', 'title' => 'Restablecer vista'])
];

$columnaAcciones = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{update}{delete}',
    'buttons' => [
        'update' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
                    Yii::$app->urlManager->createUrl(['auth-item/view','id' => $model->name,'edit'=>'t']), [
                'title' => Yii::t('yii', 'Edit'),
            ]);}
    ]
];
?>

<div>

<?php
    echo Titulo::widget([
        'tipo' => Titulo::TIPO_PRINCIPAL,
        'titulo' => $this->title,
    ]);

    $columnas = [
        'serial' => ['class'=>'kartik\grid\SerialColumn'],
        'nombre' => [
            'attribute' => 'name',
            'value' => 'name',
            'filter' => ArrayHelper::map(\backend\models\AuthItem::find()->all(), 'name', 'name'),
            'class' => '\kartik\grid\DataColumn',
            'vAlign' => GridView::ALIGN_MIDDLE,

            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => 'Seleccionar...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ],
            ],
        ],
        'tipo' => [
            'attribute' => 'type',
            'value' => 'tipoTexto',
            'filter' => AuthItem::arrayTipo(),
            'class' => '\kartik\grid\DataColumn',
            'vAlign' => GridView::ALIGN_MIDDLE,
            'width' => "10%",

            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => 'Seleccionar...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ],
            ],
        ],  

        $columnaAcciones,
    ];
            
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columnas,
        'bootstrap' => TRUE,
        'responsive' => TRUE,
        'hover' => TRUE,
        'condensed' => TRUE,
        'floatHeader' => TRUE,
        'resizableColumns' => TRUE,
        'panel' => [
            'heading' => '<h3 class="panel-title"></h3>',
            'type' => GridView::TYPE_PRIMARY,
        ],
        'toolbar' => [
            $contenido,
//            '{export}',
            '{toggleData}',
        ],
    ]);
    
    ?>
</div>
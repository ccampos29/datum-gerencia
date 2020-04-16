<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Titulo;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var administracion\models\AuthItemChildSearch $searchModel
 */

$this->title = 'Jerarquía permisos';
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
    'template' => '{delete}',
    'buttons' => [
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
        'padre' => [
            'attribute' => 'parent',
            'value'=>function ($data) {
                $tipo = "[?]";
                if ($data['padre']->type == 1){
                    $tipo = "[r]";
                } elseif ($data['padre']->type == 2) {
                    $tipo = "[p]";
                }
                return "$tipo $data[parent]" ;
            },             

            'filter' => ArrayHelper::map(backend\models\AuthItem::find()->all(), 'name', 'name'),
            'class' => '\kartik\grid\DataColumn',
            'width' => '50%',
            'vAlign' => GridView::ALIGN_MIDDLE,

            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => 'Seleccionar...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ],
            ],
        ],
        'hijo' => [
            'attribute' => 'child',
            'value'=>function ($data) {
                $tipo = "[?]";
                if ($data['hijo']->type == 1){
                    $tipo = "[r]";
                } elseif ($data['hijo']->type == 2) {
                    $tipo = "[p]";
                }
                return "$tipo $data[child]" ;
            },             

            'filter' => ArrayHelper::map(backend\models\AuthItem::find()->all(), 'name', 'name'),
            'class' => '\kartik\grid\DataColumn',
            'width' => '50%',
            'vAlign' => GridView::ALIGN_MIDDLE,

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
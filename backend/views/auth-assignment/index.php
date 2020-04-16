<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Titulo;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var administracion\models\AuthAssignmentSearch $searchModel
 */

$this->title = 'Permisos vs. Usuarios';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Utilidades';
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
        'rol_permiso' => [
            'attribute' => 'item_name',
            'value'=>function ($data) {
                $tipo = $data['authItem']->type == 1 ? "[r]" : "[p]";
                return "$tipo $data[item_name]";
            },             

            'filter' => ArrayHelper::map(backend\models\AuthItem::find()->all(), 'name', 'name'),
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
        'usuario' => [
            'attribute' => 'user_id',
            'value' => 'user.name',
            'filter' => ArrayHelper::map(common\models\User::find()->all(), 'id', 'name'),
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
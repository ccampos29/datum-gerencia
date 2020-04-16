<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Titulo;
use common\components\Ayudante;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var administracion\models\AuthMenuItemSearch $searchModel
 */

$this->title = 'Menús';
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
                Yii::$app->urlManager->createUrl(['auth-menu-item/view','id' => $model->id,'edit'=>'t']), [
                    'title' => 'editar',
                ]);
        }
    ],
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
            'attribute' => 'padre',
            'value' => 'menuPadre.name',
            'filter' => ArrayHelper::map(common\models\AuthMenuItem::find()->all(), 'id', 'name'),
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
        'nombre' => [
            'attribute' => 'name',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'etiqueta' => [
            'attribute' => 'label',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'permiso' => [
            'attribute' => 'auth_item',
            'value' => 'authItem.name',
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
            'attribute' => 'tipo',
            'value' => 'tipo',
            'filter' => Yii::$app->ayudante->datosEnum('auth_menu_item', 'tipo'),
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
        'separador' => [
            'attribute' => 'separador',
            'value'=> function($model) {
                return Ayudante::booleanArray()[$model->separador];
            },
            'filter' => Yii::$app->ayudante->booleanArray(),
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
        'visible' => [
            'attribute' => 'visible',
            'value'=> function($model) {
                return Ayudante::booleanArray()[$model->visible];
            },
            'filter' => Yii::$app->ayudante->booleanArray(),
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

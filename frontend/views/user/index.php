<?php

use yii\helpers\Html;
use common\models\User;
use kartik\grid\GridView;
use common\widgets\Titulo;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $searchModel administracion\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = 'Parametrización básica';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php if (!@$_GET['view'] == true) : ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear usuario', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php
    $columnas = [
        'serial' => ['class' => 'kartik\grid\SerialColumn'],
        'id' => [
            'attribute' => 'id_number',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'nombres' => [
            'attribute' => 'name',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'apellidos' => [
            'attribute' => 'surname',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'nombre_usuario' => [
            'attribute' => 'username',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        'correo' => [
            'attribute' => 'email',
            'format' => 'email',
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        ['class' => 'yii\grid\ActionColumn', 'template' => '{view}', 'visible' => !@$_GET['view']],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{ver_documentos}{informacion-adicional}',
            'header' => '',
            'width' => '1%',
            'buttons' => [
                'ver_documentos' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-folder-open"></span>',
                        Yii::$app->urlManager->createUrl(['usuarios-documentos-usuarios', 'iUs' => $model->id, 'visible' => @$_GET['view']]),
                        [
                            'title' => 'Ver documentos',
                        ]
                    );
                },
                'informacion-adicional' => function ($url, $model) {
                    return '&nbsp&nbsp'.Html::a(
                        '<span class="fa fa-address-card"></span>',
                        Yii::$app->urlManager->createUrl(['user/informacion-adicional', 'id' => $model->id, 'visible' => @$_GET['view']]),
                        [
                            'title' => 'Añadir información complementaria del usuario',
                        ]
                    );
                },
            ]
        ]


    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columnas,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> ' . $this->title . ' </h3>',
        ],
        'responsive' => true,
        'hover' => true,
        'rowOptions' => function ($model) {
            if ($model->estado == \common\models\User::ESTADO_INACTIVO) {
                return ['class' => 'danger'];
            } elseif ($model->estado == \common\models\User::ESTADO_ACTIVO) {
                return ['class' => 'success'];
            } else {
                return ['class' => 'warning'];
            }
        },
        'bootstrap' => true,
        'striped' => false,
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'resizableColumns' => true,
        'responsiveWrap' => false,
        'perfectScrollbar' => true,
        'export' => [
            'label' => 'Descargar',
        ],

        'exportConfig' => [
            GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Combustible Proveedor',],
            GridView::CSV    => ['Exportar CSV'],

        ]
    ]);
    ?>



</div>
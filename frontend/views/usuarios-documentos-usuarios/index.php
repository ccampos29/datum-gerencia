<?php

use common\models\User;
use frontend\models\UsuariosDocumentos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UsuariosDocumentosUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documentos de los usuarios';
$this->params['breadcrumbs'][] = $this->title;
$urlDocumentos = Url::to(['usuarios-documentos/documentos-list']);
$documento = empty($searchModel->usuario_documento_id) ? '' : UsuariosDocumentos::findOne($searchModel->usuario_documento_id)->nombre;
$urlUsuarios = Url::to(['user/nombres-usuarios-list']);
$usuario = empty($searchModel->usuario_id) ? '' : User::findOne($searchModel->usuario_id)->nombre;


?>
<div class="usuarios-documentos-usuarios-index">

    <?php if (!@$_GET['visible'] == true) : ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Crear documento', ['create', 'iUs' => $_GET['iUs']], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php $acciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'header' => '',
        'width' => '1%',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    Yii::$app->urlManager->createUrl(['usuarios-documentos-usuarios/view', 'id' => $model->id, 'iUs' => $_GET['iUs']]),
                    [
                        'title' => 'Ver',
                    ]
                );
            },
            'update' => function ($url, $model) {
                if (!@$_GET['visible'] == true)
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->urlManager->createUrl(['usuarios-documentos-usuarios/update', 'id' => $model->id, 'iUs' => $_GET['iUs']]),
                        [
                            'title' => 'Actualizar',
                        ]
                    );
            },
            'delete' => function ($url, $model) {
                if (!@$_GET['visible'] == true)
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'iUs' => $_GET['iUs']], [
                        'data' => [
                            'confirm' => 'Estas seguro de eliminar este item?',
                            'method' => 'post',
                        ],
                    ]);
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
            'Usuarios' =>
            [
                'attribute' => 'usuario_id',
                'value' => function ($data) {
                    return $data->usuario->name . ' ' . $data->usuario->surname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $usuario,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUsuarios,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Documentos' =>
            [
                'attribute' => 'usuario_documento_id',
                'value' => function ($data) {
                    return $data->usuarioDocumento->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $documento,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlDocumentos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'codigo',
            'valor_documento',
            'Fecha de expiracion' => [
                'attribute' => 'fecha_expiracion',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_expiracion',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_expiracion') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            //'proveedor_id',
            //'fecha_expedicion',
            //'actual',
            //'observacion:ntext',
            //'fecha_vigencia',
            //'centro_costo_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',


            $acciones
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> ' . $this->title . ' </h3>',
        ],
        'responsive' => true,
        'hover' => true,
        'rowOptions' => function ($model) {
            if (!empty($model->estado)) {
                if ($model->estado == \common\models\User::ESTADO_INACTIVO) {
                    return ['class' => 'danger'];
                } elseif ($model->estado == \common\models\User::ESTADO_ACTIVO) {
                    return ['class' => 'success'];
                } else {
                    return ['class' => 'warning'];
                }
            }else{
                return [];
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

        ],
    ]); ?>


</div>
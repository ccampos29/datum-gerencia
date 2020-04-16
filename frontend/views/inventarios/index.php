<?php

use frontend\models\UbicacionesInsumos;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InventariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventarios';
$this->params['breadcrumbs'][] = $this->title;

$urlUbicaciones = Url::to(['ubicaciones-insumos/ubicaciones-insumos-list']);
$ubicacion = empty($searchModel->ubicacion_insumo_id) ? '' : UbicacionesInsumos::findOne($searchModel->ubicacion_insumo_id)->nombre;
?>
<div class="inventarios-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Inventario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaCambiarEstado = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{cambiar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'cambiar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-retweet"></span>',
                    Yii::$app->urlManager->createUrl(['inventarios/cambiar-estado', 'idInventario' => $model->id]),
                    [
                        'title' => 'Cambiar estado',
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
            [
                'attribute' => 'fecha_hora_inventario',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_hora_inventario',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-M-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_hora_inventario') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            [
                'attribute' => 'ubicacion_insumo_id',
                'value' => function ($data) {
                    return $data->ubicacionInsumo->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una ubicacion ...'],
                    'initValueText' => $ubicacion,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUbicaciones,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'observacion',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '',
                'template' => '{view} {delete}',

            ],
        ],
    ]); ?>


</div>
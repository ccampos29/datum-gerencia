<?php

use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\UnidadesMedidas;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RepuestosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repuestos';
$this->params['breadcrumbs'][] = $this->title;

$urlUnidadesMedidas = Url::to(['unidades-medidas/unidades-medidas-list']);
$unidadMedida = empty($searchModel->unidad_medida_id) ? '' : UnidadesMedidas::findOne($searchModel->unidad_medida_id)->nombre;
$urlSistemas = Url::to(['sistemas/sistemas-list']);
$sistema = empty($searchModel->sistema_id) ? '' : Sistemas::findOne($searchModel->sistema_id)->nombre;
$urlSubsistemas = Url::to(['subsistemas/subsistemas-list']);
$subsistema = empty($searchModel->subsistema_id) ? '' : Subsistemas::findOne($searchModel->subsistema_id)->nombre;
?>
<div class="repuestos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Repuesto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaProveedores = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => "",
        'width' => '1%',
        'template' => '{proveedores}',
            'buttons' => [
                'proveedores' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-user"></span>',
                        Yii::$app->urlManager->createUrl(['repuestos-proveedores/index', 'idRepuesto' => $model->id]),
                        [
                            'title' => 'Costos por Proveedor',
                        ]
                    );
                },
        ]
    ];

    $columnaCantidad = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => "",
        'width' => '1%',
        'template' => '{cantidad}',
            'buttons' => [
                'cantidad' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-share-alt"></span>',
                        Yii::$app->urlManager->createUrl(['repuestos-inventariables/ir-cantidad', 'idRepuesto' => $model->id]),
                        [
                            'title' => 'Cantidad Min. - Max.',
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
            //'fabricante',
            //'precio',
            //'observacion',
            'codigo',
            //'estado',
            [
                'attribute' => 'unidad_medida_id',
                'value' => function ($data) {
                    return $data->unidadMedida->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una unidad ...'],
                    'initValueText' => $unidadMedida,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUnidadesMedidas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'grupo_repuesto_id',
            [
                'attribute' => 'sistema_id',
                'value' => function ($data) {
                    if($data->sistema_id != null){
                    return $data->sistema->nombre;
                    } else {
                        return 'Sin sistema';
                    }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un sistema ...'],
                    'initValueText' => $sistema,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlSistemas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'subsistema_id',
                'value' => function ($data) {
                    if($data->subsistema_id != null){
                        return $data->subsistema->nombre;
                        } else {
                            return 'Sin subsistema';
                        }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un subsistema ...'],
                    'initValueText' => $subsistema,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlSubsistemas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'inventariable',
                'value' => function ($data) {
                    switch ($data->inventariable) {
                        case 1:
                            return 'Si';
                            break;
                        case 0:
                            return 'No';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Si',
                    0 => 'No',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'cuenta_contable_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaProveedores,
            $columnaCantidad
        ],
    ]); ?>


</div>
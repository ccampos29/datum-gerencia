<?php

use frontend\models\Conceptos;
use frontend\models\Repuestos;
use frontend\models\UbicacionesInsumos;
use yii\helpers\Html;
use kartik\grid\GridView;

use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InventariosAjustesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventarios Ajustes';
$this->params['breadcrumbs'][] = $this->title;

$urlRepuestos = Url::to(['repuestos/repuestos-list']);
$repuesto = empty($searchModel->repuesto_id) ? '' : Repuestos::findOne($searchModel->repuesto_id)->nombre;
$urlUbicaciones = Url::to(['ubicaciones-insumos/ubicaciones-insumos-list']);
$ubicacion = empty($searchModel->ubicacion_inventario_id) ? '' : UbicacionesInsumos::findOne($searchModel->ubicacion_inventario_id)->nombre;
$urlConceptos = Url::to(['conceptos/conceptos-list']);
$concepto = empty($searchModel->concepto_id) ? '' : Conceptos::findOne($searchModel->concepto_id)->nombre;
?>
<div class="inventarios-ajustes-index">

    

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Ajuste de Inventario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'repuesto_id',
                'value' => function ($data) {
                    return $data->repuesto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un repuesto ...'],
                    'initValueText' => $repuesto,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlRepuestos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'ubicacion_inventario_id',
                'value' => function ($data) {
                    return $data->ubicacionInventario->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un ubicacion ...'],
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
            'cantidad_repuesto',
            [
                'attribute' => 'concepto_id',
                'value' => function ($data) {
                    return $data->concepto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un concepto ...'],
                    'initValueText' => $concepto,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlConceptos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'observaciones:ntext',
            [
                'attribute' => 'fecha_ajuste',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_ajuste',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_ajuste') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            //'usuario_id',
            //'empresa_id',
            [
                'attribute' => 'saldo',
                'value' => function ($data) {
                    return '$ '.number_format($data->saldo, 0, '', '.');
                },
            ],
            
            //'saldo',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

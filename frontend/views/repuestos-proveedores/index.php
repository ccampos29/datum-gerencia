<?php

use frontend\models\Proveedores;
use frontend\models\Repuestos;
use frontend\models\TiposImpuestos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RepuestosProveedoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repuestos por Proveedores';
$this->params['breadcrumbs'][] = $this->title;

$urlRepuestos = Url::to(['repuestos/repuestos-list']);
$repuesto = empty($searchModel->repuesto_id) ? '' : Repuestos::findOne($searchModel->repuesto_id)->nombre;
$urlProveedores = Url::to(['proveedores/proveedores-list']);
$proveedor = empty($searchModel->proveedor_id) ? '' : Proveedores::findOne($searchModel->proveedor_id)->nombre;
$urlImpuestos = Url::to(['tipos-impuestos/tipos-impuestos-list']);
$impuesto = empty($searchModel->impuesto_id) ? '' : TiposImpuestos::findOne($searchModel->impuesto_id)->nombre;
?>
<div class="repuestos-proveedores-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Repuesto por Proveedor', ['create', 'idRepuesto' => $idRepuesto], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

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
                'attribute' => 'proveedor_id',
                'value' => function ($data) {
                    return $data->proveedor->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un proveedor ...'],
                    'initValueText' => $proveedor,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlProveedores,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'valor',
                'value' => function ($data) {
                    return '$ ' . number_format($data->valor, 0, '', '.');
                },
            ],
            [
                'attribute' => 'impuesto_id',
                'value' => function ($data) {
                    return $data->impuesto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un impuesto ...'],
                    'initValueText' => $impuesto,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlImpuestos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'descuento_repuesto',
            [
                'attribute' => 'tipo_descuento',
                'value' => function ($data) {
                    switch ($data->tipo_descuento) {
                        case 1:
                            return '%';
                            break;
                        case 2:
                            return '$';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => '%',
                    2 => '$',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'codigo',
            //'plazo_pago',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['repuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>
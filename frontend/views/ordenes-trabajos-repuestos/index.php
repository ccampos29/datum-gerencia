<?php

use frontend\models\Proveedores;
use frontend\models\Repuestos;
use frontend\models\TiposImpuestos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdenesTrabajosRepuestosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordenes Trabajos: Repuestos';
$this->params['breadcrumbs'][] = $this->title;

$urlRepuestos = Url::to(['repuestos/repuestos-list']);
$repuesto = empty($searchModel->repuesto_id) ? '' : Repuestos::findOne($searchModel->repuesto_id)->nombre;
$urlProveedores = Url::to(['proveedores/proveedores-list']);
$proveedor = empty($searchModel->proveedor_id) ? '' : Proveedores::findOne($searchModel->proveedor_id)->nombre;
$urlImpuestos = Url::to(['tipos-impuestos/tipos-impuestos-list']);
$impuesto = empty($searchModel->impuesto_id) ? '' : TiposImpuestos::findOne($searchModel->impuesto_id)->nombre;
?>
<div class="ordenes-trabajos-repuestos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Agregar Repuestos a la Orden', ['create', 'idOrden' => $idOrden], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $columnaSolicitar = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{solicitar}',
        'header' => "",
        'width' => '1%',
        'buttons' => [
            'solicitar' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-wrench"></span>',
                    Yii::$app->urlManager->createUrl(['solicitudes/index']),
                    [
                        'title' => 'Solicitar Trabajo/Repuesto',
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
            [
                'attribute' => 'orden_trabajo_id',
                'value' => function ($data) {
                    return $data->ordenTrabajo->consecutivo;
                },
            ],
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
                'attribute' => 'costo_unitario',
                'value' => function ($data) {
                    return '$ ' . number_format($data->costo_unitario, 0, '', '.');
                }
            ],
            //'empresa_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            $columnaSolicitar,
        ],
    ]); ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['ordenes-trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>
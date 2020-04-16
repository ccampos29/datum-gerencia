<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\Vehiculos;
use frontend\models\TiposGastos;
use frontend\models\TiposImpuestos;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OtrosGastosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Otros Gastos';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlTipoGasto = Url::to(['tipos-gastos/tipos-gastos-list']);
$tipoGasto = empty($searchModel->tipo_gasto_id) ? '' : TiposGastos::findOne($searchModel->tipo_gasto_id)->nombre;
$urlTiposImpuestos = Url::to(['tipos-impuestos/tipos-impuestos-list']);
$tipoImpuesto = empty($searchModel->tipo_impuesto_id) ? '' : TiposImpuestos::findOne($searchModel->tipo_impuesto_id)->nombre;

?>
<div class="otros-gastos-index">

    

    <p>
         <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
        $email = [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{email-gastos}',
            'header' => "",
            'width' => '1%',
            'buttons' => [
                'email-gastos' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-send"></span>',
                        Yii::$app->urlManager->createUrl(['otros-gastos/email-otros-gastos', 'id' => $model->id]),
                        [
                            'title' => 'Enviar email',
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

            'Placa del vehiculo' => 
            [
                'attribute' => 'vehiculo_id',
                'value' => function ($data) {
                    return $data->vehiculo->placa;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $vehiculo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlVehiculos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],

            'Tipo del gasto' => [
                'attribute' => 'tipo_gasto_id',
                'value' => function ($data) {
                    return $data->tipoGasto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un tipo de gasto ...'],
                    'initValueText' => $tipoGasto,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTipoGasto,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            
            'Fecha del ingreso'=>[
                'attribute' => 'fecha',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'Tipo del impuesto' => 
            [
                'attribute' => 'tipo_impuesto_id',
                'value' => function ($data) {
                    return $data->tipoImpuesto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $tipoImpuesto,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTiposImpuestos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'valor_unitario',
                'value' => function ($data) {
                    return '$ '.number_format($data->valor_unitario, 0, '', '.');
                },
            ],
            [
                'attribute' => 'cantidad_unitaria',
                'value' => function ($data) {
                    return number_format($data->cantidad_unitaria, 0, '', '.');
                },
            ],
            'cantidad_descuento',
            [
                'attribute' => 'total_cost',
                'label'=>'Total',
                'value' => function ($data) {
                    if($data->total_cost>0){
                        if(strtolower($data->tipoImpuesto->nombre)=='iva incluido'){
                            $value = ($data->total_cost)*(1.19);
                           
                        }else{
                            $value = ($data->total_cost);
                        }
                    }else{
                            $value = ($data->valor_unitario)*(1.19);
                            
                    }
                    return number_format($value, 0, '', '.');
                },
            ],
            'codigo_interno',
            'Tipo de descuento' => [
                'attribute' => 'tipo_descuento',
                'value' => function ($data) {
                    switch ($data->tipo_descuento) {
                        case 1:
                            return '%';
                            break;
                        case 0:
                            return '$';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => '%',
                    0 => '$',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            
            
           
            //['label' => 'Tipo del impuesto',
            //'attribute' => 'tipoImpuesto.nombre'],

            //'id',
            //'factura',
            //'observacion:ntext',
            //'empleado_id',
            //'proveedor_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
            //$email
        ],
    ]); ?>


</div>

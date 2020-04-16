<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\Vehiculos;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MedicionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mediciones';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;

?>
<div class="mediciones-index">


    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear automatico', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear manual', ['create', 'idSec'=>1], ['class' => 'btn btn-warning']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php 
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        //'id',
        [
            'attribute' => 'vehiculo_id',
            'value' => function ($data) {
                return $data->vehiculo->placa;
            },
        ],
        'fecha_medicion',
        'hora_medicion',
        'valor_medicion',
        'tipo_medicion',
        'estado_vehiculo',
        
        ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return 'medicion';}]
    ];
    
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'dropdownOptions' => [
            'label' => 'Export All',
            'class' => 'btn btn-secondary'
        ]
    ]); 
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
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
                        'minimumInputLength' => 0,
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

            'Fecha de la medicion'=>[
                'attribute' => 'fecha_medicion',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_medicion',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_medicion') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            'hora_medicion',
            [
                'attribute' => 'valor_medicion',
                'value' => function ($data) {
                    return round($data->valor_medicion);
                },
            ],
            'proviene_de',
            //'estado_vehiculo',
            //'observacion:ntext',
            //'grupo_vehiculo_id',
            //'grupo2_vehiculo_id',
            //'combustible_id',
            
                
            //'viaje_id',
            //'proveedor_id',
            //'empleado_id',
            //'centro_costo_id',
            //'municipio_id',
            //'tipo_medicion',
            //'ciudad_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            
    
            ['class' => 'yii\grid\ActionColumn'],
            
        ],
    ]); ?>


</div>

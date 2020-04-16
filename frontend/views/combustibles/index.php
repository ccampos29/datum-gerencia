<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\Vehiculos;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CombustiblesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Combustibles';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;

?>
<div class="combustibles-index">

    
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        //'id',
        [
            'attribute' => 'vehiculo_id',
            'value' => function ($data) {
                return $data->vehiculo->placa;
            },
        ],
        'fecha',
        '¿El tanqueo fue completo?' => [
            'attribute' => 'tanqueo_full',
            'value' => function ($data) {
                switch ($data->tanqueo_full) {
                    case 1:
                        return 'Si';
                        break;
                    case 0:
                        return 'No';
                        break;
                }
            },
        ],
        'numero_tiquete',
        [
            'attribute' => 'tipo_combustible_id',
            'value' => function ($data) {
                return $data->tipoCombustible->nombre;
            },
        ],
        [
            'attribute' => 'proveedor_id',
            'value' => function ($data) {
                return $data->proveedor->nombre;
            },
        ],
        [
            'attribute' => 'municipio_id',
            'value' => function ($data) {
                return $data->municipio->nombre;
            },
        ],
        [
            'attribute' => 'departamento_id',
            'value' => function ($data) {
                return $data->departamento->nombre;
            },
        ],
        [
            'attribute' => 'pais_id',
            'value' => function ($data) {
                return $data->pais->nombre;
            },
        ],
        [
            'attribute' => 'costo_por_galon',
            'value' => function ($data) {
                return '$ '.number_format($data->costo_por_galon, 0, '', '.');
            },
        ],
        'cantidad_combustible',
        'medicion_actual',
        
        ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return 'combustibles';}]
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
            
            'Fecha del tanqueo'=>[
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
            '¿El tanqueo fue completo?' => [
                'attribute' => 'tanqueo_full',
                'value' => function ($data) {
                    switch ($data->tanqueo_full) {
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
            //'observacion:ntext',
            //'numero_tiquete',
            //'vehiculo_id',
            //'tipo_combustible_id',
            //'proveedor_id',
            //'usuario_id',
            //'centro_costo_id',
            //'municipio_id',
            //'departamento_id',
            //'pais_id',
            //'grupo_vehiculo_id',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
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
            [
                'attribute' => 'costo_por_galon',
                'value' => function ($data) {
                    return '$ '.number_format($data->costo_por_galon, 0, '', '.');
                },
            ],
            
            'cantidad_combustible',
            'medicion_actual',
            ['class' => 'yii\grid\ActionColumn'],
            
        ],
    ]); ?>


</div>

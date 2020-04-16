<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\TiposVehiculos;
use frontend\models\MarcasVehiculos;
use frontend\models\LineasMarcas;
use frontend\models\Municipios;
use frontend\models\TiposCombustibles;
use frontend\models\Vehiculos;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehiculos';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlCiudades = Url::to(['municipios/ciudades-list']);
$ciudad = empty($searchModel->municipio_id) ? '' : Municipios::findOne($searchModel->municipio_id)->nombre;

$urlTipos = Url::to(['tipos-vehiculos/tipos-vehiculos-list']);
$tipo = empty($searchModel->tipo_vehiculo_id) ? '' : TiposVehiculos::findOne($searchModel->tipo_vehiculo_id)->descripcion;
$urlMarcas = Url::to(['marcas-vehiculos/marcas-vehiculos-list']);
$marca = empty($searchModel->marca_vehiculo_id) ? '' : MarcasVehiculos::findOne($searchModel->marca_vehiculo_id)->descripcion;
$urlLineas = Url::to(['lineas-marcas/lineas-marcas-list']);
$linea = empty($searchModel->linea_vehiculo_id) ? '' : LineasMarcas::findOne($searchModel->linea_vehiculo_id)->descripcion;
$urlCombustibles = Url::to(['tipos-combustibles/tipos-combustibles-list']);
$combustible = empty($searchModel->tipo_combustible_id) ? '' : TiposCombustibles::findOne($searchModel->tipo_combustible_id)->nombre;

?>
<div class="vehiculos-index">



    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

    $ver_seguros = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{ver_seguros}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'ver_seguros' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-lock"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-seguros', 'idv' => $model->id]),
                    [
                        'title' => 'Ver seguros',
                    ]
                );
            },
        ]
    ];
    $ver_impuestos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{ver_impuestos}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'ver_impuestos' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-barcode"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-impuestos', 'idv' => $model->id]),
                    [
                        'title' => 'Ver impuestos',
                    ]
                );
            },
        ]
    ];
    $ver_documentos = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{ver_documentos}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'ver_documentos' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-folder-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-documentos', 'idv' => $model->id]),
                    [
                        'title' => 'Ver documentos',
                    ]
                );
            },
        ]
    ];
    $ver_conductor = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{ver_conductor}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'ver_conductor' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-user"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-conductores', 'idv' => $model->id]),
                    [
                        'title' => 'Añadir un conductor',
                    ]
                );
            },
        ]
    ];
    $asociar_equipo = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{asociar_equipo}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'asociar_equipo' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-plane"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos/vehiculos-equipos', 'id' => $model->id]),
                    [
                        'title' => 'Asociar un equipo',
                    ]
                );
            },
        ]
    ];
    $semaforo_vehiculo = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{semaforo_vehiculo}',
        'header' => '',
        'width' => '7%',
        'buttons' => [
            'semaforo_vehiculo' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-dashboard"></span>',
                    Yii::$app->urlManager->createUrl(['semaforos-vehiculos', 'idv' => $model->id]),
                    [
                        'title' => 'Configurar el semaforo',
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
            'placa',
            [
                'attribute' => 'medicion',
                'value' => function ($data) {
                    $test = new Vehiculos();
                    $webService = $test->actionConsultaMedicion($data->id);  
                    $array = json_decode($webService, True);
                    if($array['function']=='odom'){
                        return number_format($array['valor'],0,'','.');
                    }else{
                        return number_format(round($array['valor']/60), 0, '','.');
                    }
                },
            ],
            'Tipo de la medicion' => [
                'attribute' => 'tipo_medicion',
                'value' => function ($data) {
                    if($data->tipo_medicion == 'Hora'){
                        return 'Hora';      
                    }else{
                        return 'KMS';
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Hora',
                    0 => 'KMS',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            'Tipo del Vehiculo' => [
                'attribute' => 'tipo_vehiculo_id',
                'value' => function ($data) {
                    return $data->tipoVehiculo->descripcion;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $tipo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlTipos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],

            'Marca del vehiculo' => [
                'attribute' => 'marca_vehiculo_id',
                'value' => function ($data) {
                    $marcaVehiculo = MarcasVehiculos::findOne($data->marca_vehiculo_id);
                    return !empty($marcaVehiculo)?$marcaVehiculo->descripcion: 'No definido';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $marca,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlMarcas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Linea del vehiculo' => [
                'attribute' => 'linea_vehiculo_id',
                'value' => function ($data) {
                    return $data->lineaVehiculo->descripcion;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $linea,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlLineas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Tipo de servicio' => [
                'attribute' => 'municipio_id',
                'value' => function ($data) {
                    return $data->municipio->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $ciudad,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlCiudades,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Tipo de combustible' => [
                'attribute' => 'tipo_combustible_id',
                'value' => function ($data) {
                    return $data->tipoCombustible->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $combustible,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                            return 'Esperando por resultados...';
                        } "),
                        ],
                        'ajax' => [
                            'url' => $urlCombustibles,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            ['class' => 'yii\grid\ActionColumn'],
            $ver_seguros,
            $ver_impuestos,
            $ver_documentos,
            $ver_conductor,
            $asociar_equipo,
            $semaforo_vehiculo


        ],
    ]); ?>


</div>
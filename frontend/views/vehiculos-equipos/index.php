<?php

use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosEquiposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vincular equipos';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlVehiculosVinculados = Url::to(['vehiculos/vehiculos-equipos-list']);
$vehiculoVinculado = empty($searchModel->vehiculado_vinculado_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_vinculado_id)->placa;





?>
<div class="vehiculos-equipos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idv' => $_GET['idv']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $acciones = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{view}{update}{delete}',
        'width' => '1%',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-equipos/view', 'id' => $model->id, 'idv' => $_GET['idv']]),
                    [
                        'title' => 'Ver',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-equipos/update', 'id' => $model->id, 'idv' => $_GET['idv']]),
                    [
                        'title' => 'Actualizar',
                    ]
                );
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'idv' => $_GET['idv']], [
                    'data' => [
                        'confirm' => 'Estas seguro de eliminar este item?',
                        'method' => 'post',
                    ],
                ]);
            },
        ]
    ]; ?>

    <?= GridView::widget([
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
            'Placa del vinculado' =>
            [
                'attribute' => 'vehiculo_vinculado_id',
                'value' => function ($data) {
                    return $data->vehiculoVinculado->placa;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
                    'initValueText' => $vehiculoVinculado,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlVehiculosVinculados,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'Fecha de expiracion'=>[
                'attribute' => 'fecha_desde',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_desde',
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
                        "apply.daterangepicker" => "function() { apply_filter('fecha_desde') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
            
            [
                'attribute' => 'estado',
                'value' => function ($data) {
                    switch ($data->estado) {
                        case 1:
                            return '<label class="label label-success">Activo</label>';
                            break;
                        case 0:
                            return '<label class="label label-danger">Inactivo</label>';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Activo',
                    0 => 'Inactivo',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            [
                'attribute' => 'medicion',
                'value' => function ($data) {
                    $test = new Vehiculos();
                    $webService = $test->actionConsultaMedicion($data->vehiculo_id);
                    
                    $webServiceVinculado = $test->actionConsultaMedicion($data->vehiculo_vinculado_id);  
                    $array = json_decode($webService, True);
                    $arrayVinculado = json_decode($webServiceVinculado, True);
                    if($array['function']=='odom'){
                        $medicion = $array['valor'];
                    }else{
                        $medicion = round($array['valor']/60);
                    }
                    if($arrayVinculado['function']=='odom'){
                        $medicionVinculado =$array['valor'];
                    }else{
                        $medicionVinculado = round($array['valor']/60);
                    }
                    return number_format (($medicion+$medicionVinculado),0,'','.');
                },
            ],
            
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            $acciones
        ],
    ]); ?>
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
     

</div>

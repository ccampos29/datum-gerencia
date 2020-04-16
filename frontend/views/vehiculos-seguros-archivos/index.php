<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\TiposSeguros;
use frontend\models\Vehiculos;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosSegurosArchivosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$tipo = TiposSeguros::findOne($_GET['idSeguro'])->nombre;
$this->title = 'Cargar archivo para: ' . $tipo;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros', 'url' => ['vehiculos-seguros/index', 'idv' => $_GET['idv'], 'idSeguro' => $_GET['idSeguro']]];
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlSeguros = Url::to(['tipos-seguros/tipos-seguros-list']);
$seguro = empty($searchModel->tipo_seguro_id) ? '' : TiposSeguros::findOne($searchModel->tipo_seguro_id)->nombre;





?>
<div class="vehiculos-seguros-archivos-index">

    <?php if (!@$_GET['visible'] == true) : ?>
        <p>
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idv' => $_GET['idv'], 'idSeguro' => $_GET['idSeguro']], ['class' => 'btn btn-success']); ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    $acciones = [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'header' => '',
        'width' => '1%',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-seguros-archivos/view', 'id' => $model->id, 'idv' => $_GET['idv'], 'idSeguro' => $_GET['idSeguro']]),
                    [
                        'title' => 'Ver',
                    ]
                );
            },
            'update' => function ($url, $model) {
                if(!@$_GET['visible'])
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-seguros-archivos/update', 'id' => $model->id, 'idv' => $_GET['idv'], 'idSeguro' => $_GET['idSeguro']]),
                    [
                        'title' => 'Actualizar',
                    ]
                );
            },
            'delete' => function ($url, $model) {
                if(!@$_GET['visible'])
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'idv' => $_GET['idv'], 'idSeguro' => $_GET['idSeguro']], [
                    'data' => [
                        'confirm' => 'Estas seguro de eliminar este item?',
                        'method' => 'post',
                    ],
                ]);
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
            'Tipo del seguro' =>
            [
                'attribute' => 'tipo_seguro_id',
                'value' => function ($data) {
                    return $data->tipoSeguro->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un documento ...'],
                    'initValueText' => $seguro,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlSeguros,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            //'nombre_archivo_original',
            //'nombre_archivo',
            //'ruta_archivo',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',
            //'es_actual',

            $acciones
        ],
    ]); ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['vehiculos-seguros/index','idv'=>$_GET['idv']]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>


</div>
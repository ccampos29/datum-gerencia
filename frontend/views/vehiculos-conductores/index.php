<?php

use common\models\User;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosConductoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehiculos Conductores';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos', 'url' =>['vehiculos/index']];
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlConductores = Url::to(['user/tipos-usuarios-list']);
$conductores = empty($searchModel->conductor_id) ? '' : User::findOne($searchModel->conductor_id)->name;

?>
<div class="vehiculos-conductores-index">

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
                    Yii::$app->urlManager->createUrl(['vehiculos-conductores/view', 'id' => $model->id, 'idv' => $_GET['idv']]),
                    [
                        'title' => 'Ver',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Yii::$app->urlManager->createUrl(['vehiculos-conductores/update', 'id' => $model->id, 'idv' => $_GET['idv']]),
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
            'Tipo del documento' => 
            [
                'attribute' => 'conductor_id',
                'value' => function ($data) {
                    return $data->conductor->name.' '.$data->conductor->surname;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un documento ...'],
                    'initValueText' => $conductores,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlConductores,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'fecha_desde',
            'fecha_hasta',
            [
                'attribute' => 'estado',
                'label'=>'Estado',
                'value' => function ($data) {
                    return ($data->estado == 1) ? 'Activo' : 'Inactivo' ;
                }
            ],
            //'dias_alerta',
            //'principal',
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

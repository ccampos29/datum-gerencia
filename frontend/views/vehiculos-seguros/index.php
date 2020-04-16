<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\Vehiculos;
use frontend\models\TiposSeguros;
use frontend\models\Proveedores;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosDocumentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seguros de los vehiculos';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlSeguros = Url::to(['tipos-otros-documentos/tipos-otros-documentos-list']);
$seguro = empty($searchModel->tipo_seguro_id) ? '' : TiposSeguros::findOne($searchModel->tipo_seguro_id)->nombre;
$urlProveedores = Url::to(['proveedores/proveedores-list']);
$proveedor = empty($searchModel->proveedor_id) ? '' : Proveedores::findOne($searchModel->proveedor_id)->nombre;
if (!empty($_GET['idv'])){
    $var=Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idv' => $_GET['idv']], ['class' => 'btn btn-success']);
}else{
    $var=Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']);
}
?>
<div class="vehiculos-seguros-index">

    

    <p>
        <?= $var ?>
        <?php 
            if(Yii::$app->user->can('p-vehiculos-seguros-crear')):
        ?>
        <?php 
            endif;
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
        
        $columnaAcciones2 = [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{ver_seguros}',
            'header' => "",
            'width' => '1%',
            'buttons' => [
                'ver_seguros' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-folder-open"></span>',
                            Yii::$app->urlManager->createUrl(['vehiculos-seguros-archivos', 'idv' => $model->vehiculo_id, 'idSeguro'=>$model->tipo_seguro_id]),
                            [
                                'title' => 'Ver seguros',
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
            'Proveedor' => 
            [
                'attribute' => 'proveedor_id',
                'value' => function ($data) {
                    return $data->proveedor->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un vehiculo ...'],
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
            'numero_poliza',
            [
                'attribute' => 'valor_seguro',
                'value' => function ($data) {
                    return '$ '.number_format($data->valor_seguro, 0, '', '.');
                },
            ],
            'fecha_expiracion:date',
            ['class' => 'yii\grid\ActionColumn'],
            $columnaAcciones2
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['/vehiculos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
    </div>
</div>

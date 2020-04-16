<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\Vehiculos;
use frontend\models\TiposImpuestos;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehiculosDocumentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Impuestos de los vehiculos';
$this->params['breadcrumbs'][] = $this->title;
$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlImpuestos = Url::to(['tipos-impuestos/tipos-impuestos-list']);
$impuesto = empty($searchModel->tipo_impuesto_id) ? '' : TiposImpuestos::findOne($searchModel->tipo_impuesto_id)->nombre;
if (!empty($_GET['idv'])){
    $var=Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create', 'idv' => $_GET['idv']], ['class' => 'btn btn-success']);
}else{
    $var=Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['create'], ['class' => 'btn btn-success']);
}
?>
<div class="vehiculos-impuestos-index">

    

    <p>
        <?= $var ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
         
        $columnaAcciones2 = [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{cargar_archivos}',
            'header' => "",
            'width' => '1%',
            'buttons' => [
                'cargar_archivos' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-folder-open"></span>',
                            Yii::$app->urlManager->createUrl(['vehiculos-impuestos-archivos', 'idv' => $model->vehiculo_id, 'idImpuesto'=>$model->tipo_impuesto_id]),
                            [
                                'title' => 'Cargar archivos',
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
            'Tipo del impuesto' => 
            [
                'attribute' => 'tipo_impuesto_id',
                'value' => function ($data) {
                    return $data->tipoImpuesto->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un documento ...'],
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
            [
                'attribute' => 'valor_impuesto',
                'value' => function ($data) {
                    return '$ '.number_format($data->valor_impuesto, 0, '', '.');
                },
            ],
            'Fecha de expiracion'=>[
                'attribute' => 'fecha_expiracion',
                'hAlign' => GridView::ALIGN_CENTER,
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'fecha_expiracion',
                    'presetDropdown' => false,
                    'convertFormat' => false,
                    'options' => [
                        'class' => 'form-control range-value',
                    ],
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD HH:MM:SS',
                        'locale' => [
                            'format' => 'YYYY-MM-DD HH:MM:SS',
                            'cancelLabel' => 'Limpiar'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('fecha_expiracion') }",
                        "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                        //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                    ],
                ]),
                'filterInputOptions' => ['placeholder' => 'Seleccione...'],
            ],
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

<?php

use frontend\models\Repuestos;
use frontend\models\UbicacionesInsumos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RepuestosInventariablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cantidades de los Repuestos';
$this->params['breadcrumbs'][] = $this->title;

$urlRepuestos = Url::to(['repuestos/repuestos-list']);
$repuesto = empty($searchModel->repuesto_id) ? '' : Repuestos::findOne($searchModel->repuesto_id)->nombre;
$urlUbicaciones = Url::to(['ubicaciones-insumos/ubicaciones-insumos-list']);
$ubicacion = empty($searchModel->ubicacion_id) ? '' : UbicacionesInsumos::findOne($searchModel->ubicacion_id)->nombre;
?>
<div class="repuestos-inventariables-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Repuesto Inventariable', ['create', 'idRepuesto' => $idRepuesto], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
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
                'attribute' => 'ubicacion_id',
                'value' => function ($data) {
                    if(!empty($data->ubicacion_id)){
                    return $data->ubicacion->nombre;
                    }
                    else{
                        return 'Sin Ubicacion';
                    }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por un ubicacion ...'],
                    'initValueText' => $ubicacion,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlUbicaciones,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            'cantidad',
            [
                'attribute' => 'valor_unitario',
                'value' => function ($data) {
                        return '$ ' . number_format($data->valor_unitario, 0, '', '.');
                },
            ],
            'cantidad_minima',
            'cantidad_maxima',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['repuestos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>

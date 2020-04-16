<?php

use frontend\models\TiposVehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PropiedadesTrabajosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Propiedades Trabajos';
$this->params['breadcrumbs'][] = $this->title;

$urlTiposVehiculos = Url::to(['tipos-vehiculos/tipos-vehiculos-list']);
$tipoVehiculo = empty($searchModel->tipo_vehiculo_id) ? '' : TiposVehiculos::findOne($searchModel->tipo_vehiculo_id)->descripcion;
$urlTrabajos = Url::to(['trabajos/trabajos-list']);
$trabajo = empty($searchModel->trabajo_id) ? '' : TiposVehiculos::findOne($searchModel->trabajo_id)->trabajo;
?>
<div class="propiedades-trabajos-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Propiedad de Trabajo', ['create', 'idTrabajo' => $idTrabajo], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'trabajo_id',
                'value' => function ($data) {
                    return $data->trabajo->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una unidad ...'],
                    'initValueText' => $trabajo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'tipo_vehiculo_id',
                'value' => function ($data) {
                    return $data->tipoVehiculo->descripcion;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una unidad ...'],
                    'initValueText' => $tipoVehiculo,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlTiposVehiculos,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'label' => 'Duración (Minutos)',
                'attribute' => 'duracion',
            ],
            [
                'attribute' => 'duracion',
                'value' => function ($data) {
                    return '$ ' . number_format($data->costo_mano_obra, 0, '', '.');
                }
            ],
            'cantidad_trabajo',
            //'repuesto_id',
            //'cantidad_repuesto',
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',
            //'empresa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['trabajos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>
</div>
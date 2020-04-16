<?php

use frontend\models\Rutinas;
use frontend\models\Vehiculos;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PeriodicidadesRutinasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Periodicidades de Rutinas';
$this->params['breadcrumbs'][] = $this->title;

$urlVehiculos = Url::to(['vehiculos/vehiculos-list']);
$vehiculo = empty($searchModel->vehiculo_id) ? '' : Vehiculos::findOne($searchModel->vehiculo_id)->placa;
$urlRutinas = Url::to(['rutinas/rutinas-list']);
$rutina = empty($searchModel->rutina_id) ? '' : Rutinas::findOne($searchModel->rutina_id)->nombre;
?>
<div class="periodicidades-rutinas-index">

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Crear Periodicidad de Rutina', ['create', 'idRutina' => $idRutina], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'vehiculo_id',
                'value' => function ($data) {
                    return $data->vehiculo->placa;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una ubicacion ...'],
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
                'attribute' => 'rutina_id',
                'value' => function ($data) {
                    return $data->rutina->nombre;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Buscar por una ubicacion ...'],
                    'initValueText' => $rutina,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression(" function () {
                        return 'Esperando por resultados...';
                    } "),
                        ],
                        'ajax' => [
                            'url' => $urlRutinas,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'attribute' => 'unidad_periodicidad',
                'value' => function ($data) {
                    switch ($data->unidad_periodicidad) {
                        case 'Kilometros':
                            return 'Km';
                            break;
                        case 'Dias':
                            return 'Dias';
                            break;
                        case 'Horas':
                            return 'Horas';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    'Kilometros' => 'Km',
                    'Dias' => 'Dias',
                    'Horas' => 'Horas',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            'trabajo_normal',
            'trabajo_bajo',
            'trabajo_severo',
            [
                'attribute' => 'tipo_periodicidad',
                'value' => function ($data) {
                    switch ($data->tipo_periodicidad) {
                        case 1:
                            return 'Por Vehiculo';
                            break;
                        case 2:
                            return 'Por Linea de Vehiculo';
                            break;
                        case 3:
                            return 'Por tipo de Vehiculo y tipo de Motor';
                            break;
                        case 4:
                            return 'Por tipo de Vehiculo';
                            break;
                        case 5:
                            return 'Por tipo de Motor';
                            break;
                    }
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    1 => 'Por Vehiculo',
                    2 => 'Por Linea de Vehiculo',
                    3 => 'Por tipo de Vehiculo y tipo de Motor',
                    4 => 'Por tipo de Vehiculo',
                    5 => 'Por tipo de Motor',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
            ],
            //'creado_por',
            //'creado_el',
            //'actualizado_por',
            //'actualizado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<div class="form-group pull-left">
        <a class="btn btn-default" href="<?= Url::to(['rutinas/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
    </div>


</div>

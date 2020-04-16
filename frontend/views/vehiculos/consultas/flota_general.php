<?php

use frontend\models\CentrosCostos;
use frontend\models\TiposCombustibles;
use frontend\models\TiposVehiculos;
use frontend\models\Vehiculos;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\CombustiblesSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Consulta de Flota General';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="combustibles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['flota-general'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha Compra
                </label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_1',
                    'attribute2' => 'fecha_2',
                    'options' => ['placeholder' => 'Fecha Inicial'],
                    'options2' => ['placeholder' => 'Fecha Final'],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ]); ?>
            </div>

            <div class="col-sm-4">
            <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($model, 'placa')->widget(Select2::classname(), [
                    'data' => !empty($model->placa) ? [$model->placa => Vehiculos::findOne($model->placa)->placa] : [],
                    'options' => ['id' => 'select-placa'],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un vehículo',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-4">
                <label for="">Tipo de Vehículo</label>
                    <?= $form->field($model, 'tipo_vehiculo_id')->widget(Select2::classname(), [
                        'data' => !empty($model->tipo_vehiculo_id) ? [$model->tipo_vehiculo_id => TiposVehiculos::findOne($model->tipo_vehiculo_id)->descripcion] : [],
                        'options' => ['placeholder' => 'Seleccione un tipo de vehiculo',],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => Yii::$app->urlManager->createUrl('tipos-vehiculos/tipos-vehiculos-list'),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false) ?>
            </div>
            
            </div>
            <div class="row">
                <div class="col-sm-4">
                <label>
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Tipo de combustible
                </label>
                <?= $form->field($model, 'tipo_combustible_id')->widget(Select2::classname(), [
                    'data' => !empty($model->tipo_combustible_id) ? [$model->tipo_combustible_id => TiposCombustibles::findOne($model->tipo_combustible_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un Tipo de Combustible',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('tipos-combustibles/tipos-combustibles-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
                </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>  Buscar', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-refresh" aria-hidden="true"></i> Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>
            <div class="row" style="margin-top:40px;">
                <div class="col-sm-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'panel' => [
                            'type' => GridView::TYPE_PRIMARY,
                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> ' . $this->title . ' </h3>',
                        ],
                        'responsive' => true,
                        'hover' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Placa',
                                'value' => 'placa',
                            ],
                            [
                                'label' => 'Marca',
                                'attribute' => 'marca_vehiculo_id',
                                'value' => 'marcaVehiculo.descripcion',
                            ],
                            [
                                'label' => 'Línea',
                                'attribute' => 'linea_vehiculo_id',
                                'value' => 'lineaVehiculo.descripcion',
                            ],
                            [
                                'label' => 'Tipo vehículo',
                                'value' => 'tipoVehiculo.descripcion',
                            ],
                            'modelo',
                            'color',
                            'numero_chasis',
                            'numero_serie',
                            [
                                'label'=>'Centro Costo',
                                'attribute' => 'centro_costo_id',
                                'value' => 'centroCosto.nombre',
                            ],
                            [
                                'label'=>'Combustible', 'value' => 'tipoCombustible.nombre'
                            ],
                            [
                                'label'=>'Motor',
                                'attribute' => 'motor_id',
                                'value' => 'motor.nombre',
                            ],
                            [
                                'label'=>'Línea Motor',
                                'attribute' => 'linea_motor_id',
                                'value' => 'lineaMotor.descripcion',
                            ],
                            'fecha_compra',
                            'medicion_compra',
                            'propietario_vehiculo',
                            [
                                'attribute' => 'Medición',
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
                            [
                                'attribute' => 'id', 'visible' => false
                            ],
                            'tipo_medicion',
                            'tipo_trabajo'
                        ],
                        'export' => [
                            'label' => 'Descargar',
                        ],

                        'exportConfig' => [
                            GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Combustible Proveedor',],
                            GridView::CSV    => ['Exportar CSV'],

                        ]
                    ]); ?>
                </div>
            </div>


        </div>



        <?php ActiveForm::end(); ?>

    </div>
    <?php Pjax::end(); ?>
<?php

use common\models\User;
use frontend\models\CentrosCostos;
use frontend\models\Vehiculos;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\CombustiblesSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Trabajos Realizados por Vehículos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="combustibles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['recorrido-vehiculos'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
        <div class="row">
           
            
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($model, 'id')->widget(Select2::classname(), [
                    'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
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
                            'attribute' => 'vehiculo_id',
                            'value'=>function($data){
                                return $data->vehiculo->placa;
                            }
                        ],
                        [
                            'label' => 'Tipo vehículo',
                            'value' => 'vehiculo.tipoVehiculo.descripcion',
                        ],
                        'kms_recorrido',
                        'dias_recorridos',
                        'promedio_dias_recorridos',
                        [
                            'label' => 'Promedio Recorrido por Día Configurado',
                            'value'=>function($data){
                                return $data->vehiculo->distancia_promedio;
                            }
                        ],
                        [
                            'label' => 'Tipo Medición',
                            'value'=>function($data){
                                return $data->vehiculo->tipo_medicion;
                            }
                        ],
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
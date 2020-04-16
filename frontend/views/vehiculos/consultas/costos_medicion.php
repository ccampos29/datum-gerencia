<?php

use common\models\User;
use frontend\models\CentrosCostos;
use frontend\models\OrdenesTrabajosRepuestos;
use frontend\models\OrdenesTrabajos;
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

$this->title = 'Costos por Medición';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="combustibles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['costos-medicion'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Periodo
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
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '','thousandSeparator' => ',',
                    'decimalSeparator' => '.',
                    'currencyCode' => '$'],
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
                            'label' => 'Tipo vehículo',
                            'value' => 'tipo_vehiculo',
                        ],
                        [
                            'label' => 'Marca',
                            'attribute' => 'marca_vehiculo_id',
                            'value' => 'marca',
                        ],
                        [
                            'label' => 'Línea',
                            'attribute' => 'linea_vehiculo_id',
                            'value' => 'linea',
                        ],
                        [
                            'label' => 'Trabajos',
                            'value'=> function($data){
                                return '$ '.number_format($data['total_valor_trabajo'],0,'','.');
                            }
                        ],
                        [
                            'label' => 'Repuestos',
                            'value'=> function($data){
                                $totalRepuesto = 0;
                                $ordenes = OrdenesTrabajos::find()->andFilterWhere(['between', 'fecha_hora_orden', $data['fecha1'], $data['fecha2']])->andFilterWhere(['vehiculo_id'=>$data['id_vehi']])->all();
                                if(!empty($ordenes)){
                                    foreach($ordenes as $orden){
                                        $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $orden->id])->all();
                                        foreach ($repuestos as $repuesto) {
                                            if ($repuesto->tipo_descuento == 1) {
                                                $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) * (1 - ($repuesto->descuento / 100)));
                                            } else {
                                                $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) - $repuesto->descuento);
                                            }
                                        }
                                     
                                    } 
                                    if ($totalRepuesto == 0 || $totalRepuesto == null) {
                                        return 'Sin Repuestos';
                                    } else {
                                        return '$ ' . number_format($totalRepuesto, 0, '', '.');
                                    }
                                }else{
                                    return 'Sin Repuestos';
                                }
                                                               
                            }
                        ],
                        [
                            'label' => 'Combustibles',
                            'value'=> function($data){
                                return '$ '.number_format($data['total_combustible'],0,'','.');
                            }                        ],
                        [
                            'label' => 'Otros Gastos',
                            'value'=> function($data){
                                return '$ '.number_format($data['total_otros_gastos'],0,'','.');
                            }                         ],
                        [
                            'label' => 'Total de Gastos',
                            'value'=> function($data){
                                $totalRepuesto = 0;
                                $t = 0;
                                $ordenes = OrdenesTrabajos::find()->andFilterWhere(['between', 'fecha_hora_orden', $data['fecha1'], $data['fecha2']])->andFilterWhere(['vehiculo_id'=>$data['id_vehi']])->all();
                                if(!empty($ordenes)){
                                    foreach($ordenes as $orden){
                                        $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $orden->id])->all();
                                        foreach ($repuestos as $repuesto) {
                                            if ($repuesto->tipo_descuento == 1) {
                                                $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) * (1 - ($repuesto->descuento / 100)));
                                            } else {
                                                $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) - $repuesto->descuento);
                                            }
                                        }
                                     
                                    } 
                                    if ($totalRepuesto == 0 || $totalRepuesto == null) {
                                        return 'Sin Repuestos';
                                    } else {
                                        $t = $totalRepuesto;
                                    }
                                }else{
                                    $t = 0;
                                }
                                $suma = $t+$data['total_valor_trabajo']+$data['total_combustible']+$data['total_otros_gastos'];
                                return '$ '.number_format($suma,0,'','.');
                            }                            ],
                        [
                            'label' => 'Recorrido',
                            'value' => 'recorrido'
                        ],
                        [
                            'label' => 'Medición',
                            'value' => 'medicion'
                        ],
                        [
                            'label' => 'Costo x Unidad',

                            'value'=> function($data){
                                return '$ '.@number_format( ($data['costo_total']/ $data['recorrido']),0,'','.');
                            }                          ],
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                       
                    ],
                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Costos Medición',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>


    </div>



    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
<?php

use frontend\models\OrdenesTrabajosRepuestos;
use frontend\models\Proveedores;
use frontend\models\Vehiculos;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Costo Ordenes de Trabajos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="ordenes-trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['costo-ordenes-trabajos'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="container-fluid col-sm-12">
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Ordenes de Trabajos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'consecutivo',
                        [
                            'attribute' => 'vehiculo_id',
                            'value' => function ($data) {
                                return $data->vehiculo->placa;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(Vehiculos::find()->all(), 'id', 'placa'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'fecha_hora_orden',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'filterType' => GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions' => ([
                                'attribute' => 'fecha_hora_orden',
                                'presetDropdown' => false,
                                'convertFormat' => false,
                                'options' => [
                                    'class' => 'form-control range-value',
                                ],
                                'pluginOptions' => [
                                    'separator' => ' - ',
                                    'format' => 'YYYY-M-DD',
                                    'locale' => [
                                        'format' => 'YYYY-MM-DD',
                                        'cancelLabel' => 'Limpiar'
                                    ],
                                ],
                                'pluginEvents' => [
                                    "apply.daterangepicker" => "function() { apply_filter('fecha_hora_orden') }",
                                    "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                                    //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                                ],
                            ]),
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'proveedor_id',
                            'value' => function ($data) {
                                return $data->proveedor->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(Proveedores::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'label' => 'Estado',
                            'attribute' => 'estado_orden',
                            'value' => function ($data) {
                                switch ($data->estado_orden) {
                                    case 0:
                                        return '<label class="label label-primary">Cerrada</label>';
                                        break;
                                    case 1:
                                        return '<label class="label label-success">Abierta</label>';
                                        break;
                                }
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                0 => 'Cerrada',
                                1 => 'Abierta',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => ''],
                        ],
                        [
                            'attribute' => 'total_valor_trabajo',
                            'value' => function ($data) {
                                if($data->total_valor_trabajo === null || $data->total_valor_trabajo == 0){
                                    return 'Sin Trabajos';
                                }
                                else{
                                    return '$ '.number_format($data->total_valor_trabajo, 0, '', '.');
                                }
                            },
                        ],
                        [
                            'attribute' => 'total_valor_repuesto',
                            'value' => function ($data) {
                                $totalRepuesto = 0;
                                $repuestos = OrdenesTrabajosRepuestos::find()->where(['orden_trabajo_id' => $data->id])->all();
                                foreach ($repuestos as $repuesto) {
                                    if ($repuesto->tipo_descuento == 1) {
                                        $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) * (1 - ($repuesto->descuento / 100)));
                                    } else {
                                        $totalRepuesto = $totalRepuesto + (($repuesto->costo_unitario * $repuesto->cantidad) - $repuesto->descuento);
                                    }
                                }
                                if ($totalRepuesto == 0 || $totalRepuesto == null) {
                                    return 'Sin Repuestos';
                                } else {
                                    return '$ ' . number_format($totalRepuesto, 0, '', '.');
                                }
                            },
                        ],
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta costo Ordenes Trabajo',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
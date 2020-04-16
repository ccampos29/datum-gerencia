<?php

use common\models\User;
use frontend\models\PrioridadesMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\NovedadesMantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Novedades Mantenimientos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="novedades-mantenimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['novedad-mantenimiento-dias'],
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
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Novedades de mantenimiento</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
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
                            'attribute' => 'fecha_hora_reporte',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'filterType' => GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions' => ([
                                'attribute' => 'fecha_hora_reporte',
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
                                    "apply.daterangepicker" => "function() { apply_filter('fecha_hora_reporte') }",
                                    "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                                    //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                                ],
                            ]),
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'usuario_reporte_id',
                            'value' => function ($data) {
                                return $data->usuarioReporte->name . ' ' . $data->usuarioReporte->surname;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'prioridad_id',
                            'value' => function ($data) {
                                switch ($data->prioridad_id) {
                                    case 1:
                                        return 'Bajo';
                                        break;
                                    case 2:
                                        return 'Medio';
                                        break;
                                    case 3:
                                        return 'Urgente';
                                        break;
                                }
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                1 => 'Bajo',
                                2 => 'Medio',
                                3 => 'Urgente',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
                        ],
                        [
                            'attribute' => 'trabajo_id',
                            'value' => function ($data) {
                                return $data->trabajo->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(Trabajos::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'fecha_solucion',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'filterType' => GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions' => ([
                                'attribute' => 'fecha_solucion',
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
                                    "apply.daterangepicker" => "function() { apply_filter('fecha_solucion') }",
                                    "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                                    //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                                ],
                            ]),
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'label' => 'Estado',
                            'attribute' => 'estado',
                            'value' => function ($data) {
                                switch ($data->estado) {
                                    case 'Pendiente':
                                        return '<label class="label label-danger">Pendiente</label>';
                                        break;
                                    case 'Solucionada':
                                        return '<label class="label label-success">Solucionada</label>';
                                        break;
                                }
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                'Pendiente' => 'Pendiente',
                                'Solucionada' => 'Solucionada',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
                        ],
                        [
                            'label' => 'Proviene de',
                            'attribute' => 'proviene_de',
                            'value' => function ($data) {
                                return $data->proviene_de;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                'Manualmente' => 'Manualmente',
                                'Checklist' => 'Checklist',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
                        ],
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Novedad Mantenimiento dias',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
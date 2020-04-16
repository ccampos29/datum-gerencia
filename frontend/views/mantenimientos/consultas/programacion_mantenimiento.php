<?php

use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\MantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Programacion de Mantenimientos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="mantenimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['programacion-mantenimiento'],
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
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Mantenimientos</h3>',
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
                            'attribute' => 'tipo_mantenimiento_id',
                            'value' => function ($data) {
                                return $data->tipoMantenimiento->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(TiposMantenimientos::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'fecha_hora_ejecucion',
                            'value' => function ($data) {
                                switch ($data->estado) {
                                    case 'Solucionado':
                                        return '<label class="label label-success">'.$data->fecha_hora_ejecucion.'</label>';
                                        break;
                                    case 'Cancelado':
                                        return '<label class="label label-primary">'.$data->fecha_hora_ejecucion.'</label>';
                                        break;
                                    case 'Pendiente':
                                        return '<label class="label label-danger">'.$data->fecha_hora_ejecucion.'</label>';
                                        break;
                                }
                            },
                            'format' => 'raw',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'filterType' => GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions' => ([
                                'attribute' => 'fecha_hora_ejecucion',
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
                                    "apply.daterangepicker" => "function() { apply_filter('fecha_hora_ejecucion') }",
                                    "cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }"
                                    //"cancel.daterangepicker" => "function(ev, picker) { var poleDate = picker.element[0].nextElementSibling; $(poleDate).val('').trigger('change'); }",
                                ],
                            ]),
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        'descripcion',
                        'duracion',
                        [
                            'attribute' => 'estado',
                            'value' => function ($data) {
                                switch ($data->estado) {
                                    case 'Solucionado':
                                        return '<label class="label label-success">Solucionado</label>';
                                        break;
                                    case 'Cancelado':
                                        return '<label class="label label-primary">Cancelado</label>';
                                        break;
                                    case 'Pendiente':
                                        return '<label class="label label-danger">Pendiente</label>';
                                        break;
                                }
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                'Solucionado' => 'Solucionado',
                                'Pendiente' => 'Pendiente',
                                'Cancelado' => 'Cancelado',
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
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Programacion Mantenimientos',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
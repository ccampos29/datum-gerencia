<?php

use frontend\models\OrdenesTrabajos;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\TrabajosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Trabajos asociados a las Ordenes de Trabajos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="ordenes-trabajos-trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['ordenes-trabajos-trabajo'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
    <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-share" aria-hidden="true"></i> Orden de Trabajo
                </label>
                <?= $form->field($model, 'orden_trabajo_id')->widget(Select2::classname(), [
                    'data' => !empty($model->orden_trabajo_id) ? [$model->orden_trabajo_id => OrdenesTrabajos::findOne($model->orden_trabajo_id)->consecutivo] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione una Orden',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('ordenes-trabajos/ordenes-trabajos-list'),
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
                    //'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de trabajos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'trabajo_id',
                            'value' => function ($data) {
                                return $data->trabajo->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Vehiculo',
                            'value' => function ($data) {
                                return $data->ordenTrabajo->vehiculo->placa;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'orden_trabajo_id',
                            'value' => function ($data) {
                                return $data->ordenTrabajo->consecutivo;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Fecha y Hora Orden',
                            'value' => function ($data) {
                                return $data->ordenTrabajo->fecha_hora_orden;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'costo_mano_obra',
                            'value' => function ($data) {
                                    return '$ '.number_format($data->costo_mano_obra, 0, '', '.');
                            }
                        ],
                        [
                            'attribute' => 'cantidad',
                            'value' => function ($data) {
                                return $data->cantidad;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Costo Total Orden',
                            'value' => function ($data) {
                                return '$ '.number_format($data->ordenTrabajo->total_valor_trabajo, 0, '', '.');
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'tipo_mantenimiento_id',
                            'value' => function ($data) {
                                return $data->tipoMantenimiento->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Estado de la Orden',
                            'value' => function ($data) {
                                switch ($data->ordenTrabajo->estado_orden) {
                                    case 0:
                                        return '<label class="label label-primary">Cerrada</label>';
                                        break;
                                    case 1:
                                        return '<label class="label label-success">Abierta</label>';
                                        break;
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta ordenes trabajos trabajo',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>


    </div>



    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
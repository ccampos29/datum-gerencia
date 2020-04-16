<?php

use frontend\models\CentrosCostos;
use frontend\models\Proveedores;
use frontend\models\Repuestos;
use frontend\models\TiposCombustibles;
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

$this->title = 'Consultas solicitudes de insumos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="ajustes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['solicitudes-consulta'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Número de solicitud
                </label>
                <?= $form->field($model, 'id')->widget(Select2::classname(), [
                    'data' => !empty($model->id) ? [$model->id => $model->id] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un número de solicitud',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('solicitudes/solicitudes-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha de la solicitud
                </label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'fecha_inicio_solicitud',
                    'attribute2' => 'fecha_fin_solicitud',
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

        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Estado de la solicitud
                </label>
                <?= $form->field($model, 'estado')->widget(Select2::classname(), [
                    'data' => [
                        'Abierta' => 'Abierta',
                        'Cerrada' => 'Cerrada',
                        'Anulada' => 'Anulada'
                    ],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione...',
                        'allowClear' => true,
                    ]
                ])->label(false)
                ?>
            </div>
        </div>
        <br>
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
                    // 'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Datos generales </h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'consecutivo',
                        'fecha_hora_solicitud',
                        [
                            'attribute' => 'vehiculo_id',
                            'value' => function ($data) {
                                return ($data->vehiculo_id) ? $data->vehiculo->placa : '';
                            }
                        ],
                        'tipo',
                        'estado',
                        [
                            'attribute' => 'creado_por',
                            'value' => function ($data) {
                                return $data->creadoPor->name . ' ' . $data->creadoPor->surname;
                            }
                        ]

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
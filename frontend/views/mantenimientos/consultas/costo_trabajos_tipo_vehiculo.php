<?php

use frontend\models\TiposVehiculos;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\MantenimientosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Trabajos agrupados por Tipos de Vehiculos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="propiedades-trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['costo-trabajos-tipo-vehiculo'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]);?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Tipo Vehiculo
                </label>
                <?= $form->field($model, 'tipo_vehiculo_id')->widget(Select2::classname(), [
                    'data' => !empty($model->tipo_vehiculo_id) ? [$model->tipo_vehiculo_id => TiposVehiculos::findOne($model->tipo_vehiculo_id)->descripcion] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un tipo',
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
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Trabajos</h3>',
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
                            'attribute' => 'tipo_vehiculo_id',
                            'value' => function ($data) {
                                return $data->tipoVehiculo->descripcion;
                            },
                            'format' => 'raw',
                        ],
                        'duracion',
                        [
                            'attribute' => 'costo_mano_obra',
                            'value' => function ($data) {
                                    return '$ '.number_format($data->costo_mano_obra, 0, '', '.');
                            }
                        ],
                        'cantidad_trabajo',
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta costo Trabajos',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
<?php

use frontend\models\TiposMantenimientos;
use frontend\models\Trabajos;
use frontend\models\Vehiculos;
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

$this->title = 'Mantenimientos Agrupados por Vehiculos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="mantenimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['mantenimiento-vehiculos'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]);?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo
                </label>
                <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                    'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un vehiculo',
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
                    //'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Mantenimientos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'descripcion',
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
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Mantenimiento vehiculos',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
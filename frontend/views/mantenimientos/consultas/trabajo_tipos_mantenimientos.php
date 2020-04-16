<?php

use frontend\models\CuentasContables;
use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\TiposMantenimientos;
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

$this->title = 'Trabajos Agrupados por Tipos de Mantenimientos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="trabajos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['trabajo-tipos-mantenimientos'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
    <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Tipos de Mantenimientos
                </label>
                <?= $form->field($model, 'tipo_mantenimiento_id')->widget(Select2::classname(), [
                    'data' => !empty($model->tipo_mantenimiento_id) ? [$model->tipo_mantenimiento_id => TiposMantenimientos::findOne($model->tipo_mantenimiento_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un tipo',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('tipos-mantenimientos/tipos-mantenimientos-list'),
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
                        'nombre',
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
                            'attribute' => 'sistema_id',
                            'value' => function ($data) {
                                return $data->sistema->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(Sistemas::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'subsistema_id',
                            'value' => function ($data) {
                                return $data->subsistema->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(Subsistemas::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'attribute' => 'cuenta_contable_id',
                            'value' => function ($data) {
                                return $data->cuentaContable->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(CuentasContables::find()->all(), 'id', 'nombre'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        [
                            'label' => 'Estado',
                            'attribute' => 'estado',
                            'value' => function ($model) {
                                return $model->estado ? '<div class="label label-success">Activo</div>' : '<div class="label label-danger">Inactivo</div>';
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                1 => 'Activo',
                                0 => 'Inactivo',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        'codigo',
                        [
                            'label' => '¿Tiene periodicidad?',
                            'attribute' => 'periodico',
                            'value' => function ($model) {
                                return $model->periodico ? 'Si' : 'No';
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => [
                                1 => 'Si',
                                0 => 'No',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                        ],
                        'observacion',
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta trabajo tipos mantenimientos',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>


    </div>



    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
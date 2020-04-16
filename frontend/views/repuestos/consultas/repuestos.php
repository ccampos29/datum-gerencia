<?php

use frontend\models\CentrosCostos;
use frontend\models\GruposInsumos;
use frontend\models\Proveedores;
use frontend\models\Repuestos;
use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\TiposCombustibles;
use frontend\models\UnidadesMedidas;
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

$this->title = 'Consulta detallada de repuestos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="ajustes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['repuestos-consulta'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Sistemas
                </label>
                <?= $form->field($model, 'sistema_id')->widget(Select2::classname(), [
                    'data' => !empty($model->sistema_id) ? [$model->sistema_id => Sistemas::findOne($model->sistema_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un sistema',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('sistemas/sistemas-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Subsistemas
                </label>
                <?= $form->field($model, 'subsistema_id')->widget(Select2::classname(), [
                    'data' => !empty($model->subsistema_id) ? [$model->subsistema_id => Subsistemas::findOne($model->subsistema_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un subsistema',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('subsistemas/subsistemas-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Unidad de medida
                </label>
                <?= $form->field($model, 'unidad_medida_id')->widget(Select2::classname(), [
                    'data' => !empty($model->unidad_medida_id) ? [$model->unidad_medida_id => UnidadesMedidas::findOne($model->unidad_medida_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione una unidad de medida',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('unidades-medidas/unidades-medidas-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Grupos
                </label>
                <?= $form->field($model, 'grupo_repuesto_id')->widget(Select2::classname(), [
                    'data' => !empty($model->grupo_repuesto_id) ? [$model->grupo_repuesto_id => GruposInsumos::findOne($model->grupo_repuesto_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un grupo',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('grupos-insumos/grupos-insumos-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Estado
                </label>
                <?= $form->field($model, 'estado')->widget(Select2::classname(), [
                    'data' => [
                        1 => 'Activo',
                        0 => 'Inactivo'
                    ],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un estado',
                        'allowClear' => true,
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Inventariable
                </label>
                <?= $form->field($model, 'inventariable')->widget(Select2::classname(), [
                    'data' => [
                        1 => 'Si',
                        0 => 'No'
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
                        [
                            'attribute' => 'nombre',
                        ],
                        [
                            'attribute' => 'sistema_id',
                            'value' => function($data){
                                if($data->sistema_id != null){
                                    return $data->sistema->nombre;
                                    } else {
                                        return 'Sin sistema';
                                    }
                            },
                        ],
                        [
                            'attribute' => 'subsistema_id',
                            'value' => function($data){
                                if($data->subsistema_id != null){
                                    return $data->subsistema->nombre;
                                    } else {
                                        return 'Sin subsistema';
                                    }
                            },
                        ],
                        [
                            'attribute' => 'grupo_repuesto_id',
                            'value' => function($data){
                                if($data->grupo_repuesto_id != null){
                                    return $data->grupoRepuesto->nombre;
                                    } else {
                                        return 'Sin grupo repuesto';
                                    }
                            }
                        ],
                        [
                            'attribute' => 'unidad_medida_id',
                            'value' => function($data){
                                return $data->unidadMedida->nombre;
                            }
                        ],
                        [
                            'attribute' => 'precio',
                        ],
                        [
                            'attribute' => 'estado',
                            'value' => function($data){
                                if($data->estado){
                                    return 'Activo';
                                }else{
                                    return 'Inactivo';
                                }
                            }
                        ],
                        [
                            'attribute' => 'fabricante',
                        ],
                        [
                            'attribute' => 'inventariable',
                            'value' => function($data){
                                if($data->inventariable){
                                    return 'Si';
                                }else{
                                    return 'No';
                                }
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
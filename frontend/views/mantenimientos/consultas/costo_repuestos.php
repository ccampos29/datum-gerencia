<?php

use frontend\models\CentrosCostos;
use frontend\models\CuentasContables;
use frontend\models\Proveedores;
use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\TiposCombustibles;
use frontend\models\UnidadesMedidas;
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

$this->title = 'Costos de los Repuestos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="mantenimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['costo-repuestos'],
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
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Consulta de Costos de Repuestos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'nombre',
                        'fabricante',
                        [
                            'attribute' => 'precio',
                            'value' => function ($data) {
                                    return '$ '.number_format($data->precio, 0, '', '.');
                            }
                        ],
                        'observacion',
                        'codigo',
                        [
                            'label' => 'Estado',
                            'attribute' => 'estado',
                            'value' => function($model){ 
                                return $model->estado ? '<div class="label label-success">Activo</div>' : '<div class="label label-danger">Inactivo</div>'; 
                            } ,
                            'format' => 'raw'
                        ],
                        [
                            'label' => 'Inventariable',
                            'attribute' => 'inventariable',
                            'value' =>function($model){ 
                                return $model->inventariable ? 'Si' : 'No';
                            } ,
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'unidad_medida_id',
                            'value' => function ($data) {
                                return $data->unidadMedida->nombre;
                            },
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(UnidadesMedidas::find()->all(), 'id', 'nombre'),
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
                            'attribute' => 'id', 'visible' => false
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
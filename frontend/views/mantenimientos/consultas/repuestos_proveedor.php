<?php

use frontend\models\Proveedores;
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

$this->title = 'Repuestos agrupados por Proveedores';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="repuestos-proveedor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['repuestos-proveedor'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]);?>

    <div class="container-fluid col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Proveedor
                </label>
                <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                    'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                    'pluginOptions' => [
                        'placeholder' => 'Seleccione un proveedor',
                        'allowClear' => true,
                        'minimumInputLength' => 0,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                        ],
                        'ajax' => [
                            'url' => Yii::$app->urlManager->createUrl('proveedores/proveedores-list'),
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
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Repuestos</h3>',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'repuesto_id',
                            'value' => function ($data) {
                                return $data->repuesto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'proveedor_id',
                            'value' => function ($data) {
                                return $data->proveedor->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'valor',
                            'value' => function ($data) {
                                    return '$ '.number_format($data->valor, 0, '', '.');
                            }
                        ],
                        [
                            'attribute' => 'impuesto_id',
                            'value' => function ($data) {
                                return $data->impuesto->nombre;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'descuento_repuesto',
                            'value' => function ($data) {
                                if($data->tipo_descuento == 1){
                                    return $data->descuento_repuesto.' %';
                                }
                                else{
                                    return '$ '.number_format($data->descuento_repuesto, 0, '', '.');
                                }
                            }
                        ],
                        [
                            'attribute' => 'tipo_descuento',
                            'value' => function ($data) {
                                switch ($data->tipo_descuento) {
                                    case 2:
                                        return '$';
                                        break;
                                    case 1:
                                        return '%';
                                        break;
                                }
                            },
                            'format' => 'raw',
                        ],
                        'codigo',
                        'plazo_pago',
                        [
                            'attribute' => 'id', 'visible' => false
                        ],
                    ],

                    'export' => [
                        'label' => 'Descargar',
                    ],

                    'exportConfig' => [
                        GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Repuestos Proveedor',],
                        GridView::CSV    => ['Exportar CSV'],

                    ]
                ]); ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
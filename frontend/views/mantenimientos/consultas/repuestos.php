<?php

use frontend\models\CuentasContables;
use frontend\models\GruposInsumos;
use frontend\models\Sistemas;
use frontend\models\Subsistemas;
use frontend\models\UnidadesMedidas;
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

$this->title = 'Caracteristicas de Repuestos';

?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="repuestos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['repuestos'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row" style="margin-top:40px;">
        <div class="col-sm-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-save-file"></i> Informe de Repuestos</h3>',
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
                    [
                        'label' => 'Estado',
                        'attribute' => 'estado',
                        'value' => function ($data) {
                            switch ($data->estado) {
                                case 0:
                                    return '<label class="label label-danger">Inactivo</label>';
                                    break;
                                case 1:
                                    return '<label class="label label-success">Activo</label>';
                                    break;
                            }
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [
                            0 => 'Inactivo',
                            1 => 'Activo',
                        ],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'style' => 'width: 6.68%;'],
                    ],
                    [
                        'label' => 'Inventariable',
                        'attribute' => 'inventariable',
                        'value' => function ($data) {
                            switch ($data->inventariable) {
                                case 0:
                                    return 'No';
                                    break;
                                case 1:
                                    return 'Si';
                                    break;
                            }
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [
                            0 => 'No',
                            1 => 'Si',
                        ],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '',],
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
                        'attribute' => 'grupo_repuesto_id',
                        'value' => function ($data) {
                            if($data->grupo_repuesto_id != null){
                                return $data->grupoRepuesto->nombre;
                                } else {
                                    return 'Sin grupo repuesto';
                                }
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(GruposInsumos::find()->all(), 'id', 'nombre'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                    ],
                    [
                        'attribute' => 'sistema_id',
                        'value' => function ($data) {
                            if($data->sistema_id != null){
                                return $data->sistema->nombre;
                                } else {
                                    return 'Sin sistema';
                                }
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
                            if($data->subsistema_id != null){
                                return $data->subsistema->nombre;
                                } else {
                                    return 'Sin subsistema';
                                }
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
                            if($data->cuenta_contable_id != null){
                                return $data->cuentaContable->nombre;
                                } else {
                                    return 'Sin cuenta contable';
                                }
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(CuentasContables::find()->all(), 'id', 'nombre'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Seleccione...'],
                    ],
                    'codigo',
                    'observacion',
                    [
                        'attribute' => 'id', 'visible' => false
                    ],
                ],

                'export' => [
                    'label' => 'Descargar',
                ],

                'exportConfig' => [
                    GridView::EXCEL => ['label' => 'Exportar a EXCEL',  'filename' => 'Consulta Repuestos',],
                    GridView::CSV    => ['Exportar CSV'],

                ]
            ]); ?>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>
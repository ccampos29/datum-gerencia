<?php

use frontend\models\Proveedores;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use frontend\models\Repuestos;
use frontend\models\TiposImpuestos;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesCompras */
/* @var $form yii\widgets\ActiveForm */

$urlProveedores = Yii::$app->urlManager->createUrl('proveedores/proveedores-list');
?>

<div class="ordenes-compras-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y Hora de la Orden
                </label>
                <?= $form->field($model, 'fecha_hora_orden')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora de la orden ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Proveedor
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione un proveedor...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlProveedores,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['proveedores/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-dollar" aria-hidden="true"></i> Forma de Pago
                </label>
                <?= $form->field($model, 'forma_pago')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Direccion
                </label>
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 3])->label(false) ?>
            </div>
        </div>

        <hr>
        <a data-toggle="collapse" href="#repuestos" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> <label>
                Repuestos </label>
        </a>
        <hr>
        <div id="repuestos" class="collapse in">
            <?= $form->field($model, 'repuestos')->widget(MultipleInput::className(), [
                'addButtonPosition' => MultipleInput::POS_FOOTER,
                'columns' => [
                    [
                        'name'  => 'repuesto_id',
                        'type'  => \kartik\select2\Select2::className(),
                        'title' => 'Repuesto<span style="color:red;">*</span>',
                        'options' => [
                            'data' => ArrayHelper::map(Repuestos::find()->where(['inventariable' => '1'])->all(), 'id', 'nombre'),
                        ],
                    ],
                    [
                        'name'  => 'cantidad',
                        'title' => 'Cantidad<span style="color:red;">*</span>',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                    [
                        'name'  => 'valor_unitario',
                        'title' => 'Valor Unitario<span style="color:red;">*</span>',
                        'type'  => \kartik\number\NumberControl::className(),
                        'enableError' => true,
                        'options' => [
                            'maskedInputOptions' => [
                                'prefix' => '$ ',
                                'groupSeparator' => '.',
                                'radixPoint' => ',',
                                'allowMinus' => false
                            ],
                        ]
                    ],
                    [
                        'name'  => 'tipo_descuento',
                        'type'  => \kartik\select2\Select2::className(),
                        'title' => 'Tipo descuento<span style="color:red;">*</span>',
                        'options' => [
                            'data' => [
                                '%' => '%',
                                '$' => '$'
                            ]
                        ],
                    ],
                    [
                        'name'  => 'descuento_unitario',
                        'title' => 'Descuento Unitario<span style="color:red;">*</span>',
                        'type'  => \kartik\number\NumberControl::className(),
                        'enableError' => true,
                        'options' => [
                            'maskedInputOptions' => [
                                'groupSeparator' => '.',
                                'radixPoint' => ',',
                                'allowMinus' => false
                            ],
                        ]
                    ],
                    [
                        'name'  => 'tipo_impuesto_id',
                        'type'  => \kartik\select2\Select2::className(),
                        'title' => 'Tipo Impuesto<span style="color:red;">*</span>',
                        'options' => [
                            'data' => ArrayHelper::map(TiposImpuestos::find()->all(), 'id', 'nombre'),
                        ],
                    ],
                    [
                        'name'  => 'observacion',
                        'type'  => 'textarea',
                        'title' => 'Observacion<span style="color:red;">*</span>',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                ]
            ])->label(false)
            ?>
        </div>

        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['ordenes-compras/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
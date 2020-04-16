<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use frontend\models\Vehiculos;
use frontend\models\TiposGastos;
use frontend\models\TiposImpuestos;
use frontend\models\Proveedores;
use frontend\models\User;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use kartik\number\NumberControl;
use yii\helpers\Url;
/* @var $this yii//['label' => 'Tipo del descuento',
            //'attribute' => 'tipoDescuento.nombre'],
            \web\View */
/* @var $model frontend\models\OtrosGastos */
/* @var $form yii\widgets\ActiveForm */

$urlTiposGastos = Yii::$app->urlManager->createUrl('tipos-gastos/tipos-gastos-list');
$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlTiposImpuestos = Yii::$app->urlManager->createUrl('tipos-impuestos/tipos-impuestos-list');
$urlCentrosCostos = Yii::$app->urlManager->createUrl('centros-costos/centros-costos-list');
$urlProveedores = Yii::$app->urlManager->createUrl('proveedores/proveedores-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/nombres-usuarios-list');
?>

<div class="otros-gastos-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Vehiculo 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                            'options' => ['placeholder' => 'Seleccione una placa de un vehiculo',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlVehiculos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-money" aria-hidden="true"></i> Tipo del gasto 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'tipo_gasto_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_gasto_id) ? [$model->tipo_gasto_id => TiposGastos::findOne($model->tipo_gasto_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un tipo de gasto',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposGastos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-gastos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de gasto" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del gasto 
                </label>
                <?= $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                    'name' => 'fecha',
                    'options' => [

                        'placeholder' => 'Selecciona la fecha del gasto'
                    ],

                    'pluginOptions' => [
                        
                        'format' => 'yyyy-mm-dd',
                        //'endDate' => date('Y-m-d'),
                        'autoclose' => true,
                    ]
                ])->label(false) ?>
            </div>
        </div>

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Valor unitario
                </label>

                <?= $form->field($model, 'valor_unitario')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad unitaria
                </label>
                <?= $form->field($model, 'cantidad_unitaria')->textInput()->label(false) ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Tipo de Descuento 
                </label>
                <?= $form->field($model, 'tipo_descuento')->dropDownList(
                    [2 => '%', 1 => '$'],
                    ['id' => 'select', 'prompt' => '']
                )->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Cantidad del descuento
                </label>
                <div id='editable'><?= $form->field($model, 'cantidad_descuento')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?></div>
                <div id='editable2'><?= $form->field($model, 'gastos')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'suffix' => ' %',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                        'max' => '100',
                    ],
                ])->label(false); ?></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-industry" aria-hidden="true"></i> Proveedor 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'proveedor_id')->widget(Select2::classname(), [
                            'data' => !empty($model->proveedor_id) ? [$model->proveedor_id => Proveedores::findOne($model->proveedor_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un proveedor',],

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
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../proveedores/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un proveedor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Cargar a 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                            'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
                            'options' => ['placeholder' => 'Seleccione un usuario al que cargar el gasto',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUsuarios,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../user/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un usuario" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-bank" aria-hidden="true"></i> Tipo Impuesto 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'tipo_impuesto_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_impuesto_id) ? [$model->tipo_impuesto_id => TiposImpuestos::findOne($model->tipo_impuesto_id)->nombre] : [],
                            'options' => ['placeholder' => 'Seleccione un tipo de impuesto',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTiposImpuestos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-impuestos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de impuesto" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Factura
                </label>
                <?= $form->field($model, 'factura')->textInput(['maxlength' => true])->label(false) ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Codigo Interno
                </label>
                <?= $form->field($model, 'codigo_interno')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['otros-gastos/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end();
    $this->registerJsFile(
        '@web/js/gastos.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    ?>


</div>
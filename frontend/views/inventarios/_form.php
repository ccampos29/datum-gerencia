<?php

use frontend\models\Repuestos;
use frontend\models\RepuestosInventariables;
use frontend\models\UbicacionesInsumos;
use frontend\models\UnidadesMedidas;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\widgets\DateTimePicker;

use kartik\widgets\TimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use unclead\multipleinput\MultipleInput;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Inventarios */
/* @var $form yii\widgets\ActiveForm */

$urlUbicaciones = Yii::$app->urlManager->createUrl('ubicaciones-insumos/ubicaciones-insumos-list');
?>

<div class="inventarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha y hora Inventario
                </label>
                <?= $form->field($model, 'fecha_hora_inventario')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Fecha y hora Inventario ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'orientation' => 'bottom',
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Ubicacion
                </label>
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                        <?= $form->field($model, 'ubicacion_insumo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->ubicacion_insumo_id) ? [$model->ubicacion_insumo_id => UbicacionesInsumos::findOne($model->ubicacion_insumo_id)->nombre] : [],
                            'options' => [
                                'placeholder' => 'Seleccione una ubicacion...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUbicaciones,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                        <a href="<?= Url::to(['ubicaciones-insumos/create']) ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una ubicacion" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label>
                    <i class="fa fa-book" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 4])->label(false) ?>
            </div>
        </div>

        <hr>
        <a data-toggle="collapse" href="#repuestos" role="button" aria-expanded="false" tabindex="-1">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <label>Repuestos</label>
        </a>
        <hr>

        <div id="repuestos" class="collapse">
            <?= $form->field($model, 'repuestos')->widget(MultipleInput::className(), [
                'addButtonPosition' => MultipleInput::POS_FOOTER,
                'columns' => [
                    [
                        'name'  => 'repuesto_id',
                        'type'  => \kartik\select2\Select2::className(),
                        'title' => 'Repuesto<span style="color:red;">*</span>',
                        'options' => [
                            'data' => ArrayHelper::map(Repuestos::find()->where(['inventariable' => 1, 'empresa_id' => Yii::$app->user->identity->empresa_id])->all(), 'id', 'nombre'),
                        ],
                    ],
                    [
                        'name'  => 'cantidad_fisica',
                        'title' => 'Cantidad<span style="color:red;">*</span>',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                    [
                        'name'  => 'unidad_medida_id',
                        'title' => 'Unidad Medida<span style="color:red;">*</span>',
                        'type'  => \kartik\select2\Select2::className(),
                        'enableError' => true,
                        'options' => [
                            'data' => ArrayHelper::map(UnidadesMedidas::find()->all(), 'id', 'nombre'),
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
                <a class="btn btn-default" href="<?= Url::to(['inventarios/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
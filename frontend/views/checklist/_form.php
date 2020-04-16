<?php

use frontend\models\EstadosChecklist;
use frontend\models\ImagenesChecklist;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\TiposUsuarios;
use frontend\models\TiposChecklist;
use frontend\models\Vehiculos;
use frontend\models\TiposVehiculos;
use frontend\models\Mediciones;
use frontend\models\User;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\number\NumberControl;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Checklist */
/* @var $form yii\widgets\ActiveForm */

$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/conductores-asignados-list');
$urlEstados = Yii::$app->urlManager->createUrl('estados-checklist/estados-list');
$this->title = 'Crear checklist';

?>

<div class="checklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Vehiculo
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                            'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                            'options' => ['id' => 'select-placa', 'placeholder' => 'Selecciona una placa',],
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
                    <i class="fa fa-car" aria-hidden="true"></i> Tipo del Checklist
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'tipo_checklist_id')->widget(DepDrop::classname(), [
                            //'options'=>[],
                            'data' => !empty($model->tipo_checklist_id) ? [$model->tipo_checklist_id => TiposChecklist::findOne($model->tipo_checklist_id)->nombre] : [],
                            'pluginOptions' => [
                                'depends' => ['select-placa'],
                                'placeholder' => 'Select...',
                                'url' => Url::to(['tipos-checklist/tipo'])
                            ],
                            'options' => [
                                'id' => 'select-tipo',
                            ]
                        ])->label(false) ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-checklist/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de checklist" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Conductor
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                            'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
                            'options' => ['placeholder' => 'Seleccione un conductor',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlUsuarios,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term, vehiculo_id: $("#select-placa").val() }; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../user/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un conductor" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del checklist
                </label>
                <input class="form-control" readOnly="true" value="<?php echo date('Y-m-d');?>">
                </input>
                <?= $form->field($model, 'fecha_checklist')->textInput([
                    'id' => 'fecha-checklist',
                    'class' => 'hidden'
                    ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del siguiente checklist
                </label>
                <input class="form-control" readOnly="true" id='campo-fecha-mostrar'>
                </input>
                <?= $form->field($model, 'fecha_siguente')->textInput([
                    'class' => 'hidden',
                    'id' => 'fecha-siguiente'
                ])->label(false) ?>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-clock-o" aria-hidden="true"></i> Hora del checklist
                </label>
                <input class="form-control" readOnly="true" value="<?php echo date('H:i');?>">
                </input>
                <?= $form->field($model, 'hora_medicion')->textInput([
                    'class' => 'hidden',
                    'value' => date('H:i')
                ])->label(false) ?>
            </div>
        </div>

        

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion actual
                </label>
                <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                </input>
                <?= $form->field($model, 'medicion_actual')->textInput([
                    'class' => 'hidden',
                    //'value' => 123,
                    'id' => 'campo-medicion'
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion del siguiente checklist
                </label>

                <input class="form-control" readOnly="true" id='campo-medicion-siguente-mostrar'>
                </input>
                <div id="editable"><?= $form->field($model, 'medicion_siguente')->textInput([
                                        'class' => 'hidden',
                                        'id' => 'campo-medicion-siguente'
                                    ])->label(false) ?></div>

            </div>
        </div>
        <hr>
            <div class="row">
                <div class="col-12">
                    <label>
                        <i class="fa fa-font" aria-hidden="true"></i> Observacion
                    </label>
                    <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
                </div>
            </div>
            <hr>
           
    
            <div class="form-group">
                <div class="form-group pull-left">
                    <a class="btn btn-default" href="<?= Url::to(['checklist/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
                </div>
                <div class="form-group pull-right">
                    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end();

            $this->registerJsFile(
                '@web/js/checklistWebService.js',
                ['depends' => [\yii\web\JqueryAsset::className()]]
            );

            $this->registerJsFile(
                '@web/js/checklist.js',
                ['depends' => [\yii\web\JqueryAsset::className()]]
            );
            ?>

        </div>
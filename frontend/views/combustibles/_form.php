<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\User;
use frontend\models\Mediciones;
use frontend\models\Vehiculos;
use frontend\models\TiposCombustibles;
use frontend\models\Proveedores;
use frontend\models\GruposVehiculos;
use frontend\models\Municipios;
use frontend\models\Departamentos;
use frontend\models\Pais;
use frontend\models\CentrosCostos;
use frontend\models\ImagenesChecklist;
use frontend\models\ImagenesCombustibles;
use kartik\file\FileInput;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model frontend\models\Combustibles */
/* @var $form yii\widgets\ActiveForm */
$list = [ 1 => 'Si', 0 => 'No'];
$urlTiposCombustibles = Yii::$app->urlManager->createUrl('tipos-combustibles/tipos-combustibles-list');
$urlGruposVehiculos = Yii::$app->urlManager->createUrl('grupos-vehiculos/primer-grupos-vehiculos-list');
$urlVehiculos = Yii::$app->urlManager->createUrl('vehiculos/vehiculos-list');
$urlPais = Yii::$app->urlManager->createUrl('pais/pais-list');
$urlCentrosCostos = Yii::$app->urlManager->createUrl('centros-costos/centros-costos-list');
$urlProveedores = Yii::$app->urlManager->createUrl('proveedores/proveedores-list');
$urlUsuarios = Yii::$app->urlManager->createUrl('user/nombres-usuarios-list');
?>

<div class="combustibles-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-calendar" aria-hidden="true"></i> Fecha del tanqueo 
                </label>
                <?= $form->field($model, 'fecha')->widget(DatePicker::classname(),[
                    'name' => 'fecha',
                    'options' => ['placeholder' => 'Selecciona la fecha del tanqueo'],
                    
                    'pluginOptions' => [
                        'todayHighlight' => true,  
                        //'endDate' => date('Y-m-d'),
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-clock-o" aria-hidden="true"></i> Hora del tanqueo 
                </label>
                <?= $form->field($model, 'hora')->widget(TimePicker::classname(), [
                    'options' => ['placeholder' => 'Selecciona la hora del tanqueo'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'showMeridian'=>false,
                    ]
                ])->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-checkmark" aria-hidden="true"></i> ¿Tanqueo full? 
                </label>
                <?= $form->field($model, 'tanqueo_full')->radioList($list, [
                    'inline'=>true])->label(false) ?>  
            </div>
            
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-usd" aria-hidden="true"></i> Costo por Galon 
                </label>
                <?= $form->field($model, 'costo_por_galon')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Cantidad de combustible 
                </label>
                <?= $form->field($model, 'cantidad_combustible')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
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
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-hashtag" aria-hidden="true"></i> Numero del tiquete 
                </label>
                <?= $form->field($model, 'numero_tiquete')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-car" aria-hidden="true"></i> Selecciona un vehiculo
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'vehiculo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->vehiculo_id) ? [$model->vehiculo_id => Vehiculos::findOne($model->vehiculo_id)->placa] : [],
                                'options' => ['id'=>'select-placa', 'placeholder'=>'Selecciona una placa de un vehiculo'],
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
                    <i class="fa fa-tachometer" aria-hidden="true"></i> Tipo de combustible
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'tipo_combustible_id')->widget(Select2::classname(), [
                                'data' => !empty($model->tipo_combustible_id) ? [$model->tipo_combustible_id => TiposCombustibles::findOne($model->tipo_combustible_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un centro de costos',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlTiposCombustibles,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-combustibles/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de combustible" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Cargar A 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'usuario_id')->widget(Select2::classname(), [
                                'data' => !empty($model->usuario_id) ? [$model->usuario_id => User::findOne($model->usuario_id)->name] : [],
                                'options' => ['placeholder' => 'Seleccione un usuario al que cargar el tanqueo',],
                                
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
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-cubes" aria-hidden="true"></i> Grupo asociado 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'grupo_vehiculo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->grupo_vehiculo_id) ? [$model->grupo_vehiculo_id => GruposVehiculos::findOne($model->grupo_vehiculo_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un grupo asociado',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlGruposVehiculos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../grupos-vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un grupo de vehiculos" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion
                        </label>

                        <?= $form->field($model, 'medicion_actual')->textInput([
                                //'class' => 'hidden',
                                //'id' => 'campo-medicion'
                                'type' => 'number'
                            ])->label(false) ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Medicion web Service
                        </label>
                        <input class="form-control" readOnly="true" id='campo-medicion-mostrar'>
                        </input>
                        <?= $form->field($model, 'medicion_compare')->textInput([
                                'class' => 'hidden',
                                'id' => 'campo-medicion'
                            ])->label(false) ?>
                    
                    </div>
            
        </div>
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map" aria-hidden="true"></i> Centro de costos 
                </label>
                <div class="row">
                    <div class="col-xs-10">
                    <?= $form->field($model, 'centro_costo_id')->widget(Select2::classname(), [
                                'data' => !empty($model->centro_costo_id) ? [$model->centro_costo_id => CentrosCostos::findOne($model->centro_costo_id)->nombre] : [],
                                'options' => ['placeholder' => 'Seleccione un centro de costos',],
                                
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlCentrosCostos,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../centros-costos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un centro de costos" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map" aria-hidden="true"></i> Pais 
                </label>
                
                    <?= $form->field($model, 'pais_id')->widget(Select2::classname(), [
                                'data' => !empty($model->pais_id) ? [$model->pais_id => Pais::findOne($model->pais_id)->nombre] : [],
                                'options' => ['id'=>'idPais', 'placeholder' => 'Seleccione un pais',],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $urlPais,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ])->label(false)
                    ?>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map-pin" aria-hidden="true"></i> Departamento 
                </label>
                <?= $form->field($model, 'departamento_id')->widget(DepDrop::classname(), [
                    'options'=>['id'=>'idDepartamento'],
                    'data' => !empty($model->departamento_id) ? [$model->departamento_id => Departamentos::findOne($model->departamento_id)->nombre] : [],
                    
                    'pluginOptions'=>[
                        'depends'=>['idPais'],
                        'placeholder'=>'Select...',
                        'url'=>Url::to(['vehiculos/departamentos'])
                    ]
                ])->label(false) ?> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <label>
                    <i class="fa fa-map-mark" aria-hidden="true"></i> Municipio 
                </label>
                <?= $form->field($model, 'municipio_id')->widget(DepDrop::classname(), [
                    'options'=>['id'=>'idMunicipio'],
                    'data' => !empty($model->municipio_id) ? [$model->municipio_id => Municipios::findOne($model->municipio_id)->nombre] : [],
                    
                    'pluginOptions'=>[
                        'depends'=>['idDepartamento'],
                        'placeholder'=>'Select...',
                        'url'=>Url::to(['vehiculos/municipios'])
                    ]
                ])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>
                    <i class="fa fa-font" aria-hidden="true"></i> Observacion
                </label>
                <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?> 
            </div>
        </div>
        <hr>
    <div class="row">
        <div class="col-12">
            <label>
                <i class="fa fa-camera-retro" aria-hidden="true"></i> Foto del combustible <span style="color:red;">*</span>
            </label>
            <?php 
                echo $form->field($model, 'imagenCombustible')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/png', 'required' => ($model->isNewRecord) ? true : false],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg'],
                        'showUpload' => false,
                    ],
                ])->label(false);
            

            ?>

        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['combustibles/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php 
        ActiveForm::end(); 
        $this->registerJsFile(
            '@web/js/combustiblesWebService.js', ['depends' => [\yii\web\JqueryAsset::className()]]
        ); 
    ?>

</div>

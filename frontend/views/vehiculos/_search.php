<?php

use frontend\models\MarcasVehiculos;
use frontend\models\LineasMarcas;
use frontend\models\TiposVehiculos;
use frontend\models\TiposMediciones;
use frontend\models\TiposCombustibles;
use frontend\models\TiposTrabajosVehiculos;
use kartik\select2\Select2;
use frontend\models\Vehiculos;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiculos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<?php 
   

    $urlMarcasVehiculos = Yii::$app->urlManager->createUrl('marcas-vehiculos/marcas-vehiculos-list');
    $urlTiposCombustibles = Yii::$app->urlManager->createUrl('tipos-combustibles/tipos-combustibles-list');
    $urlTiposVehiculos = Yii::$app->urlManager->createUrl('tipos-vehiculos/tipos-vehiculos-list');

?>
 
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-car" aria-hidden="true"></i> Placa del vehiculo
            </label>
            <?= $form->field($model, 'placa')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
                <i class="fa fa-hashtag" aria-hidden="true"></i> Modelo del vehiculo
            </label>
            <?= $form->field($model, 'modelo')->textInput()->label(false) ?>
            
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
            <i class="fa fa-paint-brush" aria-hidden="true"></i> Color del vehiculo
            </label>
            <?= $form->field($model, 'color')->textInput(['maxlength' => true])->label(false) ?> 
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <label>
            <i class="fa fa-cubes" aria-hidden="true"></i> Trabajo del vehiculo
            </label>
                <?= $form->field($model, 'tipo_trabajo')->dropDownList(
                ['Bajo' => 'Bajo', 'Moderado' => 'Moderado', 'Severo' => 'Severo'],['prompt'=>'Seleciona uno...']
        )->label(false) ?>
        </div>
    </div>
        
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-car" aria-hidden="true"></i> Marca del vehiculo
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'marca_vehiculo_id')->widget(Select2::classname(), [
                        'data' => !empty($model->marca_vehiculo_id) ? [$model->marca_vehiculo_id => MarcasVehiculos::findOne($model->marca_vehiculo_id)->descripcion] : [],
                        'options' => ['id' => 'idMarcaVehiculo'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlMarcasVehiculos,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../marcas-vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>  
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-car" aria-hidden="true"></i> Linea de la marca
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'linea_vehiculo_id')->widget(DepDrop::classname(), [
                        'options'=>['id'=>'idLineaVehiculo'],
                        'pluginOptions'=>[
                            'depends'=>['idMarcaVehiculo'],
                            'placeholder'=>'Select...',
                            'url'=>Url::to(['marcas-vehiculos/lineas'])
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../lineas-marcas/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear una linea de vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>   
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <label>
                <i class="fa fa-cogs" aria-hidden="true"></i> Tipo del vehiculo
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'tipo_vehiculo_id')->widget(Select2::classname(), [
                        'data' => !empty($model->tipo_vehiculo_id) ? [$model->tipo_vehiculo_id => TiposVehiculos::findOne($model->tipo_vehiculo_id)->descripcion] : [],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlTiposVehiculos,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../tipos-vehiculos/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de vehiculo" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>
                <i class="fa fa-tachometer" aria-hidden="true"></i> Tipo de medicion
            </label>
            <?= $form->field($model, 'tipo_medicion')->dropDownList(
                ['Hora' => 'Hora', 'KMS' => 'KMS'], ['prompt'=>'Seleciona uno...']
        )->label(false) ?>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>
                <i class="fa fa-cubes" aria-hidden="true"></i> Tipo de combustible
            </label>
            <div class="row">
                <div class="col-xs-10">
                    <?= $form->field($model, 'tipo_combustible_id')->widget(Select2::classname(), [
                        'data' => !empty($model->tipo_combustible_id) ? [$model->tipo_combustible_id => TiposCombustibles::findOne($model->tipo_combustible_id)->nombre] : [],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlTiposCombustibles,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ]
                    ])->label(false) ?>
                </div>
                <div class="col-xs-2">
                    <a href="../tipos-combustibles/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un tipo de combustible" target="_blank"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
    </div>  
</div>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

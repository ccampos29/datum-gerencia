<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use frontend\models\Pais;
use frontend\models\Departamentos;
use frontend\models\Municipios;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\InformacionAdicionalUsuarios */
/* @var $form yii\widgets\ActiveForm */
$urlPais = Yii::$app->urlManager->createUrl('pais/pais-list');
?>

<div class="informacion-adicional-usuarios-form">

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['user/asociar-informacion-adicional','id' => $usuario->id])
    ]); ?>

    <div class="container-fluid">
        <div class="row text-center">
            <h3>
                Ubicación
            </h3>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?=
                    $form->field($model, 'pais_id')->widget(Select2::classname(), [
                        'data' => !empty($model->pais_id) ? [$model->pais_id => Pais::findOne($model->pais_id)->nombre] : [],
                        'options' => ['id' => 'idPais', 'placeholder' => 'Seleccione un pais',],
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
                    ]);
                ?>
            </div>
            <div class="col-sm-3">
                <?=
                    $form->field($model, 'departamento_id')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'idDepartamento'],
                        'data' => !empty($model->departamento_id) ? [$model->departamento_id => Departamentos::findOne($model->departamento_id)->nombre] : [],

                        'pluginOptions' => [
                            'depends' => ['idPais'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['vehiculos/departamentos'])
                        ]
                    ]);
                ?>
            </div>
            <div class="col-sm-3">
                <?=
                    $form->field($model, 'municipio_id')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'idMunicipio'],
                        'data' => !empty($model->municipio_id) ? [$model->municipio_id => Municipios::findOne($model->municipio_id)->nombre] : [],

                        'pluginOptions' => [
                            'depends' => ['idDepartamento'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['vehiculos/municipios'])
                        ]
                    ]);
                ?>
            </div>
        </div>
        <div class="row text-center">
            <h3>
                Números de contacto
            </h3>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'numero_movil')->textInput(['maxlength' => true,'type' => 'number']) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'numero_fijo_extension')->textInput(['maxlength' => true,'type' => 'number']) ?>
            </div>
        </div>
        <div class="row text-center">
            <h3>
                Información bancaria
            </h3>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'numero_cuenta_bancaria')->textInput(['type' => 'number']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'tipo_cuenta_bancaria')->dropDownList(['Corriente' => 'Corriente', 'Ahorros' => 'Ahorros',], ['prompt' => '']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'nombre_banco')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'usuario_id')->textInput(['maxlength' => true,'class' => 'hidden'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
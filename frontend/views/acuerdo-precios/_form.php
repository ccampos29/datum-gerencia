<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AcuerdoPrecios */
/* @var $form yii\widgets\ActiveForm */

$value =  $model->isNewRecord ? $proveedor_id : NULL;

?>

<div class="acuerdo-precios-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    <div class="col-sm-12">
                    <?= $form->field($model, 'proveedor_id')->textInput([ 'value'=>$value, 'type' => 'hidden'])->label(false) ?>
                </div>
        <div class="col-sm-6">
            <label for="tipo_documento_id"><i class="fa fa-info" aria-hidden="true"></i> Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="tipo_documento_id"><i class="fa fa-check" aria-hidden="true"></i> ¿Aplica?</label>
            <?= $form->field($model, 'aplica_para')->dropDownList(['Trabajos' => 'Trabajos', 'Insumos/Repuestos' => 'Insumos/Repuestos',], ['prompt' => ''])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="tipo_documento_id"><i class="fa fa-address-card-o" aria-hidden="true"></i> Fecha Inicial Vigencia</label>
<?= $form->field($model, 'fecha_inicial')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione una fecha inicial'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="tipo_documento_id"><i class="fa fa-info" aria-hidden="true"></i> Fecha Final Vigencia</label>

            <?= $form->field($model, 'fecha_final')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Seleccione una fecha final'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ])->label(false) ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-6">
            <label for="tipo_documento_id"><i class="fa fa-info" aria-hidden="true"></i> Estado</label>
            <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo',], ['prompt' => ''])->label(false) ?>

        </div>
        <div class="col-sm-12">
            <label for="tipo_documento_id"><i class="fa fa-comment" aria-hidden="true"></i> Observación</label>
            <?= $form->field($model, 'comentario')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
    <div class="form-group">
    <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\CriteriosEvaluaciones;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\CriteriosEvaluacionesDetalle */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="criterios-evaluaciones-detalle-form">

    <?php $form = ActiveForm::begin();
    $tipo = CriteriosEvaluaciones::findOne($idCriterio);
    ?>
    <div class="container-fluid col-12">
        <div class="row" > 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-list" aria-hidden="true"></i> Tipo del criterio 
                </label>
                
                <input class = "form-control" readOnly = "true" id="criteriosId" value= <?php echo $tipo->tipo;?>>
                </input>
                <?php echo $form->field($model, 'tipo_criterio_id')->textInput([
                    
                    'class'=>'hidden', 
                    'value' => $tipo->id,
                    ])->label(false) ?>
           
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <label>
                    <i class="fa fa-cogs" aria-hidden="true"></i> Detalle 
                </label>
                <?= $form->field($model, 'detalle')->textInput(['maxlength' => true])->label(false) ?>
            </div>
        </div>
        <div class="row" , id="editable">
           <!--  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-arrows-h" aria-hidden="true"></i> Rango 
                </label>
                <?= $form->field($model, 'rango')->textInput([])->label(false); ?>
            </div> -->
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-arrow-down" aria-hidden="true"></i> Minimo 
                </label>
                <?= $form->field($model, 'minimo')->textInput([])->label(false); ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-arrow-up" aria-hidden="true"></i> Maximo 
                </label>
                <?= $form->field($model, 'maximo')->textInput([])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group pull-left">
            <a class="btn btn-default" href="<?= Url::to(['criterios-evaluaciones-detalle/index','idCriterio'=>$idCriterio]) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
        <?php ActiveForm::end();
        $this->registerJsFile(
            '@web/js/criteriosEvaluacionDetalle.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        ); ?>

    </div>
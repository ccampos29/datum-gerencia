<?php

use common\models\User;
use frontend\models\Checklist;
use frontend\models\CriteriosEvaluacionesDetalle;
use frontend\models\GruposNovedades;
use frontend\models\ImagenesChecklist;
use frontend\models\NovedadesTiposChecklist;
use frontend\models\TiposChecklist;
use frontend\models\TiposVehiculos;
use frontend\models\Vehiculos;
use kartik\file\FileInput;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CalificacionesChecklist */
/* @var $form yii\widgets\ActiveForm */

$checklist = Checklist::findOne($idChecklist);
$user = User::findOne($checklist->usuario_id);
$vehiculo = Vehiculos::findOne($checklist->vehiculo_id);
$creador = User::findOne($checklist->creado_por);
$tipoVehiculo = TiposVehiculos::findOne($vehiculo->tipo_vehiculo_id);
$gruposNovedades = GruposNovedades::find()->all();
$noveCheck = NovedadesTiposChecklist::find()->where(['tipo_checklist_id' => $idTipo])->all();

?>

<div class="calificaciones-checklist-form">
    <h1><b><?= Html::encode('Debe completar todas las calificaciones antes de guardar.'); ?></b></h1>
    <hr>
    <table width='100%'>
        <h4><b><?= Html::encode($checklist->tipoChecklist->nombre); ?></b></h4>
        <tr>
            <td>
                <b>Fecha y Hora: </b><?= Html::encode($checklist->fecha_checklist . " - " . $checklist->hora_medicion) ?><br>
            </td>
            <td>
                <b>Medición Siguiente Chequeo: </b><?= Html::encode(number_format($checklist->medicion_siguente, 0, '', '.')) ?><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Medición Actual: </b><?= Html::encode(number_format($checklist->medicion_actual, 0, '', '.')) ?><br>
            </td>
            <td>
                <b>Tipo de Vehículo: </b><?= Html::encode($tipoVehiculo->descripcion) ?><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Conductor: </b><?= Html::encode($user->name . ' ' . $user->surname) ?><br>
            </td>
            <td>
                <b>Fecha Siguiente Chequeo: </b><?= Html::encode($checklist->fecha_siguente) ?><br>
            </td>
        </tr>
        <tr>
            <td>
                <b>Creado Por: </b><?= Html::encode($creador->name . ' ' . $creador->surname) ?><br>
            </td>
        </tr>
    </table>
    <hr>
    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid col-12">
        <?php
        $i = 0;
        foreach ($gruposNovedades as $grupo) { ?>
                <?php
                $j = 0;
                foreach ($noveCheck as $novedad) {?>
                    <div class="row">
                    <?php if ($j == 0 && $novedad->novedad->grupoNovedad->id == $grupo->id) { ?>
                        <h2><?= Html::encode($grupo->nombre) ?></h2>
                        <hr>
                    <?php }
                    if ($novedad->novedad->grupoNovedad->id == $grupo->id) { ?>
                    
                        
                            <?= $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                                'class' => 'hidden',
                                'value' => $grupo->id
                            ])->label(false);
                            $j++; ?>
                        
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label>
                                <i aria-hidden="true"></i> Novedad
                            </label>
                            <input class="form-control" readOnly="true" value="<?php echo $novedad->novedad->nombre ?>">
                            </input>
                            <?= $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                                'class' => 'hidden',
                                'value' => $novedad->novedad->id
                            ])->label(false);
                            $j++; ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label>
                                <i aria-hidden="true"></i> Criterio de evaluacion
                            </label>
                            <input class="form-control" readOnly="true" value="<?= $novedad->novedad->criterioEvaluacion->nombre ?>">
                            </input>
                            <?= $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                                'class' => 'hidden',
                                'value' => $novedad->novedad->criterioEvaluacion->id
                            ])->label(false);
                            $j++; ?>
                        </div>
                        <?php
                        $detalles = ArrayHelper::map(CriteriosEvaluacionesDetalle::find()
                            ->where(['tipo_criterio_id' => $novedad->novedad->criterioEvaluacion->id])
                            ->all(), 'id', 'detalle');
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label>
                                <i aria-hidden="true"></i> Calificacion
                            </label>
                            <?php
                            if ($novedad->novedad->criterioEvaluacion->tipo == 'Botones de opción') {
                                echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')
                                    ->radioList($detalles)
                                    ->label(false);
                                $j++;
                            } elseif ($novedad->novedad->criterioEvaluacion->tipo == 'Editable'){
                                echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')
                                ->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => 'Ingrese un valor entre 0 y 10'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'max' => 10,
                                        'groupSeparator' => '.',
                                        'radixPoint' => ',',
                                        'allowMinus' => false
                                    ],
                                ])->label(false);
                                $j++;
                            }else {
                                echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')
                                    ->dropDownList($detalles, ['prompt' => 'Seleccione un estado'])
                                    ->label(false);
                                $j++;
                            }
                            ?>
                        </div>
                <?php
                        echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                            'class' => 'hidden',
                            'value' => $idv
                        ])->label(false);
                        $j++;
                        echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                            'class' => 'hidden',
                            'value' => $idTipo
                        ])->label(false);
                        $j++;
                        echo $form->field($model, 'novedadesCalificadas[' . $i . ']' . '[' . $j . ']')->textInput([
                            'class' => 'hidden',
                            'value' => $idChecklist
                        ])->label(false);
                        $j++;
                    }
                    $i++;
                    ?>
                    </div>
               <?php }
            
         } ?>
    </div>
    <div class="row">
        <div class="col-12">
            <label>
                <i class="fa fa-camera-retro" aria-hidden="true"></i> Foto del checklist 
            </label>
            <?php if ($model->isNewRecord) {
                echo $form->field($model, 'imagenChecklist')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg'],
                        'showUpload' => false,
                    ],
                ])->label(false);
            } else {
                echo $form->field($model, 'imagenChecklist')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg'],
                        'showUpload' => false,
                    ],
                ])->label(false);
                $imagenes  = ImagenesChecklist::find()->where(['checklist_id' => $_GET['id']])->one();
                echo 'Archivo subido: ' . Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl('../..' . Yii::$app->params['rutaImagenesChecklist'] . $imagenes->nombre_archivo));
            }

            ?>

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

    <?php ActiveForm::end(); ?>

</div>
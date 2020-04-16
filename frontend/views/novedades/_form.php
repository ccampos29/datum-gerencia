<?php

use frontend\models\CriteriosEvaluaciones;
use frontend\models\CriteriosEvaluacionesDetalle;
use frontend\models\EstadosChecklist;
use frontend\models\GruposNovedades;
use frontend\models\NovedadesTiposChecklist;
use frontend\models\TiposChecklist;
use frontend\models\Trabajos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Novedades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="novedades-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <label for="nombre"><i class="fa fa-user-o" aria-hidden="true"></i> Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="nombre"><i class="fa fa-user-o" aria-hidden="true"></i> Grupo Novedad</label>
            <?php
            $data = ArrayHelper::map(GruposNovedades::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'grupo_novedad_id')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione un grupo de novedad...'],
                'pluginOptions' => [

                    'tokenSeparators' => [',', ' ']
                ],
            ])->label(false)
            ?>
        </div>
        <div class="col-sm-6">
            <label for="">Genera Novedad</label>
            <?= $form->field($model, 'genera_novedades')->dropDownList(
                ['0' => 'No', '1' => 'Si'],
                [
                    'prompt' => 'Seleccione una opción...',

                ]
            )->label(false) ?>
        </div>
        <div class="col-sm-6">
            <label for="">Activo</label>
            <?= $form->field($model, 'activo')->dropDownList(
                ['0' => 'No', '1' => 'Si'],
                [
                    'prompt' => 'Seleccione una opción...',

                ]
            )->label(false) ?> </div>
        <?php if ($model->isNewRecord) : ?>
            <div class="col-sm-12">
                <label for="nombre"><i class="fa file-text-o" aria-hidden="true"></i> Criterio de Evaluación</label>
                <?php
                $data = ArrayHelper::map(CriteriosEvaluaciones::find()->all(), 'id', 'nombre');
                echo $form->field($model, 'criterio_evaluacion_id')->widget(Select2::classname(), [
                    'data' => $data,
                    'options' => ['placeholder' => 'Seleccione un grupo de novedad...'],
                    'pluginOptions' => [

                        'tokenSeparators' => [',', ' ']
                    ],
                ])->label(false)
                ?>
            </div>
            <?php else :

            $get_detail = CriteriosEvaluacionesDetalle::find()->where(['tipo_criterio_id' => $model->criterio_evaluacion_id])->all();

            if (!empty($get_detail)) {

            ?>
                <div class="col-sm-12">
                    <h4><strong>Modificación de Criterios de Evaluación:</strong> </h4>
                </div>
                <div class="col-sm-12">
                
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr class="info">
                            <th>Detalle</th>
                            <?php if ($get_detail[0]->tipoCriterio->tipo == 'Editable') : ?>
                                <th>Mínimo</th>
                                <th>Máximo</th>
                            <?php endif; ?>
                            <th>Calificación</th>
                            <th>Trabajo</th>
                            <th>Prioridad</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        foreach ($get_detail as $key => $detail) :
                        ?>
                            <?= $form->field($model, 'novedades_checklist[]')->textInput(['type' => 'hidden', 'value' => $detail->id, 'readonly' => true])->label(false) ?>

                            <tr>
                                <td>
                                    <?= $form->field($model, 'detalle[]')->textInput(['maxlength' => true, 'value' => $detail->detalle, 'readonly' => true])->label(false) ?>
                                </td>

                                <?php if ($detail->tipoCriterio->tipo == 'Editable') : ?>
                                    <td>
                                        <?= $form->field($model, 'rango_minimo[]')->textInput(['maxlength' => true, 'value' => $detail->minimo, 'readonly' => true])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'rango_maximo[]')->textInput(['maxlength' => true, 'value' => $detail->maximo, 'readonly' => true])->label(false) ?>
                                    </td>

                                <?php endif; ?>

                                <td id="calificacion<?= $key; ?>">
                                    <?= $form->field($model, 'calificacion[]')->dropDownList(
                                        ArrayHelper::map(EstadosChecklist::find()->all(), 'id', 'estado'),
                                        [
                                            'prompt' => 'Seleccione una calificación',  'class' => 'form-control calificacion-select', 'data-calificacion' => $key, 'options' =>
                                            [

                                                @$model->calificacion[$key] => ['Selected' => true]
                                            ]
                                        ]
                                    )->label(false) ?>

                                </td>
                                <td id="trabajo<?= $key; ?>">
                                    <?=
                                        $form->field($model, 'trabajo[]')->dropDownList(
                                            ArrayHelper::map(Trabajos::find()->orderBy('nombre')->all(), 'id', 'nombre'),
                                            [
                                                'prompt' => 'Seleccione un trabajo',
                                                'options' =>
                                                [
                                                    @$model->trabajo[$key] => ['Selected' => true]
                                                ]
                                            ]
                                        )->label(false) ?>
                                </td>
                                <td id="prioridad<?= $key; ?>">
                                    <?= $form->field($model, 'prioridad[]')->dropDownList(
                                        ['Bajo' => 'Bajo', 'Medio' => 'Medio', 'Urgente' => 'Urgente'],
                                        [
                                            'prompt' => 'Seleccione una prioridad',
                                            'options' =>
                                            [
                                                @$model->prioridad[$key] => ['Selected' => true]
                                            ]
                                        ]

                                    )->label(false) ?>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                </div>
        <?php
            }
        endif; ?>

        <div class="col-sm-12" style="margin-top:10px;">
            <?php
            if (!$model->isNewRecord) {
                $checkedList =  ArrayHelper::getColumn(NovedadesTiposChecklist::find()->where(['novedad_id' => $model->id])->all(), 'tipo_checklist_id'); //get selected value from db if value exist
                $model->tipo_checklist_id = $checkedList;
            }

            ?>
            <label for="nombre"><i class="fa fa-check" aria-hidden="true"></i> Seleccionar Tipos de Checklist <span style="color:red;">*</span></label>
            <?php echo $form->field($model, 'tipo_checklist_id')->inline(false)->checkboxList(
                ArrayHelper::map(TiposChecklist::find()->all(), 'id', 'nombre')
            )->label(false);
            ?>
        </div>

        <div class="col-sm-12">
            <label for="nombre"><i class="fa fa-comment" aria-hidden="true"></i> Observacion</label>
            <?= $form->field($model, 'observacion')->textarea(['rows' => 6])->label(false) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id . '/']), ['class' => 'btn btn-default']); ?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJsFile(
    '@web/js/novedades.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
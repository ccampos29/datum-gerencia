<?php

use common\models\User;
use frontend\models\EstadosChecklist;
use frontend\models\TiposUsuarios;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadosChecklistPersonal */
/* @var $form yii\widgets\ActiveForm */

!empty($_GET['idEstados']) ? $estados = EstadosChecklist::findOne($_GET['idEstados']) : $estados = 0;

$urlUsuarios = Yii::$app->urlManager->createUrl('user/nombres-usuarios-list');
$urlTipos = Yii::$app->urlManager->createUrl('tipos-usuarios/tipos-list');
?>

<div class="estados-checklist-personal-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'estado_checklist_id')->textInput([
        'value' => $estados->id,
        'class' => 'hidden',
    ])->label(false); ?>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Usuario
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
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Tipos de usuario
                </label>
                <div class="row">
                    <div class="col-xs-10">
                        <?= $form->field($model, 'tipo_usuario_id')->widget(Select2::classname(), [
                            'data' => !empty($model->tipo_usuario_id) ? [$model->tipo_usuario_id => TiposUsuarios::findOne($model->tipo_usuario_id)->descripcion] : [],
                            'options' => ['placeholder' => 'Seleccione un tipo de usuario',],

                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlTipos,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ]
                        ])->label(false)
                        ?>
                    </div>
                    <div class="col-xs-2">
                        <a href="../tipos-usuarios/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear un usuario" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <label>
                    <i class="fa fa-envelope-open-o" aria-hidden="true"></i> Email
                </label>
                <?= $form->field($model, 'email')->textInput(['readonly'=>'true'])->label(false) ?>
            </div>





        </div>
    </div>


    <div class="form-group">
        <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Volver', yii\helpers\Url::to([Yii::$app->controller->id . '/', 'idEstados' => $_GET['idEstados']]), ['class' => 'btn btn-default']); ?>
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i>  Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
        $this->registerJsFile(
            '@web/js/estado_checklist.js', ['depends' => [\yii\web\JqueryAsset::className()]]
        ); 
    ?>
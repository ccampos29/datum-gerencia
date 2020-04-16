<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\TiposUsuarios;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresas */
/* @var $form yii\widgets\ActiveForm */

$urlTiposUsuarios = Yii::$app->urlManager->createUrl('tipos-usuarios/tipos-usuarios-list');
?>

<div class="empresas-form">
    <?php if (!empty($user)) : ?>
        <?php if ($user->getErrors()) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($user->getErrors() as $error) : ?>
                        <li>
                            <?php print_r($error[0]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Nombres
                </label>
                <?= $form->field($model, 'name')->textInput()->label(false) ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-user" aria-hidden="true"></i> Apellidos
                </label>
                <?= $form->field($model, 'surname')->textInput()->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-id-card-o" aria-hidden="true"></i> Número de identificación
                </label>
                <?= $form->field($model, 'id_number')->textInput(['type' => 'number'])->label(false) ?>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-bookmark" aria-hidden="true"></i> Tipo de usuario
                </label>
                <div class="row">
                    <div class="col-sm-10">
                        <?php
                        echo $form->field($model, 'tipo_usuario_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TiposUsuarios::find()->all(), 'id', 'descripcion'),
                            'options' => [
                                
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'placeholder' => 'Seleccione',
                                'required' => true,
                                // 'minimumInputLength' => 0,
                                // 'language' => [
                                //     'errorLoading' => new JsExpression("function () { return 'Esperando por resultados...'; }"),
                                // ],
                                // 'ajax' => [
                                //     'url' => $urlTiposUsuarios,
                                //     'dataType' => 'json',
                                //     'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                // ],
                            ]

                        ])->label(false);
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <a href="../tipos-usuarios/create" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Crear tipo de usuario" target="_blank"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label>
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Nombre de usuario
                </label>
                <?= $form->field($model, 'username')->textInput()->label(false) ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-at" aria-hidden="true"></i> Correo electrónico
                </label>
                <?= $form->field($model, 'email')->label(false) ?>
            </div>
            <div class="col-sm-6">
                <label>
                    <i class="fa fa-key" aria-hidden="true"></i> Contraseña
                </label>
                <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
            </div>
        </div>


        <div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="<?= Url::to(['user/index']) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>
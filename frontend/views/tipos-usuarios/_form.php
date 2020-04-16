<?php

use backend\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposUsuarios */
/* @var $form yii\widgets\ActiveForm */


$urlRolesPermisos = Yii::$app->urlManager->createUrl('tipos-usuarios/roles-permisos-list');
?>

<div class="tipos-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'permiso_rol')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AuthItem::find()->where(['type' => 1])->andWhere('name <> "r-admin"')->andWhere('name <> "r-super-admin"')->andWhere('name <> "r-administrador-empresa"')->all(), 'name', 'name'),
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'options' => [
            'placeholder' => 'Seleccione...'
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
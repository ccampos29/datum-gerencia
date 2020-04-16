<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposUsuarios */

$this->title = 'Actualizar tipo de usuario: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-usuarios-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GruposNovedades */

$this->title = 'Actualizar Grupos Novedades: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grupos Novedades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="grupos-novedades-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

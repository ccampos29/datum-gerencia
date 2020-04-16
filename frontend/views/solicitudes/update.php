<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Solicitudes */

$this->title = 'Actualizar Solicitud N°: ' . $model->consecutivo;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Solicitud N°: '.$model->consecutivo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="solicitudes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

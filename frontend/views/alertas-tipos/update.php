<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlertasTipos */

$this->title = 'Actualizar tipo de alerta: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Alertas Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="alertas-tipos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrdenesTrabajos */

$this->title = 'Actualizar Orden de Trabajo: ' . $model->vehiculo->placa.' - '.$model->fecha_hora_orden;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa.' - '.$model->fecha_hora_orden, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ordenes-trabajos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

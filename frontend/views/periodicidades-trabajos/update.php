<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesTrabajos */

$this->title = 'Actualizar Periodicidad de Trabajo: ' . $model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Periodicidades Trabajos', 'url' => ['index', 'idTrabajo' => $model->trabajo_id]];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';

?>
<div class="periodicidades-trabajos-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idTrabajo' => $model->trabajo_id 
    ]) ?>

</div>

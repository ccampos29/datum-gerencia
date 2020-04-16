<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PeriodicidadesRutinas */

$this->title = 'Actualizar Periodicidades Rutinas: ' . $model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Periodicidades Rutinas', 'url' => ['index', 'idRutina' => $model->rutina_id]];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="periodicidades-rutinas-update">

    <?= $this->render('_form', [
        'model' => $model,
        'idRutina' => $model->rutina_id
    ]) ?>

</div>

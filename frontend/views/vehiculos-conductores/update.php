<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosConductores */

$this->title = 'Actualizar el registro: ' . $model->conductor->name.' '.$model->conductor->surname;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Conductores', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = ['label' => $model->conductor->name.' '.$model->conductor->surname, 'url' => ['view', 'id' => $model->id, 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehiculos-conductores-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

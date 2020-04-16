<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosEquipos */

$this->title = 'Actualizar el registro: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos equipos', 'url' => ['index', 'idv'=>$_GET['idv']]];
$this->params['breadcrumbs'][] = ['label' => $model->vehiculo->placa, 'url' => ['view', 'id' => $model->id, 'idv'=>$_GET['idv']]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-equipos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

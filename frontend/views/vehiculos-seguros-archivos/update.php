<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSegurosArchivos */

$this->title = 'Actualizar: ' . $model->tipoSeguro->nombre.' - '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros Archivos', 'url' => ['index', 'idv' => $_GET['idv'], 'idSeguro'=>$_GET['idSeguro']]];
$this->params['breadcrumbs'][] = ['label' => $model->tipoSeguro->nombre.' - '.$model->vehiculo->placa, 'url' => ['view', 'id' => $model->id, 'idv' => $_GET['idv'], 'idSeguro'=>$_GET['idSeguro']]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-seguros-archivos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

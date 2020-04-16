<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosSeguros */

$this->title = 'Crear vehiculos seguros';
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Seguros', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculos-seguros-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        //'idVehiculo' => $idVehiculo,
    ]) ?>

</div>

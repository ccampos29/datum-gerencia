<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestos */

$this->title = 'Actualizar: ' . $model->tipoImpuesto->nombre.' - '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos', 'url' => ['index', 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = ['label' => $model->tipoImpuesto->nombre.' - '.$model->vehiculo->placa, 'url' => ['view', 'id' => $model->id, 'idv' => $model->vehiculo_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-impuestos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

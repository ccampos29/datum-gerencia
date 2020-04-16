<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\VehiculosImpuestosArchivos */

$this->title = 'Actualizar: ' . $model->tipoImpuesto->nombre.' - '.$model->vehiculo->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos Impuestos Archivos', 'url' => ['index', 'idv' => $_GET['idv'], 'idImpuesto' => $_GET['idImpuesto']]];
$this->params['breadcrumbs'][] = ['label' => $model->tipoImpuesto->nombre.' - '.$model->vehiculo->placa, 'url' => ['view', 'id' => $model->id, 'idv' => $_GET['idv'], 'idImpuesto' => $_GET['idImpuesto']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehiculos-impuestos-archivos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

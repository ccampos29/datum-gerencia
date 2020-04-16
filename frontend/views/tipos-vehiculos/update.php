<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TiposVehiculos */

$this->title = 'Actualizar el Tipo de Vehiculo: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-vehiculos-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

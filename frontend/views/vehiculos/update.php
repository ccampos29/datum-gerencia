<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Vehiculos */

$this->title = 'Actualizar el vehiculo: ' . $model->placa;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->placa, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculos-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
